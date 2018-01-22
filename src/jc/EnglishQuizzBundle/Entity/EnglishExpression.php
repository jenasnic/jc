<?php

namespace jc\EnglishQuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnglishExpression
 *
 * @ORM\Table(name="englishExpression")
 * @ORM\Entity(repositoryClass="jc\EnglishQuizzBundle\Repository\EnglishExpressionRepository")
 */
class EnglishExpression
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
     * @ORM\Column(name="textEN", type="string", length=255, unique=true)
     */
    private $textEN;

    /**
     * @var string
     *
     * @ORM\Column(name="textFR", type="string", length=255)
     */
    private $textFR;

    /**
     * @var int
     *
     * @ORM\Column(name="lesson", type="integer")
     */
    private $lesson = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="page", type="integer")
     */
    private $page = 0;


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
     * Set textEN
     *
     * @param string $textEN
     * @return EnglishExpression
     */
    public function setTextEN($textEN)
    {
        $this->textEN = $textEN;

        return $this;
    }

    /**
     * Get textEN
     *
     * @return string
     */
    public function getTextEN()
    {
        return $this->textEN;
    }

    /**
     * Set textFR
     *
     * @param string $textFR
     * @return EnglishExpression
     */
    public function setTextFR($textFR)
    {
        $this->textFR = $textFR;

        return $this;
    }

    /**
     * Get textFR
     *
     * @return string
     */
    public function getTextFR()
    {
        return $this->textFR;
    }

    /**
     * Set lesson
     *
     * @param integer $lesson
     * @return EnglishExpression
     */
    public function setLesson($lesson)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Get lesson
     *
     * @return integer
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * Set page
     *
     * @param integer $page
     * @return EnglishExpression
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    public function reverseLanguage() {

        $temp = $this->textEN;
        $this->textEN = $this->textFR;
        $this->textFR = $temp;
    }
}
