<?php

namespace jc\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller {

    public function loginAction() {

        $request = $this->getRequest();

        return $this->render('jcUserBundle:FO:login.html.twig', array(
                'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
                'error' => $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR)
        ));
    }
}
