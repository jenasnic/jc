<?php

namespace jc\SkyrimBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlchemyController extends Controller {

    public function alchemyAction() {

        $entityManager = $this->getDoctrine()->getManager();

        // Get all ingredients and all effects to display on home page for alchemy
        $ingredientList = $entityManager->getRepository('jcSkyrimBundle:Ingredient')->findBy(array(), array('nameFR' => 'ASC'));
        $effectList = $entityManager->getRepository('jcSkyrimBundle:Effect')->findBy(array(), array('nameFR' => 'ASC'));

        $ingredient = $entityManager->getRepository('jcSkyrimBundle:Ingredient')->find(1);
        $effect = $entityManager->getRepository('jcSkyrimBundle:Effect')->find(1);

        return $this->render('jcSkyrimBundle::alchemy.html.twig', array(
                'ingredientList' => $ingredientList,
                'effectList' => $effectList,
                'ingredient' => $ingredient,
                'effect' => $effect
        ));
    }

    public function ingredientAction($id) {

        $entityManager = $this->getDoctrine()->getManager();

        // Get specified ingredients and search all ingredient reacting with it (i.e. with common effect)
        $ingredient = $entityManager->getRepository('jcSkyrimBundle:Ingredient')->find($id);
        $ingredientList = $entityManager->getRepository('jcSkyrimBundle:Ingredient')->getIngredientListForIngredient($ingredient);

        return $this->render('jcSkyrimBundle::ingredient.html.twig', array(
                'ingredient' => $ingredient,
                'ingredientList' => $ingredientList
        ));
    }

    public function effectAction($id) {

        $entityManager = $this->getDoctrine()->getManager();

        // Get specified effect and search all ingredient with this effect
        $effect = $entityManager->getRepository('jcSkyrimBundle:Effect')->find($id);
        $ingredientList = $entityManager->getRepository('jcSkyrimBundle:Ingredient')->getIngredientListWithEffect($effect);

        return $this->render('jcSkyrimBundle::effect.html.twig', array(
                'effect' => $effect,
                'ingredientList' => $ingredientList
        ));
    }
}
