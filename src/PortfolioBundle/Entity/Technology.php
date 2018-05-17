<?php

namespace PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Technology
 *
 * @ORM\Table(name="technology")
 * @ORM\Entity(repositoryClass="PortfolioBundle\Repository\TechnologyRepository")
 *
 * @Vich\Uploadable
 */
class Technology
{

    use ORMBehaviors\Translatable\Translatable;

    const DEFAULT_THUMBNAIL = 'defoult_thumbnail';


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
     * @ORM\Column(name="thumbnail", type="string", length=100)
     *
     *
     */
    private $thumbnail;

    /**
     * @Vich\UploadableField(mapping="technology_image", fileNameProperty="thumbnail")
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
     * @var \DateTime
     *
     * @ORM\Column(name="publishedDate", type="datetime")
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
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Technology
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
            return Technology::DEFAULT_THUMBNAIL;
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
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     *
     * @return Technology
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
}

