<?php

namespace App\Controller\Api;

use App\Entity\Security\RtlqAuthToken;
use GuzzleHttp\json_encode;
use App\Form\Validator\RtlqValidator;
use App\Service\Security\User\AuthTokenAuthenticator;
use Monolog\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


abstract class AbstractRtlqController extends AbstractController
{

    public function getController($value)
    {
        return $this->get($value);
    }

    protected function newResponse($data, $code, $array = array())
    {

        $response = new Response(json_encode($data), $code, $array);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function createInvalideBean($errors = array())
    {
        return new HttpException(Response::HTTP_BAD_REQUEST, implode($errors));
    }

    protected function returnNotFoundResponse()
    {
        return new Response(null, Response::HTTP_NOT_FOUND);
    }

    protected function returnUnAuthorizedResponse()
    {
        return new Response(null, Response::HTTP_UNAUTHORIZED);
    }

    public function extractUserByToken(Request $request): RtlqAuthToken
    {
        $authTokenHeader = $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN);
        $tokenAuth = $this->getDoctrine()
            ->getRepository(RtlqAuthToken::class)
            ->findOneBy(array("value" => $authTokenHeader));
        return $tokenAuth;
    }

    function crypter($plaintext)
    {
        $security = $this->getParameter('security');
        $key = $security['encryptage']['key'];
        $cipher =  $security['encryptage']['cipher'];

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
        return $ciphertext;
    }
    function decrypter($keyEncoded)
    {
        $security = $this->getParameter('security');
        $key = $security['encryptage']['key'];
        $cipher =  $security['encryptage']['cipher'];
        
        $c = base64_decode($keyEncoded);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        return $original_plaintext;
    }

}
