<?php

namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use FOS\UserBundle\Entity\User;

class AuthenticationSuccessListener
{
  public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
  {
      $data = $event->getData();
      $user = $event->getUser();

      $data['id'] = $user->getId();
      $data['email'] = $user->getEmail();
      $data['firstname'] = $user->getFirstname();
      $data['lastname'] = $user->getLastname();
      $data['roles'] = $user->getRoles();

      $event->setData($data);
  }
}
