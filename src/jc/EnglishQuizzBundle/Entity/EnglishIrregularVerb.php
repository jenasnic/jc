<?php

namespace jc\EnglishQuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnglishIrregularVerb
 *
 * @ORM\Table(name="englishIrregularVerb")
 * @ORM\Entity(repositoryClass="jc\EnglishQuizzBundle\Repository\EnglishIrregularVerbRepository")
 */
class EnglishIrregularVerb
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
     * @ORM\Column(name="verbEN", type="string", length=55, unique=true)
     */
    private $verbEN;

    /**
     * @var string
     *
     * @ORM\Column(name="verbFR", type="string", length=255)
     */
    private $verbFR;

    /**
     * @var string
     *
     * @ORM\Column(name="preterit", type="string", length=55)
     */
    private $preterit;

    /**
     * @var string
     *
     * @ORM\Column(name="past", type="string", length=55)
     */
    private $past;


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
     * Set verbEN
     *
     * @param string $verbEN
     * @return EnglishIrregularVerb
     */
    public function setVerbEN($verbEN)
    {
        $this->verbEN = $verbEN;

        return $this;
    }

    /**
     * Get verbEN
     *
     * @return string
     */
    public function getVerbEN()
    {
        return $this->verbEN;
    }

    /**
     * Set verbFR
     *
     * @param string $verbFR
     * @return EnglishIrregularVerb
     */
    public function setVerbFR($verbFR)
    {
        $this->verbFR = $verbFR;

        return $this;
    }

    /**
     * Get verbFR
     *
     * @return string
     */
    public function getVerbFR()
    {
        return $this->verbFR;
    }

    /**
     * Set preterit
     *
     * @param string $preterit
     * @return EnglishIrregularVerb
     */
    public function setPreterit($preterit)
    {
        $this->preterit = $preterit;

        return $this;
    }

    /**
     * Get preterit
     *
     * @return string
     */
    public function getPreterit()
    {
        return $this->preterit;
    }

    /**
     * Set past
     *
     * @param string $past
     * @return EnglishIrregularVerb
     */
    public function setPast($past)
    {
        $this->past = $past;

        return $this;
    }

    /**
     * Get past
     *
     * @return string
     */
    public function getPast()
    {
        return $this->past;
    }

    public function reverseLanguage() {

        $temp = $this->verbEN;
        $this->verbEN = $this->verbFR;
        $this->verbFR = $temp;
    }
}
