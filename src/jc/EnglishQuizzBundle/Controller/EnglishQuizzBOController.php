<?php

namespace jc\EnglishQuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EnglishQuizzBOController extends Controller {

    /**
     * @Route("/admin", name="jc_english_quizz_bo")
     */
    public function englishQuizzBOAction() {
        return $this->render('jcEnglishQuizzBundle:BO:admin.html.twig');
    }
}
