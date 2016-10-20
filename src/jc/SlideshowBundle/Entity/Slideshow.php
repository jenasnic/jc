<?php

namespace jc\SlideshowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Slideshow
 *
 * @ORM\Table(name="slideshow")
 * @ORM\Entity(repositoryClass="jc\SlideshowBundle\Entity\SlideshowRepository")
 */
class Slideshow
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="pictureUrl", type="text")
     */
    private $pictureUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * Additional property used to upload file for picture
     */
    private $pictureFile;

    /**
     * @var ArrayCollection $pictures
     *
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="slideshow", cascade={"remove"})
     * @ORM\OrderBy({"rank" = "ASC"})
     */
    private $pictures;


    public function __construct()
    {
        $this->pictures = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Slideshow
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Slideshow
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Slideshow
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return Slideshow
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    /**
     * Get pictureUrl
     *
     * @return string 
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * Set rank
     *
     * @param string $rank
     * @return Slideshow
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add picture to slideshow
     *
     * @param Picture $picture
     * @return Slideshow
     */
    public function addPicture(Picture $picture)
    {
        $this->pictures[] = $picture;
        return $this;
    }

    /**
     * Remove picture from slideshow
     *
     * @param Picture $picture
     */
    public function removePicture(Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get picture list
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set file
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile
     * @return Slideshow
     */
    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    /**
     * Get picture file
     *
     * @return Symfony\Component\HttpFoundation\File\UploadedFile 
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }
}
