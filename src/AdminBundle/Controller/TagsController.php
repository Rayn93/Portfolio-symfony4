<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use PortfolioBundle\Entity\Tags;
use AdminBundle\Form\Type\TaxonomyType;

class TagsController extends Controller
{
    /**
     * @Route(
     *      "/lista-tagow/{page}",
     *      name="listTag",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Template("AdminBundle:Tags:listTag.html.twig")
     */
    public function listTagAction($page)
    {
        $TagRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Tags');
        $AllTags = $TagRepo->getQueryBuilder();

        $paginationLimit = $this->getParameter('admin.pagination_limit');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($AllTags, $page, $paginationLimit);

        return array(
            'allTag' => $pagination,
            'current_page' => 'taxonomy'
        );
    }

    /**
     * @Route(
     *      "/dodaj-tag/{id}",
     *      name="addTag",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Template("AdminBundle:Tags:addTag.html.twig")
     */
    public function addTagAction(Request $request, Tags $Tag = NULL )
    {
        if($Tag === NULL){
            $Tag = new Tags();
            $newTag = true;
        }

        $form = $this->createForm(TaxonomyType::class, $Tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($Tag);
            $em->flush();

            $message = isset($newTag) ? 'Poprawnie dodałeś tag do bazy danych' : "Poprawnie dokonałeś edycji tagu";
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('addTag', array('id' => $Tag->getId())));
        }


        return array(
            'form' => $form->createView(),
            'tag' => $Tag,
            'current_page' => 'taxonomy'
        );
    }

    /**
     * @Route(
     *      "/usun-tag/{id}",
     *      name="deleteTag",
     *      requirements={"id"="\d+"}
     * )
     *
     * @Template()
     */
    public function deleteTagAction($id)
    {
        $deleteTag = $this->getDoctrine()->getRepository('PortfolioBundle:Tags')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($deleteTag);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Poprawnie usunołeś tag');

        return $this->redirect($this->generateUrl('listTag'));
    }


}
