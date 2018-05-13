<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder,  array $options){

        $builder
            ->add('category', EntityType::class, array(
                'label' => 'Wybierz nową kategorię dla postów',
                'class' => 'PortfolioBundle\Entity\Category',
                'choice_label' => 'name',
                'empty_data' => 'Wybierz kategorię',
            ))
            ->add('save', Type\SubmitType::class, array('label' => 'Usuń kategorię'))
            ->getForm();

    }

    public function getName()
    {
        return 'category';
    }



}