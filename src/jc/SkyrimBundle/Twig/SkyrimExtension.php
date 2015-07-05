<?php

namespace jc\SkyrimBundle\Twig;

class SkyrimExtension extends \Twig_Extension {

    public function getName() {
        return 'skyrim_twig_extension';
    }

    public function getFunctions() {
        return array('containsEffect' => new \Twig_Function_Method($this, 'ingredientContainsEffect'));
    }

    /**
     * @param jc\SkyrimBundle\Entity\Ingredient $ingredient
     * @param jc\SkyrimBundle\Entity\Effect $effect
     * @return boolean TRUE if specified ingredient contains specified effect, FALSE either.
     */
    public function ingredientContainsEffect($ingredient, $effect) {

        foreach ($ingredient->getEffectList() as $ingredientEffect) {

            if ($ingredientEffect->getId() == $effect->getId())
                return true;
        }

        return false;
    }
}
