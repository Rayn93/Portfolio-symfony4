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
            'limits' => $limits
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
            'project' => $Project
        );
    }


//    /**
//     * @Route(
//     *      "/dodaj-projekt",
//     *      name="addProject",
//     * )
//     * @Template("AdminBundle:Projects:addProject.html.twig")
//     */
//    public function addProjectAction(Request $request)
//    {
//        $Project = new Project();
//        $form = $this->createForm(ProjectType::class, $Project);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $file = $Project->getThumbnail();
//            $fileName = $this->get('app.thumbnail_uploader')->upload($file);
//            $Project->setThumbnail($fileName);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($Project);
//            $em->flush();
//
//            $message = 'Poprawnie dodałeś nowy projekt do bazy';
//            $this->get('session')->getFlashBag()->add('success', $message);
//
//            return $this->redirect($this->generateUrl('editProject', array('id' => $Project->getId())));
//        }
//
//        return array(
//            'form' => $form->createView(),
//            'project' => $Project
//        );
//    }
//
//
//    /**
//     * @Route(
//     *      "/edytuj-projekt/{id}",
//     *      name="editProject",
//     *      requirements={"id"="\d+"},
//     *      defaults={"id"=NULL}
//     * )
//     * @Template("AdminBundle:Projects:addProject.html.twig")
//     */
//    public function editProjectAction(Request $request, Project $Project)
//    {
////        $Project->setThumbnail(
////            new File($this->getParameter('upload_directory').'/'.$Project->getThumbnail())
////            new File('uploads/1f36e18b4fc68263d0d24128ef644a98.jpeg')
////        );
//
////        $oldFile =$Project->getThumbnail();
//
//        $form = $this->createForm(ProjectType::class, $Project);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
////            unlink($oldFile);
//
////            $file = $Project->getThumbnail();
////            $fileName = $this->get('app.thumbnail_uploader')->upload($file);
////            $Project->setThumbnail($fileName);
//
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($Project);
//            $em->flush();
//
//            $message = 'Poprawnie dokonałeś edycji projektu';
//            $this->get('session')->getFlashBag()->add('success', $message);
//
//            return $this->redirect($this->generateUrl('editProject', array('id' => $Project->getId())));
//        }
//
//
//        return array(
//            'form' => $form->createView(),
//            'project' => $Project
//        );
//    }


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
