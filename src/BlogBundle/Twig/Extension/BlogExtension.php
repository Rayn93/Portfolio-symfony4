<?php

namespace BlogBundle\Twig\Extension;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\RequestStack;


//Developerskie Rozszerzenia dla szablonów Twig
class BlogExtension extends \Twig_Extension {


//    /**
//     * @var \Doctrine\Bundle\DoctrineBundle\Registry
//     */
//    private $doctrine;
//    private $request;
//
//    /**
//     * BlogExtension constructor.
//     * @param \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
//     */
//    public function __construct(RegistryInterface $doctrine, RequestStack $request_stack){
//        $this->doctrine = $doctrine;
//        $this->request = $request_stack->getCurrentRequest();
//    }


    public function getFilters(){
        return array(
            new \Twig_SimpleFilter('cutText', array($this, 'cutText'), array('is_safe' => array('html'))),
        );
    }


    public function getName(){
        return 'blog_extension';
    }


    //Filtr twiga który skraca tekst o zadaną wartość znaków
    public function cutText($text, $length = 200, $wrapTag = 'p'){

        $text = strip_tags($text);
        mb_internal_encoding('utf-8');
        $text2 = mb_substr($text, 0, $length, 'UTF-8').' [...]';


        if($wrapTag == ''){
            return $text2;
        }
        else{
            $open_tag = '<'.$wrapTag.'>';
            $close_tag = '</'.$wrapTag.'>';
            return $open_tag.$text2.$close_tag;
        }

    }

}