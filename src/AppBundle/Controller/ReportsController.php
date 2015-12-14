<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Util\SecureRandom;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\UserBundle\Model\UserManagerInterface;
use AppBundle\Entity\Report;
use AppBundle\Form\ReportType;

class ReportsController extends FOSRestController
{
    private $fields = array(
      'id',
      'period',
      'client',
      'employee',
      'status',
    );

    public function getReportAction($id)
    {

    }

    public function getReportsAction()
    {
      $request = $this->getRequest();
      $em = $this->getDoctrine()->getManager();
      // $fields = $em->getClassMetadata('AppBundle:User')->getFieldNames();

      $repository = $this->getDoctrine()->getRepository('AppBundle:Report');
      $queryBuilder = $repository->createQueryBuilder('r');

      // Search
      // $search = $request->query->get('search');
      // if ($search) {
      //   $queryBuilder->orwhere('u.firstname LIKE :search_firstname');
      //   $queryBuilder->orwhere('u.lastname LIKE :search_lastname');
      //   $queryBuilder->orwhere('u.email LIKE :search_email');
      //   $queryBuilder->orwhere('u.company LIKE :search_company');
      //   $queryBuilder->setParameter('search_firstname', '%'. $search . '%');
      //   $queryBuilder->setParameter('search_lastname', '%'. $search . '%');
      //   $queryBuilder->setParameter('search_email', '%'. $search . '%');
      //   $queryBuilder->setParameter('search_company', '%'. $search . '%');
      // }

      // Filters
      $filters = json_decode($request->query->get('filters'));
      if ($filters) {
        foreach ($filters as $field => $value) {
          if ($field === 'periodFrom' && $value) {
            $queryBuilder->orHaving('r.period >= :periodFrom');
            $queryBuilder->setParameter('periodFrom', $value);
          }
          if ($field === 'periodTo' && $value) {
            $queryBuilder->andHaving('r.period <= :periodTo');
            $queryBuilder->setParameter('periodTo', $value);
          }
        }
      }

      // Order by
      $sortBy = $request->query->get('sortBy', 'id');
      $order = $request->query->get('order', 'asc');

      if (!in_array($sortBy, $this->fields)) {
        $sortBy = 'id';
      }
      $queryBuilder->orderBy('r.' . $sortBy, $order == 'desc' ? 'desc' : 'asc');

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

    public function postReportsAction(Request $request)
    {

    }

    public function putReportsAction(Request $request, $id)
    {

    }

    public function deleteReportsAction($id)
    {

    }
}
