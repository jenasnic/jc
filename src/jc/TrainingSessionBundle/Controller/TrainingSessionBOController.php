<?php

namespace jc\TrainingSessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use jc\TrainingSessionBundle\Entity\TrainingSession;
use jc\TrainingSessionBundle\Form\TrainingSessionType;

class TrainingSessionBOController extends Controller {

    public function listAction() {

        $trainingSessionList = $this->getDoctrine()->getManager()->getRepository('jcTrainingSessionBundle:TrainingSession')->findBy(array(), array('date' => 'asc'));
        return $this->render('jcTrainingSessionBundle:BO:trainingSessionList.html.twig', array('trainingSessionList' => $trainingSessionList));
    }

    public function editAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $trainingSession = ($id > 0) ? $entityManager->getRepository('jcTrainingSessionBundle:TrainingSession')->find($id) : new TrainingSession();

        // If user has submit form => save training session
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new TrainingSessionType(), $trainingSession);
                $form->bind($request);

                // If no picture already loaded nor uploaded picture => add error
                /*
                 * if ($trainingSession->getPictureUrl() == null && $trainingSession->getPictureFile() == null) $form->get('pictureFile')->addError(new FormError("Aucune image n'a encore été chargée : vous devez charger une image"));
                 */

                if ($form->isValid()) {

                    // Process upload
                    $this->processUpload($trainingSession);

                    $entityManager->persist($trainingSession);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du stage OK');

                    return $this->redirect($this->generateUrl('jc_training_session_bo_session_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde du stage');
            }
        }
        else
            $form = $this->createForm(new TrainingSessionType(), $trainingSession);

        return $this->render('jcTrainingSessionBundle:BO:trainingSessionEdit.html.twig', array(
                'trainingSessionToEdit' => $form->createView()
        ));
    }

    public function deleteAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $trainingSessionToDelete = $entityManager->getRepository('jcTrainingSessionBundle:TrainingSession')->find($id);

                // If training session found => delete it
                if ($trainingSessionToDelete != null) {

                    $fileToDelete = $this->container->getParameter('kernel.root_dir') . '/../web' . $trainingSessionToDelete->getPictureUrl();

                    $entityManager->remove($trainingSessionToDelete);
                    $entityManager->flush();

                    // Delete session picture file if exist
                    if (file_exists($fileToDelete) && is_file($fileToDelete))
                        unlink($fileToDelete);

                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du stage OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du stage');
            }
        }

        // Return to training session list
        return $this->redirect($this->generateUrl('jc_training_session_bo_session_list'));
    }

    /**
     * Allows to upload file defined in TrainingSession object.
     * @param TrainingSession $trainingSession
     */
    private function processUpload($trainingSession) {

        // If picture is defined => process upload
        if (null !== $trainingSession->getPictureFile()) {

            $relativeFolderPath = $this->container->getParameter('jc_training_session.root_path');
            $absoluteFolderPath = $this->container->getParameter('kernel.root_dir') . '/../web' . $relativeFolderPath;

            // Remove old picture if exist
            $oldPictureToDelete = $this->container->getParameter('kernel.root_dir') . '/../web' . $trainingSession->getPictureUrl();
            if (file_exists($oldPictureToDelete) && is_file($oldPictureToDelete))
                unlink($oldPictureToDelete);

            $pictureName = $trainingSession->getPictureFile()->getClientOriginalName();

            // Move file in userfiles folder + save new URL
            $trainingSession->getPictureFile()->move($absoluteFolderPath, $pictureName);
            $trainingSession->setPictureUrl($relativeFolderPath . '/' . $pictureName);
        }
    }
}
