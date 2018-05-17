<?php

namespace PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContext;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\ProjectRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields={"title"})
 * @UniqueEntity(fields={"slug"})
 */
class ProjectTranslation{

    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 150
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 150
     * )
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     *
     */
    private $content;



    /**
     * Set title
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Project
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Project
     */
    public function setSlug($slug)
    {
        $this->slug = \PortfolioBundle\Libs\Utils::sluggify($slug) ;

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
            $this->setSlug($this->getTitle());
        }

    }


}
