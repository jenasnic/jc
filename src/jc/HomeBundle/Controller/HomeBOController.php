<?php

namespace jc\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeBOController extends Controller {

    public function adminAction() {
        return $this->render('jcHomeBundle:BO:admin.html.twig');
    }
}
