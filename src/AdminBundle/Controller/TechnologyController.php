<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\TechnologyType;
use PortfolioBundle\Entity\Technology;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use PortfolioBundle\Entity\Testimonial;


class TechnologyController extends Controller
{
    /**
     * @Route(
     *      "/lista-technologii/{page}",
     *      name="listTechnology",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Template("AdminBundle:Technologies:listTechnology.html.twig")
     */
    public function listTechnologyAction($page)
    {
        $AllTechnology = $this->getDoctrine()->getRepository('PortfolioBundle:Technology')->findAll();

        $paginationLimit = $this->getParameter('admin.pagination_limit');
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($AllTechnology, $page, $paginationLimit);

        return array(
            'allTechnology' => $pagination,
            'current_page' => 'technology'
        );
    }


    /**
     * @Route(
     *      "/dodaj-technologie/{id}",
     *      name="addTechnology",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Template("AdminBundle:Technologies:addTechnology.html.twig")
     */
    public function addTechnologyAction(Request $request, Technology $Technology = NULL )
    {
        if($Technology === NULL){
            $Technology = new Technology();
            $newTechnology = true;
        }

        $form = $this->createForm(TechnologyType::class, $Technology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($Technology);
            $em->flush();

            $message = isset($newTechnology) ? 'Poprawnie dodałeś technologię do bazy danych' : "Poprawnie dokonałeś edycji technologii";
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('addTechnology', array('id' => $Technology->getId())));
        }


        return array(
            'form' => $form->createView(),
            'technology' => $Technology,
            'current_page' => 'technology'
        );
    }

    /**
     * @Route(
     *      "/usun-technologie/{id}",
     *      name="deleteTechnology",
     *      requirements={"id"="\d+"}
     * )
     *
     * @Template()
     */
    public function deleteTechnologyAction($id)
    {
        $deleteTechnology = $this->getDoctrine()->getRepository('PortfolioBundle:Technology')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($deleteTechnology);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Poprawnie usunąłeś technologię');

        return $this->redirect($this->generateUrl('listTechnology'));
    }


}
