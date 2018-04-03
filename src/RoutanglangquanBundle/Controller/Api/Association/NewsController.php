<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqNewsBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqNewsDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


/**
 * @Route("/association/news")
 */
class NewsController extends AbstractCrudApiController
{
    protected $_messages_rss = null;


    function getName()
    {
        return 'RoutanglangquanBundle:Association\RtlqNews';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqNewsType";
    }

    protected function getBuilder()
    {
        return new RtlqNewsBuilder();
    }

    function newDto()
    {
        return new RtlqNewsDTO();
    }

    function getRssMsg($value){
        if ($this->_messages_rss === null) {
            $this->_messages_rss = $this->container->getParameter('rss');
        }

        return $this->_messages_rss[$value];
    }


    /**
     * @Route("")
     * @Method("GET")
     */
    public function getAllAction(Request $request)
    {
        if ($request->query->get('latest')  === 'true') {
            $dto_entities = $this->getOnlyLastestNews($request);
        } else {
            $dto_entities = parent::getAllAction($request, false);
        }

        if ($request->query->get('format')  === 'rss') {

            $info=[];
            $info['description']=$this->getRssMsg('description');
            $info['author']=$this->getRssMsg('author');
            $info['publication']=date('r');
            $info['title']=$this->getRssMsg('title');
            $info['email']=$this->getRssMsg('email');
            $info['url']=$this->getRssMsg('url');
            $info['image_url'] = $this->getRssMsg('image_url');

            return $this->render('RoutanglangquanBundle:flux:rss.html.twig',array('info'=> $info, 'items' => $dto_entities));
        } else {
            return new Response(json_encode($dto_entities), Response::HTTP_ACCEPTED);
        }
    }
    
    private function getOnlyLastestNews($request) {

        $entities = $this->getDoctrine()
            ->getRepository($this->getName())
            ->loadLastestNews(30);

        if ($entities === null || empty($entities)) {
            $dto_entities = [];
        } else {
            $dto_entities = $this->builder->modelesToDtos($entities, $this);
        }
        return $dto_entities;
    }

}
