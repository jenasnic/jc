<?php

namespace jc\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeFOController extends Controller {

    public function homeAction() {
        return $this->render('jcHomeBundle:FO:home.html.twig');
    }
}
