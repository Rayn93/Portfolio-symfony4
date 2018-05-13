<?php

namespace PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortfolioBundle\Entity\Category;


class CategoriesFixtures extends AbstractFixture implements OrderedFixtureInterface{


    public function load(ObjectManager $manager)
    {

        $CategoryList = array(
            'sklepy' =>'Sklepy internetowe',
            'blogi' => 'Blogi',
            'wizytowki'=> 'Strony wizytówki',
            'ciecie' => 'Cięcie szablonów',
            'moje' => 'Własne projekty',
        );

        foreach($CategoryList as $key => $value){

            $Category = new Category();
            $Category->setName($value);

            $manager->persist($Category);

            $this->addReference('category_'.$key, $Category);
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