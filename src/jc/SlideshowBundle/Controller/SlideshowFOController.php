<?php

namespace jc\SlideshowBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\SlideshowBundle\Entity\Slideshow;

class SlideshowFOController extends Controller {

    /**
     * @Route("/albums/{id}", name="jc_slideshow_fo", defaults={"id" = 0})
     */
    public function indexAction($id) {

        if ($id == 0) {

            $slideshowList = $this->getDoctrine()->getManager()->getRepository(Slideshow::class)->findBy(array(), array('rank' => 'asc'));
            return $this->render('jcSlideshowBundle:FO:index.html.twig', array('slideshowList' => $slideshowList));
        }
        else {

            $slideshow = $this->getDoctrine()->getManager()->getRepository(Slideshow::class)->find($id);
            return $this->render('jcSlideshowBundle:FO:slideshow.html.twig', array('slideshow' => $slideshow));
        }
    }
}
