<?php

namespace PortfolioBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\TagsRepository")
 * @ORM\Table(name="tags")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Tags{


    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="tags")
     * )
     */
    protected $projects;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 60
     * )
     */
    private $slug;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add project
     *
     * @param \PortfolioBundle\Entity\Project $project
     *
     * @return Tags
     */
    public function addProject(\PortfolioBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \PortfolioBundle\Entity\Project $project
     */
    public function removeProject(\PortfolioBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }


    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Tags
     */
    public function setSlug($slug)
    {
        $this->slug = \PortfolioBundle\Libs\Utils::sluggify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave(){

        if($this->slug === NULL){
            $this->setSlug($this->getName());
        }
    }

}
