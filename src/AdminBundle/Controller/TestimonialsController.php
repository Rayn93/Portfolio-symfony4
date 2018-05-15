<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\TestimonialType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use PortfolioBundle\Entity\Testimonial;


class TestimonialsController extends Controller
{
    /**
     * @Route(
     *      "/lista-opinii/{page}",
     *      name="listTestimonial",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Template("AdminBundle:Testimonials:listTestimonial.html.twig")
     */
    public function listTestimonialAction($page)
    {
        $AllTestimonials = $this->getDoctrine()->getRepository('PortfolioBundle:Testimonial')->findAll();

        $paginationLimit = $this->getParameter('admin.pagination_limit');
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($AllTestimonials, $page, $paginationLimit);

        return array(
            'allTestimonials' => $pagination,
            'current_page' => 'testimonial'
        );
    }


    /**
     * @Route(
     *      "/dodaj-opinie/{id}",
     *      name="addTestimonial",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Template("AdminBundle:Testimonials:addTestimonial.html.twig")
     */
    public function addTestimonialAction(Request $request, Testimonial $Testimonial = NULL )
    {
        if($Testimonial === NULL){
            $Testimonial = new Testimonial();
            $newTestimonial = true;
        }

        $form = $this->createForm(TestimonialType::class, $Testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($Testimonial);
            $em->flush();

            $message = isset($newTestimonial) ? 'Poprawnie dodałeś opinie do bazy danych' : "Poprawnie dokonałeś edycje opinii";
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('addTestimonial', array('id' => $Testimonial->getId())));
        }


        return array(
            'form' => $form->createView(),
            'testimonial' => $Testimonial,
            'current_page' => 'testimonial'
        );
    }

    /**
     * @Route(
     *      "/usun-opinie/{id}",
     *      name="deleteTestimonial",
     *      requirements={"id"="\d+"}
     * )
     *
     * @Template()
     */
    public function deleteTestimonialAction($id)
    {
        $deleteTestimonial = $this->getDoctrine()->getRepository('PortfolioBundle:Testimonial')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($deleteTestimonial);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Poprawnie usunołeś opinie');

        return $this->redirect($this->generateUrl('listTestimonial'));
    }


}
