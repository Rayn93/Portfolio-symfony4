<?php

namespace AdminBundle\Form\Type;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Validator\Constraints\NotBlank;


class TestimonialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,  array $options){


        $builder
            ->add('translations', TranslationsType::class, [
                'fields' => [
                    'role' => [
                        'field_type' => Type\TextType::class,
                        'constraints'   => new NotBlank,
                        'label' => 'Rola',
                        'attr' => array(
                            'placeholder' => 'Rola autora',
                        ),
                    ],
                    'content' => [
                        'constraints'   => new NotBlank,
                        'label' => 'Opini',
                        'attr' => array(
                            'rows' => 10,
                            'placeholder' => 'Treść opini',
                        )
                    ],
                    'contentShort' => [
                        'label' => 'Opini krótka',
                        'attr' => array(
                            'rows' => 10,
                            'placeholder' => 'Treść opini krótkiej',
                        )
                    ]
                ]
            ])


            ->add('author', Type\TextType::class, array(
                'label' => 'Autor',
                'attr' => array(
                    'placeholder' => 'Autor',
                ),
            ))

            ->add('company', Type\TextType::class, array(
                'label' => 'Firma',
                'attr' => array(
                    'placeholder' => 'Firma autora',
                ),
            ))

            ->add('link', Type\TextType::class, array(
                'label' => 'Link',
                'attr' => array(
                    'placeholder' => 'Link do strony klienta',
                )
            ))

            ->add('avatarFile', Type\FileType::class, array(
                'label' => 'Avatar',
                'data_class' => null,
            ))


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
        return 'testimonial';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PortfolioBundle\Entity\Testimonial',
        ));
    }

}