<?php

namespace jc\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuFOController extends Controller {

    /**
     * Allows to display menu. It requires both parameters 'rootCurrentPath' and 'rootUri' to define current URL i.E. activ menu.<br/>
     * To use menu inside template (app/Resources/views), you need to define current path to identify current selected menu :<br/>
     * {% set currentPath = path(app.request.attributes.get('_route'), app.request.attributes.get('_route_params')) %}<br/>
     * {{ render(controller("jcMenuBundle:MenuFO:display", {rootCurrentPath: currentPath, rootUri : app.request.uri})) }}<br/>
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayAction() {

        $request = $this->getRequest();

        $orderedMenuList = $this->getDoctrine()->getManager()->getRepository('jcMenuBundle:Menu')->findBy(array(), array('rank' => 'asc'));

        return $this->render('jcMenuBundle:FO:menu.html.twig', array(
                'menuList' => $orderedMenuList,
                'rootCurrentPath' => $request->get('rootCurrentPath'),
                'rootUri' => $request->get('rootUri')
        ));
    }
}
