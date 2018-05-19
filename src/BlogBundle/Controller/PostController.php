<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostController extends Controller
{
    /**
     * @Route(
     *      "/{page}",
     *      name = "blog_list",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     *
     * @Template("BlogBundle:Post:blogList.html.twig")
     */
    public function blogListAction($page){

        $params = array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC'
        );

        $PostRepo = $this->getDoctrine()->getRepository('BlogBundle:Post');
        $qb = $PostRepo->getQueryBuilder($params);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, 3);

        return array(
            'posts' => $pagination,
            'current_page' => 'blog'
        );

    }


    /**
     * @Route(
     *      "/{slug}",
     *      name = "blog_post",
     * )
     *
     * @Template("BlogBundle:Post:blogPost.html.twig")
     */
    public function blogPostAction(Request $request, $slug){

        $PostRepo = $this->getDoctrine()->getRepository('BlogBundle:Post');

        $Post = $PostRepo->getPublishedPost($slug);

        if(null === $Post){
            throw $this->createNotFoundException('Post nie został odnaleziony.');
        }


        return array(
            'post' => $Post,
            'current_page' => 'blog',
            'language_switcher_with_slug' => true
        );

    }


}
