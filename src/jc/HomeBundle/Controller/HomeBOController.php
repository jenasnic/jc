<?php

namespace jc\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeBOController extends Controller {

    /**
     * @Route("/admin", name="jc_home_bo")
     */
    public function adminAction() {
        return $this->render('jcHomeBundle:BO:admin.html.twig');
    }

    /**
     * @Route("/admin/", name="jc_home_bo_redirect")
     */
    public function adminRedirectAction() {
        return $this->redirect($this->generateUrl('jc_home_bo'));
    }
}
