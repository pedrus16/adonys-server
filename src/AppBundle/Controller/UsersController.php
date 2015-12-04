<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\User;

class UsersController extends FOSRestController
{
    private $fields = array(
      'id',
      'firstname',
      'lastname',
      'email',
      'company',
      'roles',
    );

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
      $em = $this->getDoctrine()->getManager();
      // $fields = $em->getClassMetadata('AppBundle:User')->getFieldNames();

      $repository = $this->getDoctrine()->getRepository('AppBundle:User');
      $queryBuilder = $repository->createQueryBuilder('u');

      // Search
      $search = $request->query->get('search');
      if ($search) {
        $queryBuilder->orwhere('u.firstname LIKE :search_firstname');
        $queryBuilder->orwhere('u.lastname LIKE :search_lastname');
        $queryBuilder->orwhere('u.email LIKE :search_email');
        $queryBuilder->orwhere('u.company LIKE :search_company');
        $queryBuilder->setParameter('search_firstname', '%'. $search . '%');
        $queryBuilder->setParameter('search_lastname', '%'. $search . '%');
        $queryBuilder->setParameter('search_email', '%'. $search . '%');
        $queryBuilder->setParameter('search_company', '%'. $search . '%');
      }

      // Filters
      $filters = json_decode($request->query->get('filters'));
      if ($filters) {
        foreach ($filters as $field => $values) {
          foreach ($values as $key => $value) {
            $queryBuilder->orHaving('u.roles LIKE :roles_' . $key);
            $queryBuilder->setParameter('roles_' . $key, '%"' . $value . '"%');
          }
        }
      }

      // Order by
      $sortBy = $request->query->get('sortBy', 'id');
      $order = $request->query->get('order', 'asc');

      if (!in_array($sortBy, $this->fields)) {
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
