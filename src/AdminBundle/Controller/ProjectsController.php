<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

use PortfolioBundle\Entity\Project;
use AdminBundle\Form\Type\ProjectType;

class ProjectsController extends Controller
{

    /**
     * @Route(
     *      "/lista-projektow/{page}",
     *      name="listProject",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     *
     * @Template("AdminBundle:Projects:listProject.html.twig")
     */
    public function listProjectAction(Request $request, $page)
    {
        $queryParams = array(
            'titleLike' => $request->query->get('titleLike'),
            'categoryId' => $request->query->get('category')
        );

        $ProjectRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Project');
        $qb = $ProjectRepo->getQueryBuilder($queryParams);
        $query = $qb->getQuery();

        $paginationLimit = $this->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);

        $limit = $request->query->get('limit', $paginationLimit);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, $limit);

        $categoryList = $this->getDoctrine()->getRepository('PortfolioBundle:Category')->getAsArray();

        return array(
            'projects' => $pagination,
            'categoryList' => $categoryList,
            'queryParams' => $queryParams,

            'paginationLimit' => $limit,
            'limits' => $limits,
            'current_page' => 'project'
        );
    }


    /**
     * @Route(
     *      "/formularz/{id}",
     *      name="admin_projectForm",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     *
     * @Template("AdminBundle:Projects:addProject.html.twig")
     */
    public function formAction(Request $Request, $id = NULL){

        if($id == null){
            $Project = new Project();
            $newProjectForm = TRUE;
        }else{
            $Project = $this->getDoctrine()->getRepository('PortfolioBundle:Project')->find($id);
        }

        $form = $this->createForm(ProjectType::class, $Project);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($Project);
            $em->flush();

            $message = (isset($newProjectForm)) ? 'Poprawnie dodano nowy projekt!': 'Projekt został poprawiony!';
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_projectForm', array('id' => $Project->getId())));
        }

        return array(
            'form' => $form->createView(),
            'project' => $Project,
            'current_page' => 'project'
        );
    }


    /**
     * @Route(
     *      "/usun-projekt/{id}",
     *      name="deleteProject",
     *      requirements={"id"="\d+"}
     * )
     * @Template()
     */
    public function deleteProjectAction($id)
    {

        $Project = $this->getDoctrine()->getRepository('PortfolioBundle:Project')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($Project);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Poprawnie usunięto projekt');

        return $this->redirect($this->generateUrl('listProject'));
    }
}
