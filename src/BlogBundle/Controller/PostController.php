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
     *      "/blog/{page}",
     *      name = "blog_list",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     *
     * @Template("BlogBundle:Post:blogList.html.twig")
     */
    public function blogListAction(){





        return array(
            'current_page' => 'blog',
        );
    }


    /**
     * @Route(
     *      "/blog/{slug}",
     *      name = "blog_post",
     * )
     *
     * @Template("BlogBundle:Post:blogPost.html.twig")
     */
    public function blogPostAction(){





        return array(
            'current_page' => 'blog',
            'language_switcher_with_slug' => true
        );
    }


}
