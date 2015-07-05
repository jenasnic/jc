<?php

namespace jc\DoodleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Doodle
 *
 * @ORM\Table(name="doodle")
 * @ORM\Entity(repositoryClass="jc\DoodleBundle\Entity\DoodleRepository")
 */
class Doodle
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
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventDate", type="datetime")
     */
    private $eventDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="replyDate", type="datetime")
     */
    private $replyDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sent", type="boolean")
     */
    private $sent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="closed", type="boolean")
     */
    private $closed;

    /**
     * @var ArrayCollection $replyList
     *
     * @ORM\OneToMany(targetEntity="jc\DoodleBundle\Entity\DoodleReply", mappedBy="doodle", cascade={"remove"}, fetch="LAZY")
     */
    private $replyList;


    public function __construct()
    {
        $this->replyList = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Doodle
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
     * Set comment
     *
     * @param string $comment
     * @return Doodle
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $date
     * @return Doodle
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set replyDate
     *
     * @param \DateTime $replyDate
     * @return Doodle
     */
    public function setReplyDate($replyDate)
    {
        $this->replyDate = $replyDate;

        return $this;
    }

    /**
     * Get replyDate
     *
     * @return \DateTime 
     */
    public function getReplyDate()
    {
        return $this->replyDate;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     * @return Doodle
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
    
        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set closed
     *
     * @param boolean $closed
     * @return News
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    
        return $this;
    }

    /**
     * Get closed
     *
     * @return boolean
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Get reply list
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getReplyList()
    {
        return $this->replyList;
    }
}
