<?php

namespace jc\StaticTextBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class StaticTextFOController extends Controller {

    /**
     * Allows to include static text in code : {{ render(controller("jcStaticTextBundle:StaticTextFO:display", {'code': 'XXX' })) }}
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayAction($code) {

        $textFound = $this->getDoctrine()->getManager()->getRepository('jcStaticTextBundle:StaticText')->findBy(array('code' => $code));

        if (count($textFound) > 0)
            return $this->render('jcStaticTextBundle:FO:displayText.html.twig', array('text' => $textFound[0]));
        else
            return new Response('<!-- No text found -->');
    }
}
