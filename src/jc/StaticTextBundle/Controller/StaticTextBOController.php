<?php

namespace jc\StaticTextBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\StaticTextBundle\Entity\StaticText;
use jc\StaticTextBundle\Form\StaticTextType;

class StaticTextBOController extends Controller {

    public function listAction() {

        $textList = $this->getDoctrine()->getManager()->getRepository('jcStaticTextBundle:StaticText')->findAll();
        return $this->render('jcStaticTextBundle:BO:listText.html.twig', array('textList' => $textList));
    }

    public function editAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();
        $staticText = ($id > 0) ? $entityManager->getRepository('jcStaticTextBundle:StaticText')->find($id) : new StaticText();

        // If user has submit form => save text
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new StaticTextType(), $staticText);
                $form->bind($request);

                if ($form->isValid()) {

                    $entityManager->persist($staticText);
                    $entityManager->flush();
                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du texte OK');

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
            $form = $this->createForm(new StaticTextType(), $staticText);

        return $this->render('jcStaticTextBundle:BO:editText.html.twig', array('textToEdit' => $form->createView()));
    }

    public function deleteAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $textToDelete = $entityManager->getRepository('jcStaticTextBundle:StaticText')->find($id);

                // If text found => delete it
                if ($textToDelete != null) {

                    $entityManager->remove($textToDelete);
                    $entityManager->flush();
                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du texte OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du texte');
            }
        }

        // Return to text list
        return $this->redirect($this->generateUrl('jc_static_text_bo_list'));
    }
}
