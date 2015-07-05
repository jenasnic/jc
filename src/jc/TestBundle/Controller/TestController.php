<?php

namespace jc\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller {

    public function testAction() {
        return $this->render('jcTestBundle::test.html.twig', array("message" => "Test"));
    }

    public function path1Action() {
        return $this->render('jcTestBundle::test.html.twig', array("message" => "Page for path 1"));
    }

    public function path2Action() {
        return $this->render('jcTestBundle::test.html.twig', array("message" => "Page for path 2"));
    }

    public function path3Action() {
        return $this->render('jcTestBundle::test.html.twig', array("message" => "Page for path 3"));
    }

    public function boAction() {
        return $this->render('jcTestBundle::bo.html.twig');
    }
}
