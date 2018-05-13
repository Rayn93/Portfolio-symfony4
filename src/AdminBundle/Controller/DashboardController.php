<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="dashboard"
     * )
     * @Template("AdminBundle:Dashboard:index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
