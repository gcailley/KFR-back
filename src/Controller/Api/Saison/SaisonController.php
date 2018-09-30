<?php

namespace App\Controller\Api\Saison;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Saison\RtlqSaisonBuilder;
use App\Form\Dto\Saison\RtlqSaisonDTO;
use App\Form\Validator\Saison\RtlqSaisonValidator;
use App\Repository\Saison\SaisonRepository;
use GuzzleHttp\json_encode;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Entity\Cotisation\RtlqCotisation;
use App\Entity\Saison\RtlqSaison;


/**
 * @Route("/saisons")
 */
class SaisonController extends AbstractCrudApiController
{
    function getName()
    {
        return 'App:Saison\RtlqSaison';
    }

    function getNameType()
    {
        return "App\Form\Type\Saison\RtlqSaisonType";
    }

    protected function getBuilder()
    {
        return new RtlqSaisonBuilder();
    }

    function newDto()
    {
        return new RtlqSaisonDTO();
    }


    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     *
     */
    public function getValidator()
    {
        return new RtlqSaisonValidator();
    }
    
    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['dateDebut' => 'DESC'];
    }


    function desactiveToutesSaisons($em, $entityMetier)
    {
        // uniquement si cette saison et la saison active
        if ($entityMetier->getActive()) {
            //1) desactive toutes les autres saisons
            $saisonsActives = $this->getDoctrine()
                ->getRepository($this->getName())
                ->findBy(array("active"=>true));

            foreach ($saisonsActives as $saisonActive) {
                $saisonActive->setActive(false);
                $em->merge($saisonActive);
            }
        }
    }

    public function preConditionCreationAction($em, $entityMetier)
    {
        $this->desactiveToutesSaisons($em, $entityMetier);
        $em->flush();
        return null;
    }

    /**
     * @Route("/active", methods={"GET"})
     */
    public function getActiveAction(Request $request)
    {
       
        $entities = $this->getDoctrine()
            ->getRepository($this->getName())
            ->findBy(array("active"=>true), null, 1 , null);
        //clean user information
        foreach($entities as $entitie) {
            $entitie->removeAllAdherents();
        }
        return $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
    }


    /**
     * @Route("/{id}/duplicate", methods={"POST"})
     */
    public function duplicationSeason($id, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        //looking for object into the database.
        $entityDB = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entityDB)) {
            throw $this->createNotFoundException();
        }
        $em = $this->getDoctrine()->getManager();

        // creation de la nouvelle saison
        // TODO mettre dans un builder
        $nouvelleSaison = new RtlqSaison();
        $debutSaison = $entityDB->getDateDebut();
        $debutSaison->modify( '+1 year' );
        $nouvelleSaison->setDateDebut($debutSaison);
        $finSaison = $entityDB->getDateFin();
        $finSaison->modify( '+1 year' );
        $nouvelleSaison->setNom('Saison ' . $debutSaison->format('Y'). '-'.$finSaison->format('Y'));
        $nouvelleSaison->setDateFin($finSaison);
        $nouvelleSaison->setActive(true);
        $nouvelleSaison = $em->merge($nouvelleSaison);
        $this->desactiveToutesSaisons($em, $nouvelleSaison);


        foreach ($entityDB->getCotisations() as $key => $value) {
            // TODO mettre dans un builder
            $nouvelleCotisation = new RtlqCotisation();
            $nouvelleCotisation->setDescription($value->getDescription());
            $nouvelleCotisation->setType($value->getType());
            $nouvelleCotisation->setNbCheque($value->getNbCheque());
            $nouvelleCotisation->setCotisation($value->getCotisation());
            $nouvelleCotisation->setRepartitionCheque($value->getRepartitionCheque());
            $nouvelleCotisation->setActive($value->getActive());
            $nouvelleCotisation->setCategorie($value->getCategorie());
            $nouvelleCotisation->setSaison($nouvelleSaison);

            dump($nouvelleCotisation);
    
            $em->merge($nouvelleCotisation);
        } 

        $em->flush();

        //////////////////////////////////////
        // SAVE ENTITIES
        //////////////////////////////////////
        return $this->newResponse(json_encode($entityDB), Response::HTTP_CREATED);
    }
}
