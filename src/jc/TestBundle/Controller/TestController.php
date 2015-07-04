<?php

namespace jc\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller {

    public function testAction() {
        return $this->render('jcTestBundle::test.html.twig');
    }
}
