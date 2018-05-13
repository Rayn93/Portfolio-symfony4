<?php


namespace PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type as Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class FreeFormType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options){


        $builder
            ->add('name', Type\TextType::class, array(
                'label' => 'Imie i nazwisko *',
                'attr' => array(
                    'placeholder' => 'Imie i nazwisko lub nazwa firmy',
                ),
                'constraints' => array(
                    new Assert\NotBlank()
                )
            ))
            ->add('email', Type\EmailType::class, array(
                'label' => 'E-mail *',
                'attr' => array(
                    'placeholder' => 'Twój adres E-mail'
                ),
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email()
                )
            ))
            ->add('website', Type\EmailType::class, array(
                'label' => 'Strona internetowa',
                'attr' => array(
                    'placeholder' => 'Adres obecnej strony internetowej'
                )
            ))
            ->add('project', Type\ChoiceType::class, array(
                'label' => "Rodzaj projektu *",
                'choices' => array(
                    'Wizytówka firmy / strona osobista' => 'wizytowka',
                    'Portfolio' => 'portfolio',
                    'Sklep internetowy' => 'sklep',
                    'Blog' => 'blog',
                    'Nietypowy projekt (portal, plugin, tłumaczenie itp.)' => 'nietypowy',
                    'Inny' => 'inny'
                ),
                'constraints' => array(
                    new Assert\NotBlank()
                )
            ))
            ->add('bigwebsite', Type\TextareaType::class, array(
                'label' => 'Ilość  podstron na stronie',
                'attr' => array(
                    'rows' => 3,
                    'placeholder' => 'Ilość wszystkch podstron na stronie (np. "O firmie", "Oferta", "Kontakt"). Jeśli np. podstrona "oferta" ma posiadać kolejne podstrony, to te również proszę podać'
                ),
            ))
            ->add('rwd', Type\ChoiceType::class, array(
                'label' => "Strona responsywna",
                'choices' => array(
                    'Tak' => 'tak',
                    'Nie' => 'nie',
                ),
                'expanded' => true,
            ))
            ->add('cms', Type\ChoiceType::class, array(
                'label' => "System zarządzania treścią (np. Wordpress)",
                'choices' => array(
                    'Tak' => 'tak',
                    'Nie' => 'nie',
                ),
                'expanded' => true,
            ))
            ->add('lang', Type\ChoiceType::class, array(
                'label' => "Strona wielojęzyczna",
                'choices' => array(
                    'Tak' => 'tak',
                    'Nie' => 'nie',
                ),
                'expanded' => true,
            ))
            ->add('services', Type\ChoiceType::class, array(
                'label' => "Dodatkowe funkcjonalności na stronie",
                'choices' => array(
                    'Blog/aktualności' => 'blog',
                    'Newsletter' => 'newsletter',
                    'Dedykowane formularze' => 'formularze',
                    'Konta użytkowników' => 'konta uzytkownikow',
                    'Forum dyskusyjne' => 'forum',
                    'Oceny / komentarze' => 'Oceny/komentarze',
                    'Integracja z social media-mi' => 'integracja social-media'
                ),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('text', Type\ChoiceType::class, array(
                'label' => "Tekst na stronę",
                'choices' => array(
                    'Dostarczę tekst' => 'dostarcze tekst',
                    'Zlecę napisanie tekstu' => 'zlece napisanie tekstu',
                ),
                'expanded' => true,
            ))
            ->add('graphic', Type\ChoiceType::class, array(
                'label' => "Projekt graficzny",
                'choices' => array(
                    'Dostarczę projekt graficzny' => 'mam swoj projekt graficzny',
                    'Projekt podstawowy' => 'podstawowy projekt graficzny',
                    'Indywidualny projekt graficzny stworzony przez profesjonalnego grafika' => 'profesjonalny projekt graficzny'
                ),
                'expanded' => true,
            ))
            ->add('message', Type\TextareaType::class, array(
                'label' => 'Dodatkowe informacje',
                'attr' => array(
                    'rows' => 5,
                    'placeholder' => 'Proszę napisz tutaj wszystko czego oczekujesz od nowej strony (np. rodzaj CMS, inspiracje z istniejącyh już stron internetowych, dodatkowe usługi takie jak SEO itp.)'
                ),
            ))
            ->add('save', Type\SubmitType::class, array('label' => 'WYŚLIJ'))
            ->getForm();


    }

    public function getName()
    {
        return 'free form';
    }






}