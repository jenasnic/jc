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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     * @return Ingredient
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
