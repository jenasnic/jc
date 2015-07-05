<?php

namespace jc\TrainingSessionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TrainingSession
 *
 * @ORM\Table(name="trainingSession")
 * @ORM\Entity(repositoryClass="jc\TrainingSessionBundle\Entity\TrainingSessionRepository")
 */
class TrainingSession
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeHourStart", type="integer")
     */
    private $timeHourStart;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeMinuteStart", type="integer")
     */
    private $timeMinuteStart;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeHourEnd", type="integer")
     */
    private $timeHourEnd;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeMinuteEnd", type="integer")
     */
    private $timeMinuteEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="pictureUrl", type="text")
     */
    private $pictureUrl;

    /**
     * Additional property used to upload file for picture
     */
    private $pictureFile;

    /**
     * @var jc\TrainingSessionBundle\Entity\Contact
     *
     * @ORM\ManyToOne(targetEntity="jc\TrainingSessionBundle\Entity\Contact")
     * @ORM\JoinColumn(name="contactId", referencedColumnName="id", nullable=true)
     */
    private $contact;

    /**
     * @var jc\TrainingSessionBundle\Entity\Location
     *
     * @ORM\ManyToOne(targetEntity="jc\TrainingSessionBundle\Entity\Location")
     * @ORM\JoinColumn(name="locationId", referencedColumnName="id", nullable=false)
     */
    private $location;

    /**
     * @var ArrayCollection $commentList
     *
     * @ORM\OneToMany(targetEntity="jc\TrainingSessionBundle\Entity\Comment", mappedBy="trainingSession", cascade={"remove"}, fetch="LAZY")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $commentList;


    public function __construct()
    {
        $this->date = new \Datetime();
        $this->commentList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return TrainingSession
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
     * Set description
     *
     * @param string $description
     * @return TrainingSession
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
     * @return TrainingSession
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
     * Set timeHourStart
     *
     * @param integer $timeHourStart
     * @return TrainingSession
     */
    public function setTimeHourStart($timeHourStart)
    {
        $this->timeHourStart = $timeHourStart;

        return $this;
    }

    /**
     * Get timeHourStart
     *
     * @return integer 
     */
    public function getTimeHourStart()
    {
        return $this->timeHourStart;
    }

    /**
     * Set timeMinuteStart
     *
     * @param integer $timeMinuteStart
     * @return TrainingSession
     */
    public function setTimeMinuteStart($timeMinuteStart)
    {
        $this->timeMinuteStart = $timeMinuteStart;

        return $this;
    }

    /**
     * Get timeMinuteStart
     *
     * @return integer 
     */
    public function getTimeMinuteStart()
    {
        return $this->timeMinuteStart;
    }

    /**
     * Set timeHourEnd
     *
     * @param integer $timeHourEnd
     * @return TrainingSession
     */
    public function setTimeHourEnd($timeHourEnd)
    {
        $this->timeHourEnd = $timeHourEnd;

        return $this;
    }

    /**
     * Get timeHourEnd
     *
     * @return integer 
     */
    public function getTimeHourEnd()
    {
        return $this->timeHourEnd;
    }

    /**
     * Set timeMinuteEnd
     *
     * @param integer $timeMinuteEnd
     * @return TrainingSession
     */
    public function setTimeMinuteEnd($timeMinuteEnd)
    {
        $this->timeMinuteEnd = $timeMinuteEnd;

        return $this;
    }

    /**
     * Get timeMinuteEnd
     *
     * @return integer 
     */
    public function getTimeMinuteEnd()
    {
        return $this->timeMinuteEnd;
    }

    /**
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return TrainingSession
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
     * Set file
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile
     * @return TrainingSession
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

    /**
     * Set contact
     *
     * @param jc\TrainingSessionBundle\Entity\Contact $section
     * @return TrainingSession
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return jc\TrainingSessionBundle\Entity\Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set location
     *
     * @param jc\TrainingSessionBundle\Entity\Location $location
     * @return TrainingSession
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return jc\TrainingSessionBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get comment list
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getCommentList()
    {
        return $this->commentList;
    }
}
