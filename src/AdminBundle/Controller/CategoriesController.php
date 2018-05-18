<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use PortfolioBundle\Entity\Category;
use AdminBundle\Form\Type\TaxonomyType;
use AdminBundle\Form\Type\CategoryType;

class CategoriesController extends Controller
{

    /**
     * @Route(
     *      "/lista-kategorii/{page}",
     *      name="listCategory",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Template("AdminBundle:Categories:listCategory.html.twig")
     */
    public function listCategoryAction($page)
    {
        $CategoryRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Category');
        $AllCategory = $CategoryRepo->getQueryBuilder();

        $paginationLimit = $this->getParameter('admin.pagination_limit');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($AllCategory, $page, $paginationLimit);

        return array(
            'allCategory' => $pagination,
            'current_page' => 'taxonomy'
        );
    }

    /**
     * @Route(
     *      "/dodaj-kategorie/{id}",
     *      name="addCategory",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Template("AdminBundle:Categories:addCategory.html.twig")
     */
    public function addCategoryAction(Request $request, Category $Category = NULL)
    {
        if($Category == null){
            $Category = new Category();
            $newCategory = true;
        }

        $form = $this->createForm(TaxonomyType::class, $Category);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($Category);
            $em->flush();

            $message = isset($newCategory) ? 'Poprawnie dodano nową kategorię do bazy danych' : 'Poprawnie dokonano edycji kategorii';
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('addCategory', array('id' => $Category->getId())));
        }

        return array(
            'form' => $form->createView(),
            'category' => $Category,
            'current_page' => 'taxonomy'
        );
    }

    /**
     * @Route(
     *      "/usun-kategorie/{id}",
     *      name="deleteCategory",
     *      requirements={"id"="\d+"}
     * )
     * @Template("AdminBundle:Categories:deleteCategory.html.twig")
     */
    public function deleteCategoryAction(Request $request, $id)
    {
        $Category = $this->getDoctrine()->getRepository('PortfolioBundle:Category')->find($id);

        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

//            dump($NewCategory);

            $NewCategory = $form->get('category')->getData();
            $newCategoryId = $NewCategory->getId();


            $ProjectRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Project');
            $modifiedPosts = $ProjectRepo->moveToCategory($Category->getId(), $newCategoryId);

            $em = $this->getDoctrine()->getManager();
            $em->remove($Category);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', sprintf('Kategoria została usunięta. %d postów zostało zmodyfikowanych.', $modifiedPosts));

            return $this->redirect($this->generateUrl('listCategory'));


        }

        return array(
            'form' => $form->createView(),
            'category' => $Category,
            'current_page' => 'taxonomy'
        );
    }
}
