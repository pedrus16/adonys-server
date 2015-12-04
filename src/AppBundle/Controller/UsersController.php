<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\User;

class UsersController extends FOSRestController
{

    public function getUserAction($id)
    {
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
      $request = $this->getRequest();
      $repository = $this->getDoctrine()
        ->getRepository('AppBundle:User');

      $queryBuilder = $repository->createQueryBuilder('u');

      // Filters
      // $repository->where('p.price > :price');
      // $repository->setParameter('price', '19.99');

      // Order by
      // $queryBuilder->orderBy('u.id', 'DESC');

      $query = $queryBuilder->getQuery();

      // Pagination
      // $query->setFirstResult($limit * ($page - 1));
      // $query->setMaxResult($limit);
      $page = $request->query->get('page');
      $limit = $request->query->get('limit');
      if ($page) {
        $query->setFirstResult($limit * ($page - 1));
      }
      $query->setMaxResults($limit);

      return $query->getResult();
    }

    public function postUsersAction()
    {}

    public function putUsersAction()
    {}


}
