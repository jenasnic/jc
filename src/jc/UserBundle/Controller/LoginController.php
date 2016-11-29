<?php

namespace jc\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller {

    /**
     * @Route("/login", name="login")
     */
    public function loginAction() {

        $helper = $this->get('security.authentication_utils');

        return $this->render('jcUserBundle:FO:login.html.twig', array(
                'last_username' => $helper->getLastUsername(),
                'error' => $helper->getLastAuthenticationError(),
        ));
    }
}
