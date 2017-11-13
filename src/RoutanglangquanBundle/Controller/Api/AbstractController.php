<?php

namespace RoutanglangquanBundle\Controller\Api;

use GuzzleHttp\json_encode;
use RoutanglangquanBundle\Form\Validator\RtlqValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractController extends Controller
{

    protected function newResponse($data, $code)
    {
        $response = new Response($data, $code);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
   
    public function createInvalideBean($errors = array())
    {
        return new HttpException(Response::HTTP_BAD_REQUEST, implode($errors));
    }

    public function getEncoder()
    {
        return $this->get('security.password_encoder');
    }
}
