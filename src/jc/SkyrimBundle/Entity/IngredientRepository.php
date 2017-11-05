<?php

namespace jc\SkyrimBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IngredientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IngredientRepository extends EntityRepository
{
    /**
     * Allows to get all ingredients with specified effect.
     * @param Effect $effect Effect we want to get matching ingredients.
     * @return List of ingredients with specified effect.
     */
    public function getIngredientListWithEffect($effect) {

        $query = $this->_em->createQuery('SELECT i FROM jcSkyrimBundle:Ingredient i WHERE :effect MEMBER OF i.effectList');
        $query->setParameter('effect', $effect);

        return $query->getResult();
    }

    /**
     * Allows to get all ingredients reacting with specified ingredient (i.e. with common effects).
     * @param Ingredient $ingredient Ingredient we want to know other ingredients with common effects.
     * @return List of ingredients containing common effects with specified ingredient.
     */
    public function getIngredientListForIngredient($ingredient) {

        $queryBuilder = $this->createQueryBuilder('i');

        $index = 1;
        foreach ($ingredient->getEffectList() as $effect) {

            $varName = 'effect' . $index++;
            $queryBuilder = $queryBuilder->orWhere(':' . $varName . ' MEMBER OF i.effectList')->setParameter($varName, $effect);
        }

        $queryBuilder = $queryBuilder->orderBy('i.nameFR', 'ASC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
