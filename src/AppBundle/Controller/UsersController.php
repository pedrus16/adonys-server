<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\User;

class UsersController extends FOSRestController
{

    public function getUserAction($id)
    {
      // $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
      $user = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->find($id);

      if (!$user) {
          throw $this->createNotFoundException(
              'No user found for id ' . $id
          );
      }

      return $user;
    }

    public function getUsersAction()
    {
      // $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
      $users = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->findAll();

      return $users;
    }

    public function postUsersAction()
    {}

    public function putUsersAction()
    {}


}
