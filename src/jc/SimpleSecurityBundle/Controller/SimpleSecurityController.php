<?php

namespace jc\SimpleSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class SimpleSecurityController extends Controller {

    public function loginAction() {

        // If user already logged => back to BO home
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            return $this->redirect($this->generateUrl('jc_home_bo'));

        return $this->render('jcSimpleSecurityBundle::login.html.twig');
    }

    private function getEncodedPassword($password, $algorithm) {

        $encoder = new MessageDigestPasswordEncoder($algorithm);
        return $encoder->encodePassword($password, null);
    }
}
