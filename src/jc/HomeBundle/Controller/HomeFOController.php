<?php

namespace jc\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeFOController extends Controller {

    /**
     * @Route("/", name="jc_home_fo")
     */
    public function homeAction() {
        return $this->render('jcHomeBundle:FO:home.html.twig');
    }
}
