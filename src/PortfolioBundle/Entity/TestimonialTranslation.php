<?php

namespace PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Testimonial
 *
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\TestimonialRepository")
 */
class TestimonialTranslation
{

    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    private $role;


    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     *
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="content_short", type="text", nullable=true)
     *
     */
    private $contentShort;


    /**
     * Set role
     *
     * @param string $role
     *
     * @return Testimonial
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * Set content
     *
     * @param string $content
     *
     * @return Testimonial
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get contentShort
     *
     * @return string
     */
    public function getContentShort()
    {
        return $this->contentShort;
    }


    /**
     * Set contentShort
     *
     * @param string $contentShort
     *
     * @return Testimonial
     */
    public function setContentShort($contentShort)
    {
        $this->contentShort = $contentShort;

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

