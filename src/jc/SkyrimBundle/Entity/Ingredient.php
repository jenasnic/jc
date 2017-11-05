<?php

namespace jc\SkyrimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="jc\SkyrimBundle\Entity\IngredientRepository")
 */
class Ingredient
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
     * @var ArrayCollection $effectList
     *
     * @ORM\ManyToMany(targetEntity="jc\SkyrimBundle\Entity\Effect", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="ingredient_effect",
     *      joinColumns={@ORM\JoinColumn(name="id_ingredient", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_effect", referencedColumnName="id")}
     * )
     */
    private $effectList;


    public function __construct()
    {
        $this->effectList = new ArrayCollection();
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

    /**
     * Add effect to ingredient
     *
     * @param Effect $effect
     * @return Ingredient
     */
    public function addEffect(Effect $effect)
    {
        $this->effectList[] = $effect;
        return $this;
    }

    /**
     * Remove effet from ingredient
     *
     * @param Effect $effect
     */
    public function removeEffect(Effect $effect)
    {
        $this->effectList->removeElement($effect);
    }

    /**
     * Get effect list
     *
     * @return ArrayCollection
     */
    public function getEffectList()
    {
        return $this->effectList;
    }
}
