<?php

namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Validator\Constraints\NotBlank;


class TagsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,  array $options){


        $builder
            ->add('translations', TranslationsType::class, [
                'fields' => [
                    'name' => [
                        'field_type' => Type\TextType::class,
                        'constraints'   => new NotBlank,
                        'label' => 'Nazwa',
                        'attr' => array(
                            'placeholder' => 'Nazwa kategorii',
                        ),
                    ]
                ]
            ])

            ->add('slug', Type\TextType::class, array(
                'label' => 'Alias',
                'attr' => array(
                    'placeholder' => 'Alias tagu',
                )
            ))
            ->add('save', Type\SubmitType::class, array('label' => 'Zapisz'))
            ->getForm();

    }

    public function getName()
    {
        return 'tag';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PortfolioBundle\Entity\Tags',
        ));
    }

}