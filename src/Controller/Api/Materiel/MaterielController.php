<?php

namespace App\Controller\Api\Materiel;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Materiel\RtlqMaterielBuilder;
use App\Form\Dto\Materiel\RtlqMaterielDTO;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use GuzzleHttp\json_encode;
use App\Form\Type\Materiel\RtlqVenteMaterielType;
use App\Form\Dto\Materiel\RtlqVenteMaterielDTO;
use App\Form\Type\Materiel\RtlqAchatMaterielType;
use App\Form\Dto\Materiel\RtlqAchatMaterielDTO;
use App\Entity\Association\RtlqAdherent;
use App\Entity\Materiel\RtlqMateriel;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Entity\Tresorie\RtlqTresorieEtat;
use App\Form\Type\Materiel\RtlqMaterielType;

/**
 * @Route("/materiels")
 */
class MaterielController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqMaterielType::class;}
    function newDtoClass(): string {return RtlqMaterielDTO::class;}
    function newBuilderClass(): string {return RtlqMaterielBuilder::class;}
    function newModeleClass(): string {return RtlqMateriel::class;}


    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['nom' => 'ASC'];
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response= true)
    {
        if ($request->query->get('association') === null) {
            return parent::getAllAction($request);
        } else {
            $association = $request->query->get('association')=="true";

            $entities = $this->getDoctrine()
                    ->getRepository($this->newModeleClass())
                    ->findBy(array("association"=>$association));

            $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
        }
    }

    /**
     * @Route("/vente", methods={"POST"})
     */
    public function vendreMateriels(Request $request, $response= true)
    {
        $data = json_decode($request->getContent(), true);
        $venteMaterielsDto = new RtlqVenteMaterielDTO();
        $form = $this->createForm(RtlqVenteMaterielType::class, $venteMaterielsDto);
        $form->submit($data);

        // recupération de l'utilisateur
        $adherentModele = $this 
                    ->getDoctrine()
                    ->getRepository(RtlqAdherent::class)
                    ->find($venteMaterielsDto->getAdherentId());
        if ($adherentModele == null) {
            throw $this->createNotFoundException("Adherent id:" . $venteMaterielsDto->getAdherentId() . " not found");
        }

        // récupération des informations génériques nécessaire pour la suite
        $categorieVenteModele = $this
            ->getDoctrine()
            ->getRepository(RtlqTresorieCategorie::class)
            ->find(RtlqTresorieCategorie::VENTE_ARMES);
        $saisonModele = $this 
            ->getDoctrine()
            ->getRepository(RtlqSaison::class)
            ->findOneBy(array("active"=>true), null, 1 , null);
        $etatAReclamerModele = $this 
            ->getDoctrine()
            ->getRepository(RtlqTresorieEtat::class)
            ->find(RtlqTresorieEtat::A_RECLAMER);

        // récupération de chaque materiels
        $materiels = array();
        $tresories = array();
        $sommeTotalAPayer = 0;
        foreach ($venteMaterielsDto->getMateriels() as $key => $value) {
            ////////////////////////////////////////////
            // MATERIELS
            ////////////////////////////////////////////
            $materielModele = $this 
            ->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->find($value->getId());

            //validation Materiel si ok update stock
            if ($materielModele == null) {
                throw $this->createNotFoundException(sprintf("Materiel [%s/%s] not found.", $value->getNom(), $value->getId()));
            }
            
            if ($materielModele->getStock() - $value->getNombre() < 0) {
                throw new BadRequestHttpException(sprintf("Stock too low for materiel [%s/%s] ] only %s available.", $value->getNom(), $value->getId(), $materielModele->getStock()));
            }
            $materielModele->setStock($materielModele->getStock() - $value->getNombre() );

            // save pour enregistrement en base
            $materiels[] = $materielModele;


            ////////////////////////////////////////////
            // TRESORIE
            ////////////////////////////////////////////
            //calcul montant à payer
            $sommeAPayer = 0;
            if ($venteMaterielsDto->getPrixAssociation()) {
                $sommeAPayer = $value->getNombre() * $materielModele->getPrixAchat(); 
            } else {
                $sommeAPayer += $value->getNombre() * $materielModele->getPrixVente(); 
            }
            $sommeTotalAPayer += $sommeAPayer;
            
            //creation de la tresorie à payer
            $tresorie = new RtlqTresorie();
            $tresorie->setAdherent($adherentModele);   
            $tresorie->setAdherentName($adherentModele->getPrenomNom());
            $tresorie->setCategorie($categorieVenteModele);
            $tresorie->setCheque($venteMaterielsDto->getCheque());
            $tresorie->setDateCreation($venteMaterielsDto->getDateVente());
            $tresorie->setDescription(sprintf("Vente de %s %s - %s",$value->getNombre(), $materielModele->getNom(), $adherentModele->getPrenomNom()));
            $tresorie->setEtat($etatAReclamerModele);
            $tresorie->setMontant($sommeAPayer);
            $tresorie->setNumeroCheque($venteMaterielsDto->getNumeroCheque());
            $tresorie->setResponsable($this->getUser()->getPrenomNom());
            $tresorie->setSaison($saisonModele);
            
            // save pour enregistrement en base
            $tresories[]=$tresorie;
        }

        //////////////////////////////////////
        // VALIDATION 
        //////////////////////////////////////
        //if ($sommeTotalAPayer != $venteMaterielsDto->getMontantTotal()) {
        //    throw new BadRequestHttpException(sprintf("Total amount is wrong [total : %s / excepted : %s].", $sommeTotalAPayer, $venteMaterielsDto->getMontantTotal()));
        //}

        //////////////////////////////////////
        // SAVE ENTITIES
        //////////////////////////////////////

        // recuperation entityManager
        $em = $this->getDoctrine()->getManager();
        foreach ($tresories as $key => $value) {
            $em->merge($value);
        }
        foreach ($materiels as $key => $value) {
            $em->merge($value);
        }
        $em->flush();
        return $this->newResponse(null, Response::HTTP_ACCEPTED);

    }



     /**
     * @Route("/achat", methods={"POST"})
     */
    public function achatMateriels(Request $request, $response= true)
    {
        $data = json_decode($request->getContent(), true);
        $achatMaterielsDto = new RtlqAchatMaterielDTO();
        $form = $this->createForm(RtlqAchatMaterielType::class, $achatMaterielsDto);
        $form->submit($data);

        // récupération des informations génériques nécessaire pour la suite
        $categorieVenteModele = $this
            ->getDoctrine()
            ->getRepository(RtlqTresorieCategorie::class)
            ->find(RtlqTresorieCategorie::ACHAT_ARMES);
        $saisonModele = $this 
            ->getDoctrine()
            ->getRepository(RtlqSaison::class)
            ->findOneBy(array("active"=>true), null, 1 , null);
        $etatAReglerModele = $this 
            ->getDoctrine()
            ->getRepository(RtlqTresorieEtat::class)
            ->find(RtlqTresorieEtat::A_REGLER);

        // récupération de chaque materiels
        $materiels = array();
        $tresories = array();
        $sommeTotalAPayer = 0;
        foreach ($achatMaterielsDto->getMateriels() as $key => $value) {
            ////////////////////////////////////////////
            // MATERIELS
            ////////////////////////////////////////////
            $materielModele = $this 
            ->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->find($value->getId());

            //validation Materiel si ok update stock
            if ($materielModele == null) {
                throw $this->createNotFoundException(sprintf("Materiel [%s/%s] not found.", $value->getNom(), $value->getId()));
            }
            if ($materielModele->getPrixAchat() == 0) {
                throw new BadRequestHttpException(sprintf("[%s] Cannot not be buy !, check the price", $value->getNom()));
            }

            if ($value->getNombre() < 0) {
                throw new BadRequestHttpException(sprintf("Number of items for '%s' is too low : %s ].", $value->getNom(), $value->getNombre()));
            }
            $materielModele->setStock($materielModele->getStock() + $value->getNombre() );

            // save pour enregistrement en base
            $materiels[] = $materielModele;


            ////////////////////////////////////////////
            // TRESORIE
            ////////////////////////////////////////////
            //calcul montant à payer
            $sommeAPayer = 0;
            $sommeAPayer += $value->getNombre() * $materielModele->getPrixAchat(); 
            $sommeTotalAPayer += $sommeAPayer;
            
        }

        //////////////////////////////////////
        // VALIDATION 
        //////////////////////////////////////
        //if ($sommeTotalAPayer != $achatMaterielsDto->getMontantTotal()) {
        //    throw new BadRequestHttpException(sprintf("Total amount is wrong [total : %s / excepted : %s].", $sommeTotalAPayer, $achatMaterielsDto->getMontantTotal()));
        //}

        //////////////////////////////////////
        // CREATE ENTITIES
        //////////////////////////////////////
        $tresorie = new RtlqTresorie();
        $tresorie->setAdherentName($achatMaterielsDto->getMagasin());
        $tresorie->setCategorie($categorieVenteModele);
        $tresorie->setCheque($achatMaterielsDto->getCheque());
        $tresorie->setDateCreation($achatMaterielsDto->getDateAchat());
        $tresorie->setDescription(sprintf("Achat chez %s",$achatMaterielsDto->getMagasin()));
        $tresorie->setEtat($etatAReglerModele);
        $tresorie->setMontant($achatMaterielsDto->getMontantTotal());
        $tresorie->setNumeroCheque($achatMaterielsDto->getNumeroCheque());
        $tresorie->setResponsable($this->getUser()->getPrenomNom());
        $tresorie->setSaison($saisonModele);

        //////////////////////////////////////
        // SAVE ENTITIES
        //////////////////////////////////////
        // // recuperation entityManager
        $em = $this->getDoctrine()->getManager();
        $em->merge($tresorie);
        foreach ($materiels as $key => $value) {
            $em->merge($value);
        }
        $em->flush();
        return $this->newResponse(null, Response::HTTP_ACCEPTED);
    }
}
