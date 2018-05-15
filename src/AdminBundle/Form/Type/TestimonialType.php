<?php

namespace AdminBundle\Form\Type;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\OptionsResolver\OptionsResolver;


class TestimonialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,  array $options){


        $builder
            ->add('author', Type\TextType::class, array(
                'label' => 'Autor',
                'attr' => array(
                    'placeholder' => 'Autor',
                ),
            ))
            ->add('role', Type\TextType::class, array(
                'label' => 'Rola',
                'attr' => array(
                    'placeholder' => 'Rola autora',
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
            ->add('content', Type\TextareaType::class, array(
                'label' => 'Opinia',
                'attr' => array(
                    'rows' => 10,
                    'placeholder' => 'Opinia klienta długa',
                )
            ))
            ->add('contentShort', Type\TextareaType::class, array(
                'label' => 'Opinia krótka',
                'attr' => array(
                    'rows' => 10,
                    'placeholder' => 'Opinia klienta krótka',
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