<?php

namespace AdminBundle\Form\Type;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\OptionsResolver\OptionsResolver;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,  array $options){


        $builder
            ->add('title', Type\TextType::class, array(
                'label' => 'Tytuł',
                'attr' => array(
                    'placeholder' => 'Tytuł posta',
                )
            ))
            ->add('slug', Type\TextType::class, array(
                'label' => 'Link',
                'attr' => array(
                    'placeholder' => 'Slug posta',
                )
            ))

            ->add('excerpt', Type\TextareaType::class, array(
                'label' => 'Streszczenie',
                'attr' => array(
                    'placeholder' => 'Streszczenie posta',
                    'rows' => 10,
                )
            ))

            ->add('content', Type\TextareaType::class, array(
                'label' => 'Treść',
                'attr' => array(
                    'placeholder' => 'Treść posta',
                    'rows' => 10,
                )
            ))

            ->add('thumbnailFile', Type\FileType::class, array(
                'label' => 'Miniaturka',
                'data_class' => null,
            ))

//            ->add('createDate', Type\DateTimeType::class, array(
//                'label' => 'Data stworzenia',
//                'date_widget' => 'single_text',
//                'time_widget' => 'single_text'
//            ))


            ->add('publishedDate', Type\DateTimeType::class, array(
                'label' => 'Data publikacji',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))


            ->add('save', SubmitType::class, array('label' => 'Zapisz'))
            ->getForm();

    }

    public function getName()
    {
        return 'post';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Post',
        ));
    }

}