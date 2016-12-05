<?php

namespace jc\MenuBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\MenuBundle\Entity\Menu;

class MenuFOController extends Controller {

    /**
     * @Route("/layout/menu", name="jc_menu_fo")
     */
    public function displayAction(Request $request) {

        $orderedMenuList = $this->getDoctrine()->getManager()->getRepository(Menu::class)->findBy(array(), array('rank' => 'asc'));

        return $this->render('jcMenuBundle:FO:menu.html.twig', array(
                'menuList' => $orderedMenuList,
                'rootCurrentPath' => $request->get('rootCurrentPath'),
                'rootUri' => $request->get('rootUri')));
    }
}
