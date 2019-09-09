<?php

namespace App\Controller\Api\Association;

use Symfony\Component\HttpFoundation\Request;
use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Form\Dto\Association\RtlqAdherentDTO;
use App\Entity\Association\RtlqAdherent;
use App\Form\Validator\Association\RtlqAdherentValidator;
use Symfony\Component\Routing\Annotation\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use App\Service\Security\User\AuthTokenAuthenticator;
use GuzzleHttp\json_encode;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Controller\Api\Tresorie\TresorieCategorieController;
use App\Controller\Api\Tresorie\TresorieController;
use App\Entity\Association\RtlqGroupe;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Cotisation\RtlqCotisation;
use App\Form\Builder\Tresorie\RtlqTresorieBuilder;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Entity\Security\RtlqAuthToken;

/**
 * @Route("/association/adherents")
 */
class AdherentController extends AbstractCrudApiController {
    private $mailer;
    private $encoder;

    public function __construct(
        \Swift_Mailer $mailer=null, 
        UserPasswordEncoderInterface $encoder=null) {
        $this->mailer = $mailer;
        $this->encoder = $encoder;
        $this->rtlqTresorieBuilder=new RtlqTresorieBuilder();
        $this->init();
    }

    function getName() {
        return 'App:Association\RtlqAdherent';
    }

    function getNameType() {
        return "App\Form\Type\Association\RtlqAdherentType";
    }

    protected function getBuilder() {
        return new RtlqAdherentBuilder($this->encoder);
    }

    function newDto() {
        return new RtlqAdherentDTO();
    }

    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['prenom' => 'ASC'];
    }

    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     *
     */
    public function getValidator() {
        return new RtlqAdherentValidator();
    }
    
    /**
     * Cas spécifique de détachement des tresories. 
     */
    protected function internalDeleteByIdAction($em, $entity) {
        $entity->removeAllTresories();
        $entity->removeCotisation();
        $entity->removeAllGroupes();
    }


    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response=true)
    {
       $scope = $request->query->get("scope");
       switch ($scope) {
           case "trombinoscope":
                $entities = $this->getDoctrine()
                                  ->getRepository($this->getName())
                                  ->findBy(
                                        array("actif"=>true), 
                                        $this->defaultSort()
                                    );
                $dto_entities = $this->builder->ofuscated($entities, $this);
                return $this->convertDto2Response( $dto_entities, $response, Response::HTTP_ACCEPTED);
                break;
           
           default:
               return parent::getAllAction($request, $response);
               break;
       }
    }

     /**
     * @Route("/{id}/send-email/{type}", methods={"POST"})
     */
    public function sendEmail($id, $type) {
        $adherent = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($adherent)) {
            throw new NotFoundHttpException("Adherent '$id' not found");
        }

       
        $mail_info = array('message' =>'', 'twig' =>'', 'data' => array());
        switch ($type) {
            case 'welcome':
                //reset password
                $this->_changePaswordAdherent($adherent);

                $mail_info['message'] = '[' . $this->getParameter('association_nom') . '] Bienvenue !';
                $mail_info['twig'] = 'emails/creation-compte.html.twig';
                $mail_info['data'] =  array(
                    'prenom' => $adherent->getPrenom(), 
                    'login' => $adherent->getUsername(), 
                    'urlReset' => $this->getParameter('url_reinitialisation'),
                    'resetToken'=> $adherent->getTokenPwd(),
                    'urlDiscord' => $this->getParameter('url_invitation_discord'),
                    'urlSite' => $this->getParameter('url_site' ),
                    'urlSiteIntranet' => $this->getParameter('url_site_intranet' ),
                    'associationNom' => $this->getParameter('association_nom'),
                    'associationTelephone' => $this->getParameter('association_telephone'));
            break;
            default:
                throw new NotFoundHttpException("Email type '$type' not found");
        }
        

        // send email avec le lien
        $message = (new \Swift_Message($mail_info['message']))
        ->setFrom($this->getParameter('association_email'))
        ->setTo($adherent->getEmail())
        ->addPart(
            $this->renderView( $mail_info['twig'], $mail_info['data']), 'text/html' );

        $this->mailer->send($message);
        
        $dto = $this->builder->modeleToDto($adherent, $this);
        return $this->newResponse(json_encode($dto), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/finalise-inscription", methods={"POST"})
     */
    public function finalizeInscription($id) {
        $adherent = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($adherent )) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        // ajouter le adherents dans le groupe USER
        $groupeModele = $this 
                    ->getDoctrine()
                    ->getRepository(RtlqGroupe::class)
                    ->findOneBy(array("role"=>'ROLE_USER'), null, 1 , null);
        $adherent->addGroupe($groupeModele);

        // get reduction de licence
        $tresorieLicenceDeduction  = sizeof($adherent->getSaisons());

        // ajouter l'adherents dans la saison active
        $saisonModele = $this 
                    ->getDoctrine()
                    ->getRepository(RtlqSaison::class)
                    ->findOneBy(array("active"=>true), null, 1 , null);
        $adherent->addSaison($saisonModele);

        // rendre l'adherent actif et public
        $adherent->setPublic(true);
        $adherent->setActif(true);
        $adherent->setLicenceEtat("TODO");

        //responsable
        $responsable = $this->getUser()->getPrenomNom();

        // Creation des tresoiries en fonction de la cotisation
        if ($adherent->getCotisation() != null) {
            $cotisation_id = $adherent->getCotisation()->getId();
            $cotisationModele = $this
                    ->getDoctrine()
                    ->getRepository(RtlqCotisation::class)
                    ->findOneBy(array("id"=>$cotisation_id), null, 1 , null);
            //creation d'une tresorie
            $tresories = $this->rtlqTresorieBuilder->createTresorieByCotisation($adherent, $responsable, $this->getDoctrine());
            foreach ($tresories as $key => $value) {
                $adherent->addTresorie($value);
            }
        } else {
            throw new BadRequestHttpException(sprintf("No Cotisation found."));
        }

        //creation de la licence
        $categorieLicence = $this->getDoctrine()->getRepository(RtlqTresorieCategorie::class)->findOneBy(array("id"=>RtlqTresorieCategorie::LICENCE), null, 1 , null);
        $licenceModele = $this 
            ->getDoctrine()
            ->getRepository(RtlqCotisation::class)
            ->findOneBy(array("active"=>true, "saison"=> $saisonModele, "categorie" => $categorieLicence), null, 1 , null);
        $tresorieLicence = $this->rtlqTresorieBuilder->createTresorieByLicence($adherent, $responsable, $licenceModele, $this->getDoctrine());
        $adherent->addTresorie($tresorieLicence);
        
        //creation de la déduction sur la licence si > 0
        if ($tresorieLicenceDeduction > 0 ) {
            $tresorieLicenceDeduction = $this->rtlqTresorieBuilder->createTresorieByLicenceDeduction($adherent, $responsable, $licenceModele, $this->getDoctrine());
            $adherent->addTresorie($tresorieLicenceDeduction);                
        }


        $em = $this->getDoctrine()->getManager();
        $em->merge($adherent);
        $em->flush();

        $dto = $this->builder->modeleToDto($adherent, $this);
        return $this->newResponse(json_encode($dto), Response::HTTP_ACCEPTED);
    }



    
    // ********************************* USER RESET PASSWORD **********************************************//
    private function _changePaswordAdherent($adherent) {
         // generation token unique
         $adherent->setTokenPwd(bin2hex(random_bytes(20)));
         // sauvegarde du token unique dans l'utilisateur
        $em = $this->getDoctrine()->getManager();
        $em->merge($adherent);
        $em->flush();
    }
    /**
     * @Route("/password-reset", methods={"POST"})
     */
    public function resetPassword(Request $request) {

        
        // recupetation de l'email
        $data = json_decode($request->getContent(), true);

        // looking for object into the database.
        $entityDB = $this->getDoctrine()
            ->getRepository($this->getName())
            ->findOneBy(array("email"=>$data['email']));
        if (!is_object($entityDB)) {
            throw new NotFoundHttpException("Adherent not found");
        }
        
        $this->_changePaswordAdherent($entityDB);

        // send email avec le lien
        $message = (new \Swift_Message('Reset Password'))
        ->setFrom($this->getParameter('association_email'))
        ->setTo($entityDB->getEmail())
        ->addPart(
            $this->renderView(
                'emails/reset-password.html.twig',
                array(
                    'prenom' => $entityDB->getPrenom(), 
                    'urlReset' => $this->getParameter('url_reinitialisation'),
                    'resetToken'=> $entityDB->getTokenPwd(),
                    'urlSite' => $this->getParameter('url_site' ),
                    'associationNom' => $this->getParameter('association_nom'),
                    'associationTelephone' => $this->getParameter('association_telephone'))
            ),
            'text/html'
        );

        $this->mailer->send($message);
        return new Response("Email sent to " . $data['email'], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/password-change", methods={"POST"})
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        // recuperation du token
        $data = json_decode($request->getContent(), true);
        $token = $data['token'];
        $password = $data['password'];
        $confirmation = $data['confirmation'];
        if ($token == '' || $password == '' || $password != $confirmation) {
            throw new BadRequestHttpException("token, password and confirmation parameter should be provided.");
        }

        // recuperation de l'utilsiateur via le token
        $entityDB = $this->getDoctrine()
        ->getRepository($this->getName())
        ->findOneBy(array("tokenPwd"=>$token));
        if (!is_object($entityDB)) {
            throw new NotFoundHttpException("Adherent not found");
        }
        // suppression du token
        $encodedPassword = $passwordEncoder->encodePassword(
//            $this->encoder,
            $this->getNewModeleInstance(),
            $password);
        $entityDB->setPassword($encodedPassword);
        $entityDB->setTokenPwd(null);

        // sauvegarde de l'utilisateur
        $em = $this->getDoctrine()->getManager();
        $em->merge($entityDB);
        $em->flush();

        // send email de confirmation
        $message = (new \Swift_Message('Reset Password accepted'))
        ->setFrom($this->getParameter('association_email'))
        ->setTo($entityDB->getEmail())
        ->addPart(
            $this->renderView(
                'emails/change-password.html.twig',
                array(
                    'prenom' => $entityDB->getPrenom(),
                    'urlSite' => $this->getParameter('url_site'),
                    'associationNom' => $this->getParameter('association_nom'),
                    'associationTelephone' => $this->getParameter('association_telephone')
                )
            ),
            'text/html'
        );

        $this->mailer->send($message);

        return new Response("Password changed", Response::HTTP_ACCEPTED);
    }

    // ********************************* COTISATION **********************************************//

    /**
     * @Route("/{id}/cotisation", methods={"GET"})
     */
    public function getUserCotisation($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity, $this);
        return new Response(json_encode($dto->getCotisationId()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/cotisation/{idCotisation}", methods={"POST"})
     */
    public function addCotisationToUser($id, $idCotisation) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $cotisation = $this->getDoctrine()->getRepository(RtlqCotisation::class)->find($idCotisation);
        if (!is_object($cotisation)) {
            throw new NotFoundHttpException("Cotisation $idCotisation not found");
        }
        //add cotisation to adherent
        $entity->setCotisation($cotisation);

        $em = $this->getDoctrine()->getManager();
        $em->merge($entity);
        $em->flush();

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/cotisation/{idCotisation}", methods={"DELETE"})
     */
    public function removeCotisationToUser($id, $idCotisation) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $cotisation = $this->getDoctrine()->getRepository(RtlqCotisation::class)->find($idCotisation);
        if (!is_object($cotisation)) {
            throw new NotFoundHttpException("Cotisation $idCotisation not found");
        }
        if ($this->getValidator()->hasCotisation($entity, $cotisation)) {
            //add cotisation to adherent
            $entity->setCotisation(null);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }



    // ********************************* TOAS **********************************************//

    /**
     * @Route("/{id}/taos", methods={"GET"})
     */
    public function getUserTaos($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity, $this);
        return new Response(json_encode($dto->getTaos()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/taos/{idTao}", methods={"POST"})
     */
    public function addTaoToUser($id, $idTao) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $tao = $this->getDoctrine()->getRepository("App\Entity\Kungfu\RtlqKungfuTao")->find($idTao);
        if (!is_object($tao)) {
            throw new NotFoundHttpException("Tao $idTao not found");
        }

        if (!$this->getValidator()->hasTao($entity, $tao)) {
            //add Tao to adherent
            $entity->addTao($tao);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }
        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/taos/{idTao}", methods={"DELETE"})
     */
    public function removeTaoToUser($id, $idTao) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository("App\Entity\Kungfu\RtlqKungfuTao")->find($idTao);
        if (!is_object($entityAssociate)) {
            throw new NotFoundHttpException("Tao $idTao not found");
        }
        if ($this->getValidator()->hasTao($entity, $entityAssociate)) {
            //add tao to adherent
            $entity->removeTao($entityAssociate);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    

    // ********************************* GROUPE **********************************************//

    /**
     * @Route("/{id}/groupes", methods={"GET"})
     */
    public function getUserGroupes($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity, $this);
        return new Response(json_encode($dto->getGroupes()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/groupes/{idGroupe}", methods={"POST"})
     */
    public function addGroupeToUser($id, $idGroupe) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $groupe = $this->getDoctrine()->getRepository("App\Entity\Association\RtlqGroupe")->find($idGroupe);
        if (!is_object($groupe)) {
            throw new NotFoundHttpException("Groupe $idGroupe not found");
        }

        if (!$this->getValidator()->hasGroupe($entity, $groupe)) {
            //add groupe to adherent
            $entity->addGroupe($groupe);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }
        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/groupes/{idGroupe}", methods={"DELETE"})
     */
    public function removeGroupeToUser($id, $idGroupe) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository("App\Entity\Association\RtlqGroupe")->find($idGroupe);
        if (!is_object($entityAssociate)) {
            throw new NotFoundHttpException("Groupe $idGroupe not found");
        }
        if ($this->getValidator()->hasGroupe($entity, $entityAssociate)) {
            //add cotisation to adherent
            $entity->removeGroupe($entityAssociate);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    // ********************************* TRESORIE **********************************************//
    /**
     * @Route("/{id}/tresories", methods={"GET"})
     */
    public function getUserTresories($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity, $this);
        return new Response(json_encode($dto->getTresories()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/tresories/{idEntityAssociate}", methods={"POST"})
     */
    public function addTresorieToUser($id, $idEntityAssociate) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository("App\Entity\Tresorie\RtlqTresorie")->find($idEntityAssociate);
        if (!is_object($entityAssociate)) {
            throw new NotFoundHttpException("Tresorie $idEntityAssociate not found");
        }

        if (!$this->getValidator()->hasTresorie($entity, $entityAssociate)) {
            //add tresorie to adherent
            $entity->addTresorie($entityAssociate);
            $entityAssociate->setAdherent($entity);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->merge($entityAssociate);
            $em->flush();

        }

        return $this->newResponse(json_encode($entity), Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/tresories/{idEntityAssociate}", methods={"DELETE"})
     */
    public function removeTresorieToUser($id, $idEntityAssociate) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository("App\Entity\Tresorie\RtlqTresorie")->find($idEntityAssociate);
        if (!is_object($entityAssociate)) {
            throw new NotFoundHttpException("Tresorie $idEntityAssociate not found");
        }
        if ($this->getValidator()->hasTresorie($entity, $entityAssociate)) {
            //add cotisation to adherent
            $entity->removeTresorie($entityAssociate);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @Route("/by-token", methods={"GET"})
     */
    public function getUserByToken(Request $request) {
        $authTokenHeader = $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN);
        $entityAssociate = $this->getDoctrine()
                ->getRepository(RtlqAuthToken::class)
                    ->findOneBy(array("value"=>$authTokenHeader));
        if (!is_object($entityAssociate)) {
            throw new createAccessDeniedException();
        }
        //get user information based on the id associate from the token
        return $this->getByIdAction($request, $entityAssociate->getUser()->getId());
    }
}
