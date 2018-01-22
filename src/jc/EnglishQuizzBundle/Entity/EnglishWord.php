<?php

namespace jc\EnglishQuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnglishWord
 *
 * @ORM\Table(name="englishWord")
 * @ORM\Entity(repositoryClass="jc\EnglishQuizzBundle\Repository\EnglishWordRepository")
 */
class EnglishWord
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
     * @ORM\Column(name="nameEN", type="string", length=55, unique=true)
     */
    private $nameEN;

    /**
     * @var string
     *
     * @ORM\Column(name="nameFR", type="string", length=255)
     */
    private $nameFR;

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
     * Set nameEN
     *
     * @param string $nameEN
     * @return EnglishWord
     */
    public function setNameEN($nameEN)
    {
        $this->nameEN = $nameEN;

        return $this;
    }

    /**
     * Get nameEN
     *
     * @return string
     */
    public function getNameEN()
    {
        return $this->nameEN;
    }

    /**
     * Set nameFR
     *
     * @param string $nameFR
     * @return EnglishWord
     */
    public function setNameFR($nameFR)
    {
        $this->nameFR = $nameFR;

        return $this;
    }

    /**
     * Get nameFR
     *
     * @return string
     */
    public function getNameFR()
    {
        return $this->nameFR;
    }

    /**
     * Set lesson
     *
     * @param integer $lesson
     * @return EnglishWord
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
     * @return EnglishWord
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

        $temp = $this->nameEN;
        $this->nameEN = $this->nameFR;
        $this->nameFR = $temp;
    }
}
