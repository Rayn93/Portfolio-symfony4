<?php

namespace PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use PortfolioBundle\Form\Type\ContactFormType;
use PortfolioBundle\Form\Type\FreeFormType;


class PortfolioController extends Controller
{

    /**
     * @Route(
     *      "/",
     *      name="portfolio_main"
     * )
     * @Template("PortfolioBundle:Portfolio:index.html.twig")
     */
    public function indexAction(Request $request){

        //Rendering project with homePage = true
        $ProjectRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Project');

        $qb = $ProjectRepo->getQueryBuilder(array(
            'home' => 'home',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC'
        ));


        $query = $qb->getQuery();
        $projects = $query->getResult();

        //Rendering a contact form

        $contactForm = $this->createForm(ContactFormType::class);

        if ($request->isMethod('POST')) {
            $contactForm->handleRequest($request);

            if ($contactForm->isValid()) {

                $name = $contactForm->getData()['name'];
                $email = $contactForm->getData()['email'];
                $message = $contactForm->getData()['message'];

                $this->sendMails($name, $email, $message);
                $this->get('session')->getFlashBag()->add('success', 'Dziękuję! Twoja wiadomość została wysłana. Odpiszę tak szybko jak to tylko możliwe');
                return $this->redirect($this->generateUrl('portfolio_main').'#kontakt');
            }
            else{
                $this->get('session')->getFlashBag()->add('fail', 'Nie udało się wysłać wiadomości. Sprawdź wszystkie pola formularza. Wszystkie pola są wymagane');
                return $this->redirect($this->generateUrl('portfolio_main').'#kontakt');
            }
        }

        return array(
            'projects' => $projects,
            'contactForm' => $contactForm->createView()
        );
    }

    /**
     * @Route(
     *      "/projekty/{page}",
     *       name="portfolio_projects",
     *       requirements={"page"="\d+"},
     *       defaults={"page"=1}
     * )
     * @Template("PortfolioBundle:Portfolio:projects_list.html.twig")
     */
    public function projectsAction($page)
    {
        $ProjectRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Project');

        $qb = $ProjectRepo->getQueryBuilder(array(
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC'
        ));

        $query = $qb->getQuery();

        $paginationLimit = $this->getParameter('portfolio.pagination_limit');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, $paginationLimit);

        $CategoryRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Category');
        $AllCategory = $CategoryRepo->findAll();


        return array(
            'projects' => $pagination,
            'title' => 'Projekty i realizacje',
            'all_projects' => 'WSZYSTKIE',
            'category_search' => true,
            'all_category' => $AllCategory
        );
    }

    /**
     * @Route(
     *      "/tag/{slug}/{page}",
     *      name="portfolio_projects_tags",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Template("PortfolioBundle:Portfolio:projects_list.html.twig")
     */
    public function tagsAction($slug, $page)
    {
        $ProjectRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Project');

        $qb = $ProjectRepo->getQueryBuilder(array(
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'tag' => $slug
        ));

        $query = $qb->getQuery();

        $paginationLimit = $this->getParameter('portfolio.pagination_limit');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, $paginationLimit);

        $TagsRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Tags');
        $Tag = $TagsRepo->findOneBy(array('slug' => $slug));
        $TagsCloud = $TagsRepo->findAll();


        return array(
            'projects' => $pagination,
            'tag_cloud' => $TagsCloud,
            'title' => sprintf("Projekty z tagiem: <span class=\"highlight\">%s</span>", $Tag->getName())
        );
    }

    /**
     * @Route(
     *      "/kategoria/{slug}/{page}",
     *       name="portfolio_projects_categories",
     *       requirements={"page"="\d+"},
     *       defaults={"page"=1}
     * )
     * @Template("PortfolioBundle:Portfolio:projects_list.html.twig")
     */
    public function categoryAction($slug, $page)
    {
        $ProjectRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Project');

        $qb = $ProjectRepo->getQueryBuilder(array(
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'category' => $slug
        ));

        $query = $qb->getQuery();

        $paginationLimit = $this->getParameter('portfolio.pagination_limit');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, $paginationLimit);

        $CategoryRepo = $this->getDoctrine()->getRepository('PortfolioBundle:Category');
        $CurrentCategory = $CategoryRepo->findOneBy(array('slug'=>$slug));
        $AllCategory = $CategoryRepo->findAll();


        return array(
            'projects' => $pagination,
            'title' => sprintf("Projekty z kategorii: <span class=\"highlight\">%s</span>", $CurrentCategory->getName()),
            'current_category' => $CurrentCategory,
            'category_search' => true,
            'all_category' => $AllCategory
        );
    }

    /**
     * @Route(
     *      "/bezplatna-wycena",
     *       name="portfolio_free_form",
     * )
     * @Template("PortfolioBundle:Portfolio:freeForm.html.twig")
     */
    public function freeFormAction(Request $request)
    {
        //Rendering a form

        $freeForm = $this->createForm(FreeFormType::class);

        if ($request->isMethod('POST')) {
            $freeForm->handleRequest($request);

            if ($freeForm->isValid()) {

                $name = $freeForm->getData()['name'];
                $email = $freeForm->getData()['email'];
                $website = $freeForm->getData()['website'];
                $bigwebsite = $freeForm->getData()['bigwebsite'];
                $project = $freeForm->getData()['project'];
                $rwd = $freeForm->getData()['rwd'];
                $cms = $freeForm->getData()['cms'];
                $lang = $freeForm->getData()['lang'];
                $services = $freeForm->getData()['services'];
                $text = $freeForm->getData()['text'];
                $graphic = $freeForm->getData()['graphic'];
                $message = $freeForm->getData()['message'];

                $mailFreeForm = \Swift_Message::newInstance()
                    ->setSubject('Nowa wycena projektu | Robert Saternus - Portfolio web-developer-a')
                    ->setFrom($email)
                    ->setTo('robert.saternus@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'PortfolioBundle:Mail:freeFormMail.html.twig',
                            array(
                                'name' => $name,
                                'email' => $email,
                                'website' => $website,
                                'bigwebsite' => $bigwebsite,
                                'project' => $project,
                                'rwd' => $rwd,
                                'cms' => $cms,
                                'lang' => $lang,
                                'services' => $services,
                                'text' => $text,
                                'graphic' => $graphic,
                                'message' => $message,
                            )
                        ),
                        'text/html'
                    )
                ;

                $this->get('mailer')->send($mailFreeForm);
                $this->get('session')->getFlashBag()->add('success', 'Dziękuję! Formularz z Twoimi informacjami został wysłany poprawnie. Niedługo wyślę moją propozycję projektu dla Ciebie.');
            }
        }

        return array(
            'freeForm' => $freeForm->createView()
        );
    }

//######################################################################################################

    //Message from contact form for main page
    private function sendMails($name, $email, $message)
    {
        $mailToMe = \Swift_Message::newInstance()
            ->setSubject('Wiadomość ze strony robertsaternus.pl | Robert Saternus - Portfolio web-developer-a')
            ->setFrom($email)
            ->setTo('robert.saternus@gmail.com')
            ->setBody(
                $this->renderView(
                    'PortfolioBundle:Mail:contactFormMail.html.twig',
                    array(
                        'name' => $name,
                        'message' => $message
                        )
                ),
                'text/html'
            )
        ;

        $mailToVisitor = \Swift_Message::newInstance()
            ->setSubject('Poprawne wysłanie mail-a | Portfolio Robert Saternus')
            ->setFrom('robert.saternus@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'PortfolioBundle:Mail:contactFormMailToVisitor.html.twig',
                    array(
                        'name' => $name,
                        'email' => $email
                    )
                ),
                'text/html'
            )
        ;

        $this->get('mailer')->send($mailToMe);
        $this->get('mailer')->send($mailToVisitor);
    }

}
