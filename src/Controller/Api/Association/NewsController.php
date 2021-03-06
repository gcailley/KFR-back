<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Association\RtlqNews;
use App\Form\Builder\Association\RtlqNewsBuilder;
use App\Form\Dto\Association\RtlqNewsDTO;
use App\Form\Type\Association\RtlqNewsType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * @Route("/association/news")
 */
class NewsController extends AbstractCrudApiController
{
    protected $_messages_rss = null;
    private $params;

    public function __construct(ParameterBagInterface $params) {
        parent::__construct();
        $this->params = $params;
    }

    function newTypeClass(): string {return RtlqNewsType::class;}
    function newDtoClass(): string {return RtlqNewsDTO::class;}
    function newBuilderClass(): string {return RtlqNewsBuilder::class;}
    function newModeleClass(): string {return RtlqNews::class;}


    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['dateCreation' => 'DESC'];
    }

    function getRssMsg($value){
        if ($this->_messages_rss === null) {
            $this->_messages_rss = $this->params->get('rss');
        }

        return $this->_messages_rss[$value];
    }


    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response = true)
    {
        if ($request->query->get('last30days')  === 'true') {
            $dto_entities = $this->getOnlyLast30Days($request);
        } elseif ($request->query->get('latest')  === 'true') {
            $dto_entities = $this->getOnlyLastestNews($request);
        } elseif ($request->query->get('format')  === 'rss') {
            $dto_entities = $this->getOnlyLast6Month($request);
        } else {
            $dto_entities = parent::getAllAction($request, false);
        }

        if ($request->query->get('format')  === 'rss') {

            $info=[];
            $info['description']=($this->getRssMsg('description'));
            $info['author']=$this->getRssMsg('author');
            $info['publication']=date('r');
            $info['title']=$this->getRssMsg('title');
            $info['email']=$this->getRssMsg('email');
            $info['url']=$this->getRssMsg('url');
            $info['image_url'] = $this->getRssMsg('image_url');

            return $this->render('flux/rss.html.twig',array('info'=> $info, 'items' => $dto_entities));
        } else {
            return new Response(json_encode($dto_entities), Response::HTTP_ACCEPTED);
        }
    }
    
    private function getOnlyLastestNews($request) {

        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->loadLastestNews(5);

        if ($entities === null || empty($entities)) {
            $dto_entities = [];
        } else {
            $dto_entities = $this->getBuilder()->modelesToDtos($entities, $this->newDtoClass(), $this->getDoctrine());
        }
        return $dto_entities;
    }

    private function getOnlyLast30Days($request) {
        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->loadLastestNewsXDays(30);

        if ($entities === null || empty($entities)) {
            $dto_entities = [];
        } else {
            $dto_entities = $this->getBuilder()->modelesToDtos($entities, $this->newDtoClass(), $this->getDoctrine());
        }
        return $dto_entities;
    }

    private function getOnlyLast6Month($request) {
        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->loadLastestNewsXDays(180);

        if ($entities === null || empty($entities)) {
            $dto_entities = [];
        } else {
            $dto_entities = $this->getBuilder()->modelesToDtos($entities, $this->newDtoClass(), $this->getDoctrine());
        }
        return $dto_entities;
    }
}
