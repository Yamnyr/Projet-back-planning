<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        $data['data'] = [
            'id' => $user->getId(),
            'roles' => $user->getRoles(),
        ];

        $event->setData($data);
    }

       public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
       {
           $response = new JWTAuthenticationFailureResponse('Authentication failed', 401);
           $event->setResponse($response);
       }
}
