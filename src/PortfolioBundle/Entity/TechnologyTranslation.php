<?php

namespace PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Technology
 *
 *
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\TechnologyRepository")
 *
 */
class TechnologyTranslation
{

    use ORMBehaviors\Translatable\Translation;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=30)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 30
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     *
     * @Assert\NotBlank()
     */
    private $content;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Technology
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
     * @return Technology
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


}

