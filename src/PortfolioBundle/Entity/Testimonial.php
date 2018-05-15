<?php

namespace PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Testimonial
 *
 * @ORM\Table(name="testimonial")
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\TestimonialRepository")
 *
 * @ORM\HasLifecycleCallbacks
 *
 * @Vich\Uploadable
 */
class Testimonial
{

    const DEFAULT_AVATAR = 'defoult_avatar.jpg';


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     *
     */
    private $author;

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
     * @ORM\Column(name="company", type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", )
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
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     *
     */
    private $avatar;


    /**
     * @Vich\UploadableField(mapping="testimonial_image", fileNameProperty="avatar")
     *
     *
     * @var File
     */
    private $avatarFile;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    private $updatedAt;


    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime()
     */
    private $publishedDate;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Testimonial
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

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
     * Set company
     *
     * @param string $company
     *
     * @return Testimonial
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Testimonial
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
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


    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Testimonial
     */
    public function setAvatar($avatar)
    {

        $this->avatar = $avatar;

        return $this;
    }


    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getAvatar()
    {

        if($this->avatar == null ){
            return Testimonial::DEFAULT_AVATAR;
        }

        return $this->avatar;
    }


    public function setAvatarFile(File $image = null)
    {
        $this->avatarFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Testimonial
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     *
     * @return Testimonial
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }



    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave(){


        if(null == $this->publishedDate){
            $this->publishedDate = new \DateTime();
        }
    }
}

