<?php

namespace App\Controller\Api;

use GuzzleHttp\json_encode;
use App\Form\Validator\RtlqValidator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


abstract class AbstractRtlqController extends AbstractController
{

    public function getController($value) {
        return $this->get($value);
    }

    protected function newResponse($data, $code, $array=array())
    {
        $response = new Response(json_encode($data), $code, $array);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
   
    public function createInvalideBean($errors = array())
    {
        return new HttpException(Response::HTTP_BAD_REQUEST, implode($errors));
    }
 
}
