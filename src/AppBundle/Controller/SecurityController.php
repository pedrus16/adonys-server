<?php

// namespace AppBundle\Controller;
//
// use FOS\RestBundle\Controller\FOSRestController;
//
// class SecurityController extends FOSRestController
// {
//   public function postLoginAction(Request $request) {
//     // just setup a fresh $task object (remove the dummy data)
//
//        $form = $this->createFormBuilder()
//            ->add('username', 'text')
//            ->add('password', 'text')
//            ->add('login', 'submit', array('label' => 'Create Task'))
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            // ... perform some action, such as saving the task to the database
//
//            return $this->redirectToRoute('task_success');
//        }
//
//        return $this->render('default/new.html.twig', array(
//            'form' => $form->createView(),
//        ));
//   }
// }
