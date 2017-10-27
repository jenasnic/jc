<?php

namespace jc\QuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Winner
 *
 * @ORM\Table(name="winner")
 * @ORM\Entity(repositoryClass="jc\QuizzBundle\Repository\WinnerRepository")
 */
class Winner
{
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="trickCount", type="integer")
     */
    private $trickCount;

    /**
     * @var jc\QuizzBundle\Entity\Quizz
     *
     * @ORM\ManyToOne(targetEntity="jc\QuizzBundle\Entity\Quizz")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quizz;


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
     * @return Winner
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
     * Set mail
     *
     * @param string $mail
     * @return Winner
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Winner
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
     * Set date
     *
     * @param \DateTime $date
     * @return Winner
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
     * Set trickCount
     *
     * @param integer $trickCount
     * @return QuizzResponse
     */
    public function setTrickCount($trickCount)
    {
        $this->trickCount = $trickCount;

        return $this;
    }

    /**
     * Get trickCount
     *
     * @return integer
     */
    public function getTrickCount()
    {
        return $this->trickCount;
    }

    /**
     * Set quizz
     *
     * @param jc\QuizzBundle\Entity\Quizz $quizz
     * @return Winner
     */
    public function setQuizz($quizz)
    {
        $this->quizz = $quizz;

        return $this;
    }

    /**
     * Get quizz
     *
     * @return jc\QuizzBundle\Entity\Quizz
     */
    public function getQuizz()
    {
        return $this->quizz;
    }
}
