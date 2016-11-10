<?php

namespace jc\SkinBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SkinFOController extends Controller {

    /**
     * Allows to include specific CSS file for theming.<br/>
     * To use activ skin, add following line in template header :
     * {{ render(controller("jcSkinBundle:SkinFO:display")) }}
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/layout/skin", name="jc_skin_fo")
     */
    public function displayAction() {

        $skinToUse = $this->getDoctrine()->getManager()->getRepository('jcSkinBundle:Skin')->findBy(array('activ' => 1));

        if (count($skinToUse) != 1)
            return new Response('<!-- No skin to use -->');
        else {

            $skinUrl = $this->get('templating.helper.assets')->getUrl($skinToUse[0]->getCssFile());
            return new Response('<link rel="stylesheet" type="text/css" href="' . $skinUrl . '" />');
        }
    }
}
