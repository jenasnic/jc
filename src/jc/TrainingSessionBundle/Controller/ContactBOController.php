<?php

namespace jc\TrainingSessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use jc\TrainingSessionBundle\Entity\Contact;
use jc\TrainingSessionBundle\Form\ContactType;

class ContactBOController extends Controller {

    public function listAction() {

        $contactList = $this->getDoctrine()->getManager()->getRepository('jcTrainingSessionBundle:Contact')->findBy(array(), array('lastname' => 'asc'));
        return $this->render('jcTrainingSessionBundle:BO:contactList.html.twig', array('contactList' => $contactList));
    }

    public function editAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $contact = ($id > 0) ? $entityManager->getRepository('jcTrainingSessionBundle:Contact')->find($id) : new Contact();

        // If user has submit form => save contact
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new ContactType(), $contact);
                $form->bind($request);

                if ($form->isValid()) {

                    $entityManager->persist($contact);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du contact OK');

                    return $this->redirect($this->generateUrl('jc_training_session_bo_contact_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde du contact');
            }
        }
        else
            $form = $this->createForm(new ContactType(), $contact);

        return $this->render('jcTrainingSessionBundle:BO:contactEdit.html.twig', array('contactToEdit' => $form->createView()));
    }

    public function deleteAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $contactToDelete = $entityManager->getRepository('jcTrainingSessionBundle:Contact')->find($id);

                // If contact found => delete it
                if ($contactToDelete != null) {

                    // Check if contact is not used by any training session
                    $isUsed = $entityManager->getRepository('jcTrainingSessionBundle:TrainingSession')->isTrainingSessionWithContact($contactToDelete);

                    if ($isUsed)
                        $this->getRequest()->getSession()->getFlashBag()->add('bo-warning-message', 'Contact utilisé par des stages : suppression impossible');
                    else {

                        $entityManager->remove($contactToDelete);
                        $entityManager->flush();

                        $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du contact OK');
                    }
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du contact');
            }
        }

        // Return to contact list
        return $this->redirect($this->generateUrl('jc_training_session_bo_contact_list'));
    }
}
