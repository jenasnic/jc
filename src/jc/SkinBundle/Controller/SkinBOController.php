<?php

namespace jc\SkinBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\SkinBundle\Entity\Skin;
use jc\SkinBundle\Form\SkinType;

class SkinBOController extends Controller {

    /**
     * @Route("/admin/skin/list", name="jc_skin_bo_list")
     */
    public function listSkinAction() {

        $orderedSkinList = $this->getDoctrine()->getManager()->getRepository('jcSkinBundle:Skin')->findBy(array(), array('name' => 'asc'));
        return $this->render('jcSkinBundle:BO:list.html.twig', array('skinList' => $orderedSkinList));
    }

    /**
     * @Route("/admin/skin/default", name="jc_skin_bo_default")
     */
    public function defaultSkinAction(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        // Disallow all skins per default
        $entityManager->getRepository('jcSkinBundle:Skin')->disallowDefaultSkin();

        $id = $request->get('skin-id');

        // Set default skin if exist
        if ($id > 0) {

            $skin = $entityManager->getRepository('jcSkinBundle:Skin')->find($id);
            $skin->setActiv(true);

            $entityManager->persist($skin);
            $entityManager->flush();
        }

        $request->getSession()->getFlashBag()->add('bo-log-message', 'Mise à jour du skin par défaut OK');
        return $this->redirect($this->generateUrl('jc_skin_bo_list'));
    }

    /**
     * @Route("/admin/skin/edit/{id}", defaults={"id" = 0}, name="jc_skin_bo_edit")
     */
    public function editSkinAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $skin = ($id > 0) ? $entityManager->getRepository('jcSkinBundle:Skin')->find($id) : new Skin();

        // If user has submit form => save skin
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(SkinType::class, $skin);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    $entityManager->persist($skin);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du skin OK');

                    return $this->redirect($this->generateUrl('jc_skin_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde du skin');
            }
        }
        else
            $form = $this->createForm(SkinType::class, $skin);

        return $this->render('jcSkinBundle:BO:edit.html.twig', array('skinToEdit' => $form->createView()));
    }

    /**
     * @Route("/admin/skin/delete/{id}", requirements={"id" = "\d+"}, name="jc_skin_bo_delete")
     */
    public function deleteSkinAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $skinToDelete = $entityManager->getRepository('jcSkinBundle:Skin')->find($id);

                // If skin found => delete it
                if ($skinToDelete != null) {

                    $entityManager->remove($skinToDelete);
                    $entityManager->flush();
                }

                $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du skin OK');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du skin');
            }
        }

        // Return to skin list
        return $this->redirect($this->generateUrl('jc_skin_bo_list'));
    }
}
