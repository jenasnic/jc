<?php

namespace jc\QuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizzResponse
 *
 * @ORM\Table(name="quizzResponse")
 * @ORM\Entity(repositoryClass="jc\QuizzBundle\Repository\QuizzResponseRepository")
 */
class QuizzResponse
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="responses", type="text")
     */
    private $responses;

    /**
     * @var string
     *
     * @ORM\Column(name="trick", type="text")
     */
    private $trick;

    /**
     * @var int
     *
     * @ORM\Column(name="positionX", type="integer")
     */
    private $positionX;

    /**
     * @var int
     *
     * @ORM\Column(name="positionY", type="integer")
     */
    private $positionY;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var jc\QuizzBundle\Entity\Quizz
     *
     * @ORM\ManyToOne(targetEntity="jc\QuizzBundle\Entity\Quizz", inversedBy="responses")
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
     * Set title
     *
     * @param string $title
     * @return QuizzResponse
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
     * Set responses
     *
     * @param string $responses
     * @return QuizzResponse
     */
    public function setResponses($responses)
    {
        $this->responses = $responses;

        return $this;
    }

    /**
     * Get responses
     *
     * @return string
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Set trick
     *
     * @param string $trick
     * @return QuizzResponse
     */
    public function setTrick($trick)
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Get trick
     *
     * @return string
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * Set positionX
     *
     * @param integer $positionX
     * @return QuizzResponse
     */
    public function setPositionX($positionX)
    {
        $this->positionX = $positionX;

        return $this;
    }

    /**
     * Get positionX
     *
     * @return integer
     */
    public function getPositionX()
    {
        return $this->positionX;
    }

    /**
     * Set positionY
     *
     * @param integer $positionY
     * @return QuizzResponse
     */
    public function setPositionY($positionY)
    {
        $this->positionY = $positionY;

        return $this;
    }

    /**
     * Get positionY
     *
     * @return integer
     */
    public function getPositionY()
    {
        return $this->positionY;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return QuizzResponse
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set quizz
     *
     * @param jc\QuizzBundle\Entity\Quizz $quizz
     * @return QuizzResponse
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
