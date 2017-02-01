<?php

namespace jc\MenuBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\MenuBundle\Entity\Menu;
use jc\MenuBundle\Form\MenuType;

class MenuBOController extends Controller {

    /**
     * @Route("/admin/menu/list", name="jc_menu_bo_list")
     */
    public function listMenuAction(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        // If user has submit form => save new menu order and menu width (if necessary)
        if ($request->getMethod() == 'POST') {

            try {

                // Get field with new menu order
                $newOrderedList = $request->request->get('ordered-menu-list');

                if ($newOrderedList != null) {

                    $newOrderedList = explode('&', str_replace('menu-list[]=', '', $newOrderedList));

                    // Browse each menu and update rank if necessary
                    for($i = 0; $i < count($newOrderedList); $i ++) {

                        $menuToUpdate = $entityManager->getRepository(Menu::class)->find($newOrderedList[$i]);

                        if ($menuToUpdate->getRank() != ($i + 1)) {

                            $menuToUpdate->setRank($i + 1);
                            $entityManager->persist($menuToUpdate);
                        }
                    }
                }

                // Get field with new width
                $newWidthList = $request->request->get('width-menu-list');

                if ($newWidthList != null) {

                    $newWidthList = explode(';', $newWidthList);

                    // Browse each menu and update width if necessary
                    foreach($newWidthList as $newWidthItem) {

                        // NOTE : Each width item are composed as follow : [ID]:[width]
                        $newWidthItem = explode(':', $newWidthItem);

                        $menuToUpdate = $entityManager->getRepository(Menu::class)->find($newWidthItem[0]);

                        if ($menuToUpdate->getWidth() != $newWidthItem[1]) {

                            $menuToUpdate->setWidth($newWidthItem[1]);
                            $entityManager->persist($menuToUpdate);
                        }
                    }
                }

                $entityManager->flush();
                $request->getSession()->getFlashBag()->add('bo-log-message', 'Classement et redimensionnement des menus OK');
            }
            catch(Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors du classement des menus');
            }
        }

        $orderedMenuList = $entityManager->getRepository(Menu::class)->findBy(array(), array('rank' => 'asc'));

        return $this->render('jcMenuBundle:BO:list.html.twig', array('menuList' => $orderedMenuList));
    }

    /**
     * @Route("/admin/menu/edit/{id}", defaults={"id" = 0}, name="jc_menu_bo_edit")
     */
    public function editMenuAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $menu = ($id > 0) ? $entityManager->getRepository(Menu::class)->find($id) : new Menu();

        // If user has submit form => save menu
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(MenuType::class, $menu);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    // For new menu => set rank and default width
                    if ($menu->getId() == null || $menu->getId() == 0) {

                        $menu->setRank($entityManager->getRepository(Menu::class)->getMaxRank() + 1);
                        $menu->setWidth(110);
                    }

                    $entityManager->persist($menu);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du menu OK');

                    return $this->redirect($this->generateUrl('jc_menu_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch(Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde du menu');
            }
        }
        else
            $form = $this->createForm(MenuType::class, $menu);

        return $this->render('jcMenuBundle:BO:edit.html.twig', array('menuToEdit' => $form->createView()));
    }

    /**
     * @Route("/admin/menu/delete/{id}", requirements={"id" = "\d+"}, name="jc_menu_bo_delete")
     */
    public function deleteMenuAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $menuToDelete = $entityManager->getRepository(Menu::class)->find($id);

                // If menu found => delete it
                if ($menuToDelete != null) {

                    $entityManager->remove($menuToDelete);
                    $entityManager->flush();
                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du menu OK');
                }
            }
            catch(Exception $e) {
                $request()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du menu');
            }
        }

        // Return to menu list
        return $this->redirect($this->generateUrl('jc_menu_bo_list'));
    }
}
