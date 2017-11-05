<?php

namespace jc\SkyrimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Effect
 *
 * @ORM\Table(name="effect"))
 * @ORM\Entity(repositoryClass="jc\SkyrimBundle\Entity\EffectRepository")
 */
class Effect
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
     * @ORM\Column(name="nameFR", type="string", length=255)
     */
    private $nameFR;

    /**
     * @var string
     *
     * @ORM\Column(name="nameEN", type="string", length=255)
     */
    private $nameEN;


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
     * Set nameFR
     *
     * @param string $nameFR
     * @return Effect
     */
    public function setNameFR($nameFR)
    {
        $this->nameFR= $nameFR;

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
     * Set nameEN
     *
     * @param string $name
     * @return Effect
     */
    public function setNameEN($nameEN)
    {
        $this->nameEN= $nameEN;

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
}
