<?php

namespace PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortfolioBundle\Entity\Project;


class ProjectsFixtures extends AbstractFixture implements OrderedFixtureInterface{


    public function load(ObjectManager $manager)
    {

        $ProjectsList = array(
            array(
                'title' => 'Centrum nurkowania w Tajlandii',
                'content' => 'Projekt dla szkoły nurkowania z Tajlandii. W rzeczywistości jest to połączenie strony firmowej, bazy wiedzy oraz sklepu internetowego..Całość oparta na systemie WordPress (system sklepowy: WooCommerce). Dodatkowo zaimplementowany został blog oraz forum dla pracowników i klientów. Odpowiadam za stworzenie serwisu, administrację oraz SEO.',
                'thumbnail' => '/portfolio_symfony/web/app_dev.php/images/8e0581a_pidsthailand_1.jpg',
                'category' => 'sklepy',
                'tags' => array('HTML 5', 'CSS 3', 'PHP', 'jQuery', 'Wordpress', 'WooCommerce', 'Administracja', 'SEO'),
                'link' => 'http://pidsthailand.com/',
                'publishedDate' => '2016-04-12 12:12:12',
                'homePage' => true,
            ),
            array(
                'title' => 'FreeLancelot.pl - projekt podróżniczy',
                'content' => 'Strona FreeLancelot.pl to projekt blogowy o podróżach, niezależności oraz spełnianiu marzeń. Strona stworzona w całości przeze mnie od projektu graficznego aż do stworzenia autorskiego szablonu WordPress. Dodatkowo wdrożyłem kilka własnych plugin-ów. Ponadto jestem administratorem oraz odpowiadam za dalszy rozwój projektu.',
                'thumbnail' => '/portfolio_symfony/web/app_dev.php/images/ecad257_freelancelot_1.jpg',
                'category' => 'moje',
                'tags' => array('HTML 5', 'SCSS', 'PHP', 'jQuery', 'Bootstrap', 'Wordpress - tworzenie motywów', 'Photoshop', 'Administracja', 'SEO'),
                'link' => 'http://freelancelot.pl/',
                'publishedDate' => '2016-04-10 12:12:12',
                'homePage' => true,
            ),
            array(
                'title' => 'Elektromaniak - sklep dla elektroników',
                'content' => 'Sklep Elektromaniak.pl to serwis dla pasjonatów elektroniki. System został oparty o platformę PrestaShop. Odpowiadam za dostosowanie szablonu pod wymagania klienta oraz całą konfigurację serwisu. Zaimplementowałem również system blogowy oraz forum. Dodatkowo wykonałem migrację danych (produkty, klienci, zamówienia itp.) ze starego sklepu klienta.',
                'thumbnail' => '/portfolio_symfony/web/app_dev.php/images/ea7e4c9_elektromaniak_1.jpg',
                'category' => 'sklepy',
                'tags' => array('HTML 5', 'CSS 3', 'PHP', 'JavaScript', 'SQL', 'E-commerce', 'PrestaShop'),
                'link' => 'http://elektromaniak.pl/',
                'publishedDate' => '2016-04-07 12:12:12',
                'homePage' => true,
            ),
            array(
                'title' => 'BWHS - Kancelaria adwokacka',
                'content' => 'Strona BWHS to projekt stworzony dla kancelarii prawniczej. Całość oparta o system WordPress. Moim zadaniem było dostosowanie szablonu pod projekt graficzny dostarczony przez firmę web-bespokers.com. Dodatkowo również wykonałem wielojęzyczność serwisu oraz przeniesienie całej treści ze starej strony klienta.',
                'thumbnail' => '/portfolio_symfony/web/app_dev.php/images/98855d6_bwhs_mocaps_1.jpg',
                'category' => 'wizytowki',
                'tags' => array('HTML 5', 'CSS 3', 'PHP', 'jQuery', 'Bootstrap', 'Wordpress', 'Genesis framework', 'Wielojęzyczność'),
                'link' => 'http://web-programista.pl/bwhs/',
                'publishedDate' => '2016-04-05 12:12:12',
                'homePage' => true
            ),
            array(
                'title' => 'Firma budowlana GOS-BUD',
                'content' => 'Projekt zrealizowany dla firmy budowlanej Gos-Bud z Sulejowa. Strona jest oparta o system zarządzania treścią Wordpress, co pozwala właścicielom strony na łatwą modyfikację treści oraz dodawanie nowych realizacji budowlanych do portfolia na stronie. Projekt bazujący na gotowym szablonie. Moim zadaniem było zaprojektować stronę oraz zmodyfikować szablon pod wymagania klienta.',
                'thumbnail' => '/portfolio_symfony/web/app_dev.php/images/3703857_gosbud_mocaps_1.jpg',
                'category' => 'wizytowki',
                'tags' => array('HTML 5', 'CSS 3', 'JavaScript', 'Wordpress', 'Photoshop'),
                'link' => 'http://gos-bud.com.pl/',
                'publishedDate' => '2016-04-03 12:12:12',
                'homePage' => true
            )
        );

        foreach($ProjectsList as $project){

            $Project = new Project();

            $Project->setTitle($project['title'])
                    ->setContent($project['content'])
                    ->setThumbnail($project['thumbnail'])
                    ->setLink($project['link'])
                    ->setPublishedDate(new \DateTime($project['publishedDate']))
                    ->setHomePage($project['homePage']);

            $Project->setCategory($this->getReference('category_'.$project['category']));

            foreach($project['tags'] as $tagName){
                $Project->addTag($this->getReference('tag_'.$tagName));
            }


            $manager->persist($Project);
        }

        $manager->flush();

    }

    /**
     * Get the order of this fixture
     */
    public function getOrder()
    {
        return 1;
    }


}