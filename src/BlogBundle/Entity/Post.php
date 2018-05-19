<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\PostRepository")
 * @ORM\Table(name="blog_posts")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields={"title"})
 * @UniqueEntity(fields={"slug"})
 */
class Post {

    const DEFAULT_THUMBNAIL = 'default-thumbnail.jpg';
    const UPLOAD_DIR = 'uploads/blog-thumbnails/';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     *
     * @Assert\NotBlank
     *
     * @Assert\Length(
     *      max = 120
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     *
     * @Assert\Length(
     *      max = 120
     * )
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private $content;

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
     * @ORM\ManyToOne(
     *      targetEntity = "PortfolioBundle\Entity\User"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "author_id",
     *      referencedColumnName = "id"
     * )
     */
    private $author;

    /**
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @ORM\Column(name="published_date", type="datetime", nullable=true)
     *
     * @Assert\DateTime
     */
    private $publishedDate = null;

    /**
     * @ORM\Column(name="update_date", type="datetime", nullable=true)
     */
    private $updateDate = null;




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
     * Set title
     *
     * @param string $title
     * @return Post
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
     * Set slug
     *
     * @param string $slug
     * @return Post
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
     * Set content
     *
     * @param string $content
     * @return Post
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
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Post
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
            return Post::DEFAULT_THUMBNAIL;
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
     * Set author
     *
     * @param  \PortfolioBundle\Entity\User $author
     * @return Post
     */
    public function setAuthor(\PortfolioBundle\Entity\User  $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \PortfolioBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Post
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     * @return Post
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

        if(null === $this->slug){
            $this->setSlug($this->getTitle());
        }

//        if(null !== $this->getThumbnailFile()){
//
//            if(null !== $this->thumbnail){
//                $this->thumbnailTemp = $this->thumbnail;
//            }
//
//            $fileName = sha1(uniqid(null, true));
//            $this->thumbnail = $fileName.'.'.$this->getThumbnailFile()->guessExtension();
//        }

        if(null == $this->createDate){
            $this->createDate = new \DateTime();
        }
    }



//    /**
//     * @ORM\PostPersist
//     * @ORM\PostUpdate
//     */
//    public function postSave(){
//        if(NULL !== $this->getThumbnailFile()){
//            $this->getThumbnailFile()->move($this->getUploadRootDir(), $this->thumbnail);
//            unset($this->thumbnailFile);
//
//            if(isset($this->thumbnailTemp)){
//                unlink($this->getUploadRootDir().'/'.$this->thumbnailTemp);
//                unset($this->thumbnailTemp);
//            }
//        }
//    }
//
//    /**
//     * @ORM\PostRemove
//     */
//    public function postRemove() {
//        if(null !== $this->thumbnail){
//            unlink($this->getUploadRootDir().'/'.$this->thumbnail);
//        }
//    }
//
//    public function getUploadRootDir(){
//        return __DIR__.'/../../../../web/'.self::UPLOAD_DIR;
//    }

}
