<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

use BlogBundle\Entity\Post;
use AdminBundle\Form\Type\PostType;

class PostsController extends Controller
{

    /**
     * @Route(
     *      "/lista-postow/{status}/{page}",
     *      name="admin_listPost",
     *      requirements={"page"="\d+"},
     *      defaults={"status"="all", "page"=1}
     * )
     *
     * @Template("AdminBundle:Posts:listPost.html.twig")
     */
    public function listPostAction(Request $request, $status, $page)
    {
        $queryParams = array(
            'titleLike' => $request->query->get('titleLike'),
            'status' => $status
        );

        $PostRepo = $this->getDoctrine()->getRepository('BlogBundle:Post');
        $qb = $PostRepo->getQueryBuilder($queryParams);
        $query = $qb->getQuery();

        $statistics = $PostRepo->getStatistics();

        $paginationLimit = $this->getParameter('admin.pagination_limit');
        $limits = array(5, 10, 15);

        $limit = $request->query->get('limit', $paginationLimit);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, $limit);

        $statusesList = array(
            'Wszystkie' => 'all',
            'Opublikowane' => 'published',
            'Nieopublikowane' => 'unpublished'
        );


        return array(
            'posts' => $pagination,
            'queryParams' => $queryParams,

            'paginationLimit' => $limit,
            'limits' => $limits,

            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,

            'current_page' => 'post'
        );
    }


    /**
     * @Route(
     *      "/formularz-posta/{id}",
     *      name="admin_postForm",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     *
     * @Template("AdminBundle:Posts:addPost.html.twig")
     */
    public function formAction(Request $Request, $id = NULL){

        if($id == null){
            $Post = new Post();
            $Post->setAuthor($this->getUser());
            $newPostForm = TRUE;
        }else{
            $Post = $this->getDoctrine()->getRepository('BlogBundle:Post')->find($id);
        }

        $form = $this->createForm(PostType::class, $Post);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($Post);
            $em->flush();

            $message = (isset($newPostForm)) ? 'Poprawnie dodano nowy post!': 'Post został poprawiony!';
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_postForm', array('id' => $Post->getId())));
        }

        return array(
            'form' => $form->createView(),
            'post' => $Post,
            'current_page' => 'post'
        );
    }


    /**
     * @Route(
     *      "/usun-post/{id}",
     *      name="deletePost",
     *      requirements={"id"="\d+"}
     * )
     * @Template()
     */
    public function deleteProjectAction($id)
    {

        $Post = $this->getDoctrine()->getRepository('BlogBundle:Post')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($Post);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Poprawnie usunięto post');

        return $this->redirect($this->generateUrl('admin_listPost'));
    }
}
