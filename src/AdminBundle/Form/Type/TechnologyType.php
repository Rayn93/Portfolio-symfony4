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


class TechnologyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,  array $options){

        $builder
            ->add('translations', TranslationsType::class, [
            'fields' => [
                'title' => [
                    'field_type' => Type\TextType::class,
                    'constraints'   => new NotBlank,
                    'label' => 'Tytuł',
                    'attr' => array(
                        'placeholder' => 'Tytuł technologii',
                    ),
                ],
                'content' => [
                    'constraints'   => new NotBlank,
                    'label' => 'Content',
                    'attr' => array(
                        'rows' => 10,
                        'placeholder' => 'Treść dla technologii',
                    )
                ]
            ]
            ])

            ->add('thumbnailFile', Type\FileType::class, array(
                'label' => 'Miniaturka',
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
        return 'technology';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PortfolioBundle\Entity\Technology',
        ));
    }

}