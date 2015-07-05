<?php

namespace jc\TrainingSessionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="trainingSessionComment")
 * @ORM\Entity(repositoryClass="jc\TrainingSessionBundle\Entity\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var jc\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="jc\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="authorId", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @var jc\TrainingSessionBundle\Entity\TrainingSession
     *
     * @ORM\ManyToOne(targetEntity="jc\TrainingSessionBundle\Entity\TrainingSession", fetch="LAZY")
     * @ORM\JoinColumn(name="trainingSessionId", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trainingSession;


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
     * Set text
     *
     * @param string $text
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
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
     * Set author
     *
     * @param jc\UserBundle\Entity\User $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return jc\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set training session
     *
     * @param jc\TrainingSessionBundle\Entity\TrainingSession $trainingSession
     * @return Comment
     */
    public function setTrainingSession($trainingSession)
    {
        $this->trainingSession = $trainingSession;

        return $this;
    }

    /**
     * Get training session
     *
     * @return jc\TrainingSessionBundle\Entity\TrainingSession
     */
    public function getTrainingSession()
    {
        return $this->trainingSession;
    }
}
