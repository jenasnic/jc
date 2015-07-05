<?php

namespace jc\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\MenuBundle\Entity\Menu;
use jc\MenuBundle\Form\MenuType;

class MenuBOController extends Controller {

    public function listMenuAction() {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        // If user has submit form => save new menu order (if necessary)
        if ($request->getMethod() == 'POST') {

            try {

                // Get field with new menu order
                $newOrderedList = $request->request->get('ordered-menu-list');

                if ($newOrderedList != null) {
                    $newOrderedList = explode('&', str_replace('menu-list[]=', '', $newOrderedList));

                    // Browse each menu and update rank if necessary
                    for($i = 0; $i < count($newOrderedList); $i ++) {

                        $menuToUpdate = $entityManager->getRepository('jcMenuBundle:Menu')->find($newOrderedList[$i]);
                        if ($menuToUpdate->getRank() != ($i + 1)) {

                            $menuToUpdate->setRank($i + 1);
                            $entityManager->persist($menuToUpdate);
                        }
                    }
                }

                $entityManager->flush();
                $request->getSession()->getFlashBag()->add('bo-log-message', 'Classement des menus OK');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors du classement des menus');
            }
        }

        $orderedMenuList = $entityManager->getRepository('jcMenuBundle:Menu')->findBy(array(), array('rank' => 'asc'));

        return $this->render('jcMenuBundle:BO:list.html.twig', array('menuList' => $orderedMenuList));
    }

    public function editMenuAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $menu = ($id > 0) ? $entityManager->getRepository('jcMenuBundle:Menu')->find($id) : new Menu();

        // If user has submit form => save menu
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new MenuType(), $menu);
                $form->bind($request);

                if ($form->isValid()) {

                    // For new menu => set rank
                    if ($menu->getId() == null || $menu->getId() == 0)
                        $menu->setRank($entityManager->getRepository('jcMenuBundle:Menu')->getMaxRank() + 1);

                    $entityManager->persist($menu);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du menu OK');

                    return $this->redirect($this->generateUrl('jc_menu_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde du menu');
            }
        }
        else
            $form = $this->createForm(new MenuType(), $menu);

        return $this->render('jcMenuBundle:BO:edit.html.twig', array('menuToEdit' => $form->createView()));
    }

    public function deleteMenuAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $menuToDelete = $entityManager->getRepository('jcMenuBundle:Menu')->find($id);

                // If menu found => delete it
                if ($menuToDelete != null) {

                    $entityManager->remove($menuToDelete);
                    $entityManager->flush();
                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du menu OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du menu');
            }
        }

        // Return to menu list
        return $this->redirect($this->generateUrl('jc_menu_bo_list'));
    }
}
