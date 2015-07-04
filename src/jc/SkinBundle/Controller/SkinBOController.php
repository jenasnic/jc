<?php

namespace jc\SkinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\SkinBundle\Entity\Skin;
use jc\SkinBundle\Form\SkinType;

class SkinBOController extends Controller {

    public function listSkinAction() {

        $orderedSkinList = $this->getDoctrine()->getManager()->getRepository('jcSkinBundle:Skin')->findBy(array(), array('name' => 'asc'));
        return $this->render('jcSkinBundle:BO:list.html.twig', array('skinList' => $orderedSkinList));
    }

    public function defaultSkinAction() {

        $request = $this->getRequest();
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

    public function editSkinAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $skin = ($id > 0) ? $entityManager->getRepository('jcSkinBundle:Skin')->find($id) : new Skin();

        // If user has submit form => save skin
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new SkinType(), $skin);
                $form->bind($request);

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
            $form = $this->createForm(new SkinType(), $skin);

        return $this->render('jcSkinBundle:BO:edit.html.twig', array('skinToEdit' => $form->createView()));
    }

    public function deleteSkinAction($id) {

        if ($id > 0) {

            $request = $this->getRequest();

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
