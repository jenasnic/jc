<?php

namespace jc\StaticTextBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\StaticTextBundle\Entity\StaticText;
use jc\StaticTextBundle\Form\StaticTextType;

class StaticTextBOController extends Controller {

    /**
     * @Route("/admin/staticText/list", name="jc_static_text_bo_list")
     */
    public function listAction(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        // If user has submit form => save new static text order (if necessary)
        if ($request->getMethod() == 'POST') {

            try {

                // Get field with new static text order
                $newOrderedList = $request->request->get('ordered-text-list');

                if ($newOrderedList != null) {
                    $newOrderedList = explode('&', str_replace('text-list[]=', '', $newOrderedList));

                    // Browse each text and update rank if necessary
                    for($i = 0; $i < count($newOrderedList); $i ++) {

                        $textToUpdate = $entityManager->getRepository('jcStaticTextBundle:StaticText')->find($newOrderedList[$i]);
                        if ($textToUpdate->getRank() != ($i + 1)) {

                            $textToUpdate->setRank($i + 1);
                            $entityManager->persist($textToUpdate);
                        }
                    }
                }

                $entityManager->flush();
                $request->getSession()->getFlashBag()->add('bo-log-message', 'Classement OK');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors du classement');
            }
        }

        $textList = $this->getDoctrine()->getManager()->getRepository('jcStaticTextBundle:StaticText')->findBy(array(), array('rank' => 'asc'));
        return $this->render('jcStaticTextBundle:BO:listText.html.twig', array('textList' => $textList));
    }

    /**
     * @Route("/admin/staticText/config/{code}", defaults={"code" = ""}, name="jc_static_text_bo_config")
     */
    public function configAction(Request $request, $code) {

        $staticTextIdToEdit = 0;

        if (strlen($code) > 0) {

            $matchingTextList = $this->getDoctrine()->getManager()->getRepository('jcStaticTextBundle:StaticText')->findBy(array('code' => $code));
            if (count($matchingTextList) == 1)
                $staticTextIdToEdit = $matchingTextList[0]->getId();
            else
                $request->getSession()->getFlashBag()->add('bo-warning-message', 'Contenu introuvable');
        }

        return $this->editAction($request, $staticTextIdToEdit, true);
    }

    /**
     * @Route("/admin/staticText/edit/{id}", defaults={"id" = 0}, name="jc_static_text_bo_edit")
     */
    public function editAction(Request $request, $id, $editByCode = false) {

        $entityManager = $this->getDoctrine()->getManager();

        // In case of edition by code => load static text list
        if ($editByCode) {

            $staticTextList = $entityManager->getRepository('jcStaticTextBundle:StaticText')->findBy(array('published' => true), array('rank' => 'asc'));
            $staticText = ($id > 0) ? $entityManager->getRepository('jcStaticTextBundle:StaticText')->find($id) : null;
        }
        else {

            $staticTextList = null;
            $staticText = ($id > 0) ? $entityManager->getRepository('jcStaticTextBundle:StaticText')->find($id) : new StaticText();
        }

        // If user has submit form => save text
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(StaticTextType::class, $staticText);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    // For new static text => set rank
                    if ($staticText->getId() == null || $staticText->getId() == 0)
                        $staticText->setRank($entityManager->getRepository('jcStaticTextBundle:StaticText')->getMaxRank() + 1);

                    $entityManager->persist($staticText);
                    $entityManager->flush();
                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du texte OK');

                    // Custom implementation when editing by ID (not by code) => for full admin only ;-)
                    if (!$editByCode)
                        return $this->redirect($this->generateUrl('jc_static_text_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde du texte');
            }
        }
        else
            $form = $this->createForm(StaticTextType::class, $staticText);

        $formView = (!$editByCode || $staticText != null) ? $form->createView() : null;

        return $this->render('jcStaticTextBundle:BO:editText.html.twig', array(
                'textToEdit' => $formView,
                'editByCode' => $editByCode,
                'textList' => $staticTextList));
    }

    /**
     * @Route("/admin/staticText/delete/{id}", requirements={"id" = "\d+"}, name="jc_static_text_bo_delete")
     */
    public function deleteAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $textToDelete = $entityManager->getRepository('jcStaticTextBundle:StaticText')->find($id);

                // If text found => delete it
                if ($textToDelete != null) {

                    $entityManager->remove($textToDelete);
                    $entityManager->flush();
                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du texte OK');
                }
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du texte');
            }
        }

        // Return to text list
        return $this->redirect($this->generateUrl('jc_static_text_bo_list'));
    }
}
