<?php

namespace PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortfolioBundle\Entity\Tags;


class TagsFixtures extends AbstractFixture implements OrderedFixtureInterface{


    public function load(ObjectManager $manager)
    {

        $TagsList = array(
            'HTML 5',
            'CSS 3',
            'JavaScript',
            'PHP',
            'jQuery',
            'Wordpress',
            'WooCommerce',
            'Administracja',
            'SEO',
            'SCSS',
            'Bootstrap',
            'Wordpress - tworzenie motywów',
            'Photoshop',
            'SQL',
            'E-commerce',
            'PrestaShop',
            'Genesis framework',
            'Wielojęzyczność'
        );

        foreach($TagsList  as $tag){

            $Tag = new Tags();
            $Tag->setName($tag);

            $manager->persist($Tag);

            $this->addReference('tag_'.$tag, $Tag);
        }

        $manager->flush();

    }

    /**
     * Get the order of this fixture
     */
    public function getOrder()
    {
        return 0;
    }
}