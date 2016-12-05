<?php

namespace jc\StaticTextBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use jc\StaticTextBundle\Entity\StaticText;

class StaticTextFOController extends Controller {

    /**
     * Allows to include static text in code : {{ render(controller("jcStaticTextBundle:StaticTextFO:display", {'code': 'XXX' })) }}
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/staticText/{code}", name="jc_static_text_fo")
     */
    public function displayAction($code) {

        $textFound = $this->getDoctrine()->getManager()->getRepository(StaticText::class)->findBy(array('code' => $code));

        if (count($textFound) > 0)
            return $this->render('jcStaticTextBundle:FO:staticText.html.twig', array('text' => $textFound[0]));
        else
            return new Response('<!-- No text found -->');
    }
}
