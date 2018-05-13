<?php

namespace PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PortfolioBundle\Entity\AbstractTaxonomy;


/**
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category extends AbstractTaxonomy{

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="category")
     */
    protected $projects;



}
