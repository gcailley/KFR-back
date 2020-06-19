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
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Entity\Kungfu\RtlqKungfuAdherentTao;
use App\Form\Builder\Tresorie\RtlqTresorieBuilder;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Entity\Security\RtlqAuthToken;
use App\Entity\Tresorie\RtlqTresorie;
use App\Form\Builder\Association\RtlqAdherentLightBuilder;
use App\Form\Builder\Kungfu\RtlqKungfuAdherentTaoBuilder;
use App\Form\Builder\Kungfu\RtlqKungfuTaoBuilder;
use App\Form\Dto\Association\RtlqAdherentLightDTO;
use App\Form\Dto\Association\RtlqAdherentStatsDTO;
use App\Form\Dto\Association\RtlqAdherentTrombinoscopeDTO;
use App\Form\Dto\Kungfu\RtlqKungfuAdherentTaoDTO;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Form\Dto\Tresorie\RtlqTresorieDTO;
use App\Form\Type\Association\RtlqAdherentType;
use App\Form\Type\Kungfu\RtlqKungfuAdherentTaoType;
use Psr\Log\LoggerInterface;

/**
 * @Route("/association/adherents")
 */
class AdherentController extends AbstractCrudApiController
{
    public const URI_AVATAR = '/association/adherents/avatar/';
    private $mailer;
    private $encoder;
    protected $logger;

    public function __construct(
        \Swift_Mailer $mailer = null,
        UserPasswordEncoderInterface $encoder = null
    ) {
        $this->mailer = $mailer;
        $this->encoder = $encoder;
        $this->rtlqTresorieBuilder = new RtlqTresorieBuilder();
        $this->rtlqTaoBuilder = new RtlqKungfuTaoBuilder();
        $this->rtlqAdherentTaoBuilder = new RtlqKungfuAdherentTaoBuilder();
        $this->rtlqAdherentLightBuilder = new RtlqAdherentLightBuilder();
        $this->init();
    }


    /**
     * @internal
     * @required
     */
    public function setLogger(LoggerInterface $logger): ?LoggerInterface
    {
        $this->logger = $logger;

        return $logger;
    }


    public function initBuilder()
    {
        return new RtlqAdherentBuilder($this->encoder);
    }

    function newTypeClass(): string
    {
        return RtlqAdherentType::class;
    }
    function newDtoClass(): string
    {
        return RtlqAdherentDTO::class;
    }
    function newBuilderClass(): string
    {
        return RtlqAdherentBuilder::class;
    }
    function newModeleClass(): string
    {
        return RtlqAdherent::class;
    }


    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['actif' => 'DESC', 'prenom' => 'ASC'];
    }

    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     *
     */
    public function getValidator()
    {
        return new RtlqAdherentValidator();
    }

    /**
     * Cas spécifique de détachement des tresories. 
     */
    protected function internalDeleteByIdAction($em, $entity)
    {
        $entity->removeAllTresories();
        $entity->removeCotisation();
        $entity->removeAllGroupes();
    }


    protected function innerCreateAction($em, $entityMetier)
    {
        $this->savePhotoIntoFile($entityMetier);
    }
    protected function innerUpdateAction($em, $entityMetier)
    {
        $this->savePhotoIntoFile($entityMetier);
    }
    protected function innerGetAction($em, $entityMetier)
    {
        if (null === $entityMetier->getAvatarName()) {
            $this->savePhotoIntoFile($entityMetier);
        }
    }


    /**
     * Methode permettant de sauvegarder l'image dans la base utilisauteur.
     *
     * @param [type] $entityMetier
     * @return void
     */
    private function savePhotoIntoFile(RtlqAdherent $entityMetier)
    {
        $patternPhotoUser = 'user' . $entityMetier->getId();
        $photosDir = $this->getSharedPhotoDirectory();
        //recuperation de la liste des photos de l'utilisateur pour suppression apres enregistrement
        $files = $this->dirToArray($photosDir, $patternPhotoUser);

        //extract information sur la photo
        $avatarName = $patternPhotoUser . '_' . md5(uniqid(rand(), true)) . '.jpeg';
        $file_path = $photosDir . DIRECTORY_SEPARATOR .  $avatarName;

        $base64 = $entityMetier->getAvatar();
        if ("resource" === gettype($base64)) {
            $base64String = stream_get_contents($base64);
        } else {
            $base64String = $base64;
        }

        if (null != $base64String) {
            //creation de la photo sur le serveur
            $decoded = base64_decode(substr($base64String, 22));
            if (file_put_contents($file_path, $decoded)) {
                //suppression des vieilles images
                foreach ($files as $file) {
                    unlink($photosDir . DIRECTORY_SEPARATOR . $file);
                }
            }

            //Sauvegarde de la photo dans l'entité metier
            $entityMetier->setAvatarName(AdherentController::URI_AVATAR . $avatarName);
            $entityMetier->setAvatar(null);
        }
    }


    /**
     * @Route("/trombinoscope", methods={"GET"})
     */
    public function getTrombinoscopeAction(Request $request)
    {
        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->findBy(
                array("actif" => true),
                $this->defaultSort()
            );
        $dto_entities = $this->getBuilder()->ofuscated($entities, RtlqAdherentTrombinoscopeDTO::class);
        return $this->newResponse($dto_entities, Response::HTTP_ACCEPTED);
    }


    /**
     * @Route("/avatar/{avatarName}", methods={"GET"})
     */
    public function getPhotoAdherentAction(Request $request, String $avatarName)
    {
        $photosDir = $this->getSharedPhotoDirectory();
        // TODO blocage des .. pour remonter dans l'arborscence //
        if ($avatarName === "") {
            throw $this->createNotFoundException();
        }

        // decode image
        $fileName = $photosDir . DIRECTORY_SEPARATOR  . $avatarName;
        $decoded = (file_get_contents($fileName));

        //Sauvegarde de la photo dans l'entité metier
        $minetype = mime_content_type($fileName);
        $filesize = filesize($fileName);

        //extraction à l'upload de ces informations puis à mettre dans la base de données
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $minetype);
        $response->headers->set('Content-Disposition', 'attachement: filename="' . basename($fileName) . "';");
        $response->headers->set('Content-length', $filesize);

        // Send headers before outputting anything
        $response->sendHeaders();
        $response->setContent($decoded);

        return  $response;
    }


    /**
     * @Route("/liste", methods={"GET"})
     */
    public function getListeAction(Request $request)
    {
        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->findBy(
                [],
                $this->defaultSort()
            );
        $dto_entities = $this->rtlqAdherentLightBuilder->modelesToDtos($entities, RtlqAdherentLightDTO::class, $this->getDoctrine());
        return $this->newResponse($dto_entities, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response = true)
    {
        return parent::getAllAction($request, $response);
    }

    /**
     * @Route("/{id}/send-email/{type}", methods={"POST"})
     */
    public function sendEmail($id, $type)
    {
        $adherent = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($adherent)) {
            throw new NotFoundHttpException("Adherent '$id' not found");
        }


        $mail_info = array('message' => '', 'twig' => '', 'data' => array());
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
                    'resetToken' => $adherent->getTokenPwd(),
                    'urlDiscord' => $this->getParameter('url_invitation_discord'),
                    'urlSite' => $this->getParameter('url_site'),
                    'urlSiteIntranet' => $this->getParameter('url_site_intranet'),
                    'associationNom' => $this->getParameter('association_nom'),
                    'associationTelephone' => $this->getParameter('association_telephone')
                );
                break;
            default:
                throw new NotFoundHttpException("Email type '$type' not found");
        }


        // send email avec le lien
        $message = (new \Swift_Message($mail_info['message']))
            ->setFrom($this->getParameter('association_email'))
            ->setTo($adherent->getEmail())
            ->addPart(
                $this->renderView($mail_info['twig'], $mail_info['data']),
                'text/html'
            );

        $this->mailer->send($message);

        $dto = $this->getBuilder()->modeleToDto($adherent, $this->newDtoClass(), $this->getDoctrine());
        return $this->newResponse($dto, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/finalise-inscription", methods={"POST"})
     */
    public function finalizeInscription($id)
    {
        $adherent = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($adherent)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        // ajouter le adherents dans le groupe USER
        $groupeModele = $this
            ->getDoctrine()
            ->getRepository(RtlqGroupe::class)
            ->findOneBy(array("role" => 'ROLE_USER'), null, 1, null);
        $adherent->addGroupe($groupeModele);

        // get reduction de licence
        $tresorieLicenceDeduction  = sizeof($adherent->getSaisons());

        // ajouter l'adherents dans la saison active
        $saisonModele = $this
            ->getDoctrine()
            ->getRepository(RtlqSaison::class)
            ->findOneBy(array("active" => true), null, 1, null);
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
                ->findOneBy(array("id" => $cotisation_id), null, 1, null);
            //creation d'une tresorie
            $tresories = $this->rtlqTresorieBuilder->createTresorieByCotisation($adherent, $responsable, $this->getDoctrine());
            foreach ($tresories as $key => $value) {
                $adherent->addTresorie($value);
            }
        } else {
            throw new BadRequestHttpException(sprintf("No Cotisation found."));
        }

        //creation de la licence
        $categorieLicence = $this->getDoctrine()->getRepository(RtlqTresorieCategorie::class)->findOneBy(array("id" => RtlqTresorieCategorie::LICENCE), null, 1, null);
        $licenceModele = $this
            ->getDoctrine()
            ->getRepository(RtlqCotisation::class)
            ->findOneBy(array("active" => true, "saison" => $saisonModele, "categorie" => $categorieLicence), null, 1, null);
        $tresorieLicence = $this->rtlqTresorieBuilder->createTresorieByLicence($adherent, $responsable, $licenceModele, $this->getDoctrine());
        $adherent->addTresorie($tresorieLicence);

        //creation de la déduction sur la licence si > 0
        if ($tresorieLicenceDeduction > 0) {
            $tresorieLicenceDeduction = $this->rtlqTresorieBuilder->createTresorieByLicenceDeduction($adherent, $responsable, $licenceModele, $this->getDoctrine());
            $adherent->addTresorie($tresorieLicenceDeduction);
        }


        $em = $this->getDoctrine()->getManager();
        $em->merge($adherent);
        $em->flush();

        $dto = $this->getBuilder()->modeleToDto($adherent, $this->newDtoClass(), $this->getDoctrine());
        return $this->newResponse(($dto), Response::HTTP_ACCEPTED);
    }




    // ********************************* USER RESET PASSWORD **********************************************//
    private function _changePaswordAdherent($adherent)
    {
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
    public function resetPassword(Request $request)
    {


        // recupetation de l'email
        $data = json_decode($request->getContent(), true);

        // looking for object into the database.
        $entityDB = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->findOneBy(array("email" => $data['email']));
        if (!is_object($entityDB)) {
            throw new NotFoundHttpException("Adherent not found");
        }

        $this->_changePaswordAdherent($entityDB);

        // send email avec le lien
        $message = (new \Swift_Message('[' . $this->getParameter('association_nom') . '] Change ton mot de passe !'))
            ->setFrom($this->getParameter('association_email'))
            ->setTo($entityDB->getEmail())
            ->addPart(
                $this->renderView(
                    'emails/reset-password.html.twig',
                    array(
                        'prenom' => $entityDB->getPrenom(),
                        'urlReset' => $this->getParameter('url_reinitialisation'),
                        'resetToken' => $entityDB->getTokenPwd(),
                        'urlSite' => $this->getParameter('url_site'),
                        'urlSiteIntranet' => $this->getParameter('url_site_intranet'),
                        'associationNom' => $this->getParameter('association_nom'),
                        'associationTelephone' => $this->getParameter('association_telephone')
                    )
                ),
                'text/html'
            );

        $this->mailer->send($message);
        return $this->newResponse((array('message' => "Email sent to " . $data['email'])), Response::HTTP_ACCEPTED);
    }



    /**
     * @Route("/password-change", methods={"POST"})
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

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
            ->getRepository($this->newModeleClass())
            ->findOneBy(array("tokenPwd" => $token));
        if (!is_object($entityDB)) {
            throw new NotFoundHttpException("Adherent not found");
        }
        // suppression du token
        $encodedPassword = $passwordEncoder->encodePassword(
            //            $this->encoder,
            $this->getNewModeleInstance(),
            $password
        );
        $entityDB->setPassword($encodedPassword);
        $entityDB->setTokenPwd(null);

        // sauvegarde de l'utilisateur
        $em = $this->getDoctrine()->getManager();
        $em->merge($entityDB);
        $em->flush();

        // send email de confirmation
        $message = (new \Swift_Message('[' . $this->getParameter('association_nom') . '] Confirmation de changement de mot de passe'))
            ->setFrom($this->getParameter('association_email'))
            ->setTo($entityDB->getEmail())
            ->addPart(
                $this->renderView(
                    'emails/change-password.html.twig',
                    array(
                        'prenom' => $entityDB->getPrenom(),
                        'urlSite' => $this->getParameter('url_site'),
                        'urlSiteIntranet' => $this->getParameter('url_site_intranet'),
                        'associationNom' => $this->getParameter('association_nom'),
                        'associationTelephone' => $this->getParameter('association_telephone')
                    )
                ),
                'text/html'
            );

        $this->mailer->send($message);

        return $this->newResponse((array('message' => "Mot de passe changé.")), Response::HTTP_ACCEPTED);
    }

    // ********************************* COTISATION **********************************************//

    /**
     * @Route("/{id}/cotisation", methods={"GET"})
     */
    public function getUserCotisation($id)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->getBuilder()->modeleToDto($entity, $this->newDtoClass(), $this->getDoctrine());
        return new Response(json_encode($dto->getCotisationId()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/cotisation/{idCotisation}", methods={"POST"})
     */
    public function addCotisationToUser($id, $idCotisation)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
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
    public function removeCotisationToUser($id, $idCotisation)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
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
    public function getUserTaos($id)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            return $this->returnNotFoundResponse();
        }

        // recuperation des lignes de taos de l'utilisateur
        $entitiesAssociate = $this->getDoctrine()
            ->getRepository(RtlqKungfuAdherentTao::class)
            ->findAllTaoFilterByAdherent($entity->getId());
        if (sizeof($entitiesAssociate) == 0) {
            return $this->returnNotFoundResponse();
        }

        // conversion modele en DTO
        $dtos = $this->rtlqAdherentTaoBuilder->modelesToDtos($entitiesAssociate, RtlqKungfuAdherentTaoDTO::class, $this->getDoctrine());

        //get user information based on the id associate from the token
        return $this->returnNewResponse($dtos, Response::HTTP_ACCEPTED, false);
    }

    /**
     * @Route("/{id}/taos/{idTao}", methods={"PUT"})
     */
    public function updateTaoToUser($id, $idTao, Request $request)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $taoJointure = $this->getDoctrine()
            ->getRepository(RtlqKungfuAdherentTao::class)
            ->findTaoFilterByAdherentAndTao($id, $idTao);
        if (sizeof($taoJointure) === 0) {
            throw new NotFoundHttpException("Tao $idTao not found for this user");
        }

        $data = json_decode($request->getContent(), true);
        $adhTaoDto = new RtlqKungfuAdherentTaoDTO();
        $adhTaoBuilder = new RtlqKungfuAdherentTaoBuilder();
        $form = $this->createForm(RtlqKungfuAdherentTaoType::class, $adhTaoDto);
        $form->submit($data);
        //validation de l'object DTO
        $errors = $this->getValidator()->doPutValidateDto($adhTaoDto);
        if ($errors != null && sizeof($errors) != 0) {
            throw $this->createInvalideBean($errors);
        }
        // convertion to Modele
        $entityMetier =  $taoJointure[0];
        $entityMetier = $adhTaoBuilder->updateModele($entityMetier, $adhTaoDto);

        $em = $this->getDoctrine()->getManager();
        $em->merge($entityMetier);
        $em->flush();

        // conversion modele en DTO
        $dtos = $this->rtlqAdherentTaoBuilder->modeleToDto($entityMetier, RtlqKungfuAdherentTaoDTO::class, $this->getDoctrine());
        return $this->newResponse(($dtos), Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/taos/{idTao}", methods={"POST"})
     */
    public function addTaoToUser($id, $idTao)
    {
        $adherent = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($adherent)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $tao = $this->getDoctrine()->getRepository(RtlqKungfuTao::class)->find($idTao);
        if (!is_object($tao)) {
            throw new NotFoundHttpException("Tao $idTao not found");
        }

        $adherentTao = $this->getValidator()->hasTao($adherent, $tao);

        if ($adherentTao == null) {

            $adherentTao = new RtlqKungfuAdherentTao();
            $adherentTao->setAdherent($adherent);
            $adherentTao->setTao($tao);

            //add Tao to adherent
            $adherent->addTao($adherentTao);
            $em = $this->getDoctrine()->getManager();
            $em->merge($adherent);
            $em->flush();
        }

        // conversion modele en DTO
        $dtos = $this->rtlqAdherentTaoBuilder->modeleToDto($adherentTao, RtlqKungfuAdherentTaoDTO::class, $this->getDoctrine());
        return $this->newResponse(($dtos), Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/taos/{idTao}", methods={"DELETE"})
     */
    public function removeTaoToUser($id, $idTao)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $tao = $this->getDoctrine()->getRepository(RtlqKungfuTao::class)->find($idTao);
        if (!is_object($tao)) {
            throw new NotFoundHttpException("Tao $idTao not found");
        }

        $adherentTao = $this->getValidator()->hasTao($entity, $tao);
        if ($adherentTao != null) {
            $adherentTao->removeAdherent();
            $adherentTao->removeTao();

            //add tao to adherent
            $entity->removeTao($adherentTao);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->remove($adherentTao);
            $em->flush();
        }
        return new Response(null, Response::HTTP_NO_CONTENT);
    }



    // ********************************* GROUPE **********************************************//

    /**
     * @Route("/{id}/groupes", methods={"GET"})
     */
    public function getUserGroupes($id)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->getBuilder()->modeleToDto($entity, $this->newDtoClass(), $this->getDoctrine());
        return new Response(json_encode($dto->getGroupes()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/groupes/{idGroupe}", methods={"POST"})
     */
    public function addGroupeToUser($id, $idGroupe)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $groupe = $this->getDoctrine()->getRepository(RtlqGroupe::class)->find($idGroupe);
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
    public function removeGroupeToUser($id, $idGroupe)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository(RtlqGroupe::class)->find($idGroupe);
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
    public function getUserTresories($id)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->getBuilder()->modeleToDto($entity, $this->newDtoClass(), $this->getDoctrine());
        return new Response(json_encode($dto->getTresories()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/tresories/{idEntityAssociate}", methods={"POST"})
     */
    public function addTresorieToUser($id, $idEntityAssociate)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository(RtlqTresorie::class)->find($idEntityAssociate);
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

        return $this->newResponse(($entity), Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/tresories/{idEntityAssociate}", methods={"DELETE"})
     */
    public function removeTresorieToUser($id, $idEntityAssociate)
    {
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository(RtlqTresorie::class)->find($idEntityAssociate);
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
    public function getUserByToken(Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        //get user information based on the id associate from the token
        return $this->getByIdAction($request, $tokenAuth->getUser()->getId());
    }

    /**
     * @Route("/by-token", methods={"PUT"})
     */
    public function putUserByToken(Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        return $this->updateAction($tokenAuth->getUser()->getId(), $request);
    }

    /**
     * @Route("/by-token/mytresoreries", methods={"GET"})
     */
    public function getUserTresoreriesByToken(Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        // recuperation des lignes de tresoreries de l'utilisateur
        $entitiesAssociate = $this->getDoctrine()
            ->getRepository(RtlqTresorie::class)
            ->findAllTresorieFilterByAdherent($tokenAuth->getUser()->getId());
        if (sizeof($entitiesAssociate) == 0) {
            return $this->returnNotFoundResponse();
        }

        // conversion modele en DTO
        $dtos = $this->rtlqTresorieBuilder->modelesToDtos($entitiesAssociate, RtlqTresorieDTO::class, $this->getDoctrine());

        //get user information based on the id associate from the token
        return $this->returnNewResponse($dtos, Response::HTTP_ACCEPTED, false);
    }


    /**
     * @Route("/by-token/mytaos", methods={"GET"})
     */
    public function getUserTaosByToken(Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        // recuperation des lignes de taos de l'utilisateur
        $entitiesAssociate = $this->getDoctrine()
            ->getRepository(RtlqKungfuAdherentTao::class)
            ->findAllTaoFilterByAdherent($tokenAuth->getUser()->getId());
        if (sizeof($entitiesAssociate) == 0) {
            return $this->returnNotFoundResponse();
        }

        // conversion modele en DTO
        $dtos = $this->rtlqAdherentTaoBuilder->modelesToDtos($entitiesAssociate, RtlqKungfuAdherentTaoDTO::class, $this->getDoctrine());

        //get user information based on the id associate from the token
        return $this->returnNewResponse($dtos, Response::HTTP_ACCEPTED, false);
    }

    /**
     * @Route("/by-token/mytaos/{idTao}", methods={"POST"})
     */
    public function addTaoByToken($idTao, Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        return $this->addTaoToUser($tokenAuth->getUser()->getId(), $idTao);
    }

    /**
     * @Route("/by-token/mytaos/{idTao}", methods={"DELETE"})
     */
    public function removeTaoByToken($idTao, Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        return $this->removeTaoToUser($tokenAuth->getUser()->getId(), $idTao);
    }

    /**
     * @Route("/by-token/mytaos/{idTao}", methods={"PUT"})
     */
    public function updateTaoByToken($idTao, Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }
        $idUser = $tokenAuth->getUser()->getId();

        return $this->updateTaoToUser($idUser, $idTao, $request);
    }
    /**
     * @Route("/by-iduser-{idUser}/mytaos/{idTao}", methods={"PUT"})
     */
    public function updateTaoByIdUser($idUser, $idTao, Request $request)
    {
        // checkng user
        $entity = $this->getDoctrine()->getRepository(RtlqAdherent::class)->find($idUser);
        if (!is_object($entity)) {
            return $this->returnNotFoundResponse();
        }

        return $this->updateTaoToUser($idUser, $idTao, $request);
    }


    /**
     * @Route("/by-token/myStats", methods={"GET"})
     * 
     * Methode permettant la récupéation des stats d'un adhérent
     *  - tao
     *      nb_ao
     *      nb_tao_total
     *      pourcentage_avancement
     */
    public function getUserStats(Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        // recuperation des lignes de taos de l'utilisateur
        $nbTaoOfUser = $this->getDoctrine()
            ->getRepository(RtlqKungfuAdherentTao::class)
            ->countAllTaoFilterByAdherent($tokenAuth->getUser()->getId());

        // recuperation des lignes de taos de l'utilisateur
        $nbTao = $this->getDoctrine()
            ->getRepository(RtlqKungfuTao::class)
            ->countAllTaoActif($tokenAuth->getUser()->getId());

        // recuperation des lignes de taos de l'utilisateur
        $infoTresorerieEnRetard = $this->getDoctrine()
            ->getRepository(RtlqTresorie::class)
            ->infoTresorieEnRetardFilterByAdherent($tokenAuth->getUser()->getId());

        $stats = new RtlqAdherentStatsDTO($nbTaoOfUser, $nbTao, abs($infoTresorerieEnRetard[0]['montant']), $infoTresorerieEnRetard[0]['date']);

        //get user information based on the id associate from the token
        return $this->returnNewResponse($stats, Response::HTTP_ACCEPTED, false);
    }
}
