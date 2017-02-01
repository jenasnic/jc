<?php

namespace jc\QuizzBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use jc\QuizzBundle\Entity\Quizz;
use jc\QuizzBundle\Form\QuizzType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class QuizzBOController extends Controller {

    /**
     * @Route("/admin/quizz/list", name="jc_quizz_bo_list")
     */
    public function listQuizzAction(Request $request) {

        $quizzList = $this->getDoctrine()->getManager()->getRepository(Quizz::class)->findBy(array(), array('name' => 'asc'));
        return $this->render('jcQuizzBundle:BO:listQuizz.html.twig', array('quizzList' => $quizzList));
    }

    /**
     * @Route("/admin/quizz/create", name="jc_quizz_bo_create")
     */
    public function createQuizzAction(Request $request) {

        try {

            $name = $request->request->get('name');

            // Create new quizz with specified name
            $entityManager = $this->getDoctrine()->getManager();
            $quizzToCreate = new Quizz();
            $quizzToCreate->setName($name);

            $entityManager->persist($quizzToCreate);
            $entityManager->flush();

            // Get id for new slideshow and build URL to edit it
            $id = $quizzToCreate->getId();
            $redirectUrl = $this->generateUrl('jc_quizz_bo_edit', array('id' => $id));

            return new JsonResponse(array('success' => true, 'redirectUrl' => $redirectUrl, 'id' => $id));
        }
        catch (Exception $e) {
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de la création'));
        }
    }

    /**
     * @Route("/admin/quizz/edit/{id}", requirements={"id" = "\d+"}, name="jc_quizz_bo_edit")
     */
    public function editQuizzAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $quizz = $entityManager->getRepository(Quizz::class)->find($id);

        // If user has submit form => save quizz
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(QuizzType::class, $quizz);
                $form->handleRequest($request);

                // If no picture already loaded nor uploaded picture => add error
                if ($quizz->getPictureUrl() == null && $quizz->getPictureFile() == null)
                    $form->get('pictureFile')->addError(new FormError("Aucune image n'a encore été chargée : vous devez charger une image"));

                if ($form->isValid()) {

                    // Process upload
                    $this->processUpload($quizz);

                    $entityManager->persist($quizz);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde OK');

                    return $this->redirect($this->generateUrl('jc_quizz_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde');
            }
        }
        else
            $form = $this->createForm(QuizzType::class, $quizz);

        return $this->render('jcQuizzBundle:BO:editQuizz.html.twig', array('quizzToEdit' => $form->createView()));
    }

    /**
     * @Route("/admin/quizz/delete/{id}", requirements={"id" = "\d+"}, name="jc_quizz_bo_delete")
     */
    public function deleteQuizzAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $quizzToDelete = $entityManager->getRepository(Quizz::class)->find($id);

                // If quizz found => delete it
                if ($quizzToDelete != null) {

                    $fileToDelete = $this->getParameter('kernel.root_dir') . '/../web' . $quizzToDelete->getPictureUrl();

                    $entityManager->remove($quizzToDelete);
                    $entityManager->flush();

                    // Delete quizz picture file if exist
                    if (file_exists($fileToDelete) && is_file($fileToDelete))
                        unlink($fileToDelete);

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
                }
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to quizz list
        return $this->redirect($this->generateUrl('jc_quizz_bo_list'));
    }

    /**
     * Allows to upload file defined in Quizz object.
     * @param Quizz $quizz quizz we want to upload picture
     */
    private function processUpload($quizz) {

        // If picture is defined => process upload
        if (null !== $quizz->getPictureFile()) {

            $relativeFolderPath = $this->getParameter('jc_quizz.root_path');
            $absoluteFolderPath = $this->getParameter('kernel.root_dir') . '/../web' . $relativeFolderPath;

            // Remove old picture if exist
            $oldPictureToDelete = $this->getParameter('kernel.root_dir') . '/../web' . $quizz->getPictureUrl();
            if (file_exists($oldPictureToDelete) && is_file($oldPictureToDelete))
                unlink($oldPictureToDelete);

            $pictureName = $quizz->getPictureFile()->getClientOriginalName();

            // Move file in userfiles folder + save new URL
            $quizz->getPictureFile()->move($absoluteFolderPath, $pictureName);
            $quizz->setPictureUrl($relativeFolderPath . '/' . $pictureName);
        }
    }
}
