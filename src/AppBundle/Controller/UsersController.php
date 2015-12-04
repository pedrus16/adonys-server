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
      $sortBy = $request->query->get('sortBy');
      $order = $request->query->get('order');

      $em = $this->getDoctrine()->getManager();
      $fields = $em->getClassMetadata('AppBundle:User')->getFieldNames();
      if (!$sortBy || !in_array($sortBy, $fields)) {
        $sortBy = 'id';
      }
      $queryBuilder->orderBy('u.' . $sortBy, $order == 'desc' ? 'desc' : 'asc');

      // Pagination
      $query = $queryBuilder->getQuery();
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
