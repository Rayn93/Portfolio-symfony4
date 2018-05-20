<?php


namespace AdminBundle\Controller;

use AdminBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use PortfolioBundle\Entity\User;

use FOS\UserBundle\Model\UserManagerInterface;


class UserController extends Controller{

    /**
     * @Route(
     *      "/lista-uzytkownikow/{page}",
     *      name="admin_users",
     *      defaults={"page"=1}
     * )
     *
     * @Template("AdminBundle:Users:list.html.twig")
     */
    public function indexAction(Request $request, $page){

        $queryParams = array(
            'usernameLike' => $request->query->get('usernameLike'),
        );

        $UserRepository = $this->getDoctrine()->getRepository('PortfolioBundle:User');
        $qb = $UserRepository->getQueryBuilder($queryParams);

        $paginationLimit = 20;
        $limitList = array(5, 10, 20, 50);
        $limit = $request->query->get('limit', $paginationLimit);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);


        return array(
            'Pagination' => $pagination,
            'current_page' => 'users',
            'queryParams' => $queryParams,
            'currLimit' => $limit,
            'limitList' => $limitList,
        );
    }


    /**
     * @Route(
     *      "/formularz-uzytkownika/{id}",
     *      name="admin_userForm",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     *
     * @Template("AdminBundle:Users:form.html.twig")
     */
    public function formAction(Request $Request, User $User = NULL ){

//        $User = $this->getDoctrine()->getRepository('PortfolioBundle:User')->find($id);

        if($User === NULL){
            $User = new User();
            $newUser = true;
        }


        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($User);
            $em->flush();

            $message = isset($newUser) ? 'Poprawnie dodałeś użytkownika' : "Poprawnie dokonałeś edycje użytkownika";
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_userForm', array('id' => $User->getId())));
        }


        return array(
            'Form' => $form->createView(),
            'User' => $User,
            'current_page' => 'users',
        );
    }



    /**
     * @Route(
     *      "/usun/{id}",
     *      name="admin_userDelete",
     *      requirements={"id"="\d+"}
     * )
     *
     * @Template()
     */
    public function deleteAction($id){

        $User = $this->getDoctrine()->getRepository('PortfolioBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($User);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Poprawnie usunięto użytkownika');

        return $this->redirect($this->generateUrl('admin_users'));
    }



}