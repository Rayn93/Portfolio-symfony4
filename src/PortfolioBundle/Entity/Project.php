<?php

namespace PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 * @ORM\HasLifecycleCallbacks
 *
 *
 * @Vich\Uploadable
 */
class Project{

    use ORMBehaviors\Translatable\Translatable;

    const DEFAULT_THUMBNAIL = 'defoult_thumbnail.jpeg';
    const UPLOAD_DIR = 'uploads';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     *
     */
    private $thumbnail;


    /**
     * @Vich\UploadableField(mapping="project_image", fileNameProperty="thumbnail")
     *
     * @var File
     */
    private $thumbnailFile;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    private $updatedAt;


    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="projects")
     * @ORM\JoinColumn(
     *      name ="category_id",
     *      referencedColumnName="id",
     *      onDelete="SET NULL"
     * )
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Tags", inversedBy="projects")
     * @ORM\JoinTable(name="portfolio_tags")
     * )
     */
    private $tags;

    /**
     * @ORM\Column(type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 150
     * )
     */
    private $link;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime()
     */
    private $publishedDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $homePage = false;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     *
     */
    private $readMore;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Project
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {

        if($this->thumbnail == null ){
            return Project::DEFAULT_THUMBNAIL;
        }

        return $this->thumbnail;
    }


    public function setThumbnailFile(File $image = null)
    {
        $this->thumbnailFile = $image;

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
    public function getThumbnailFile()
    {
        return $this->thumbnailFile;
    }



    /**
     * Set link
     *
     * @param string $link
     *
     * @return Project
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
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     *
     * @return Project
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
     * Set homePage
     *
     * @param boolean $homePage
     *
     * @return Project
     */
    public function setHomePage($homePage)
    {
        $this->homePage = $homePage;

        return $this;
    }

    /**
     * Get homePage
     *
     * @return boolean
     */
    public function getHomePage()
    {
        return $this->homePage;
    }

    /**
     * Set category
     *
     * @param \PortfolioBundle\Entity\Category $category
     *
     * @return Project
     */
    public function setCategory(\PortfolioBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \PortfolioBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag
     *
     * @param \PortfolioBundle\Entity\Tags $tag
     *
     * @return Project
     */
    public function addTag(\PortfolioBundle\Entity\Tags $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \PortfolioBundle\Entity\Tags $tag
     */
    public function removeTag(\PortfolioBundle\Entity\Tags $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }



    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Project
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
     * Set readMore
     *
     * @param string $readMore
     *
     * @return Project
     */
    public function setReadMore($readMore)
    {
        $this->readMore = $readMore;

        return $this;
    }

    /**
     * Get readMore
     *
     * @return string
     */
    public function getReadMore()
    {
        return $this->readMore;
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
