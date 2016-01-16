<?php

namespace jc\SlideshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormError;
use jc\SlideshowBundle\Entity\Slideshow;
use jc\SlideshowBundle\Form\SlideshowType;
use Symfony\Component\HttpFoundation\JsonResponse;

class SlideshowBOController extends Controller {

    public function listSlideshowAction() {

        $slideshowList = $this->getDoctrine()->getManager()->getRepository('jcSlideshowBundle:Slideshow')->findBy(array(), array('rank' => 'asc'));
        return $this->render('jcSlideshowBundle:BO:listSlideshow.html.twig', array('slideshowList' => $slideshowList));
    }

    public function createSlideshowAction() {

        try {

            $name = $this->getRequest()->request->get('name');

            // Create new slideshow with specified name
            $entityManager = $this->getDoctrine()->getManager();
            $slideshowToCreate = new Slideshow();
            $slideshowToCreate->setName($name);
            $slideshowToCreate->setDate(new \DateTime());
            $slideshowToCreate->setRank($entityManager->getRepository('jcSlideshowBundle:Slideshow')->getMaxRank() + 1);

            $entityManager->persist($slideshowToCreate);
            $entityManager->flush();

            // Get id for new slideshow and build URL to edit it
            $id = $slideshowToCreate->getId();
            $redirectUrl = $this->generateUrl('jc_slideshow_bo_edit', array('id' => $id));

            return new JsonResponse(array('success' => true, 'redirectUrl' => $redirectUrl, 'id' => $id));
        }
        catch (Exception $e) {
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de la création du diaporama'));
        }
    }

    public function editSlideshowAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $slideshow = $entityManager->getRepository('jcSlideshowBundle:Slideshow')->find($id);

        // If user has submit form => save slideshow
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new SlideshowType(), $slideshow);
                $form->bind($request);

                // If no picture already loaded nor uploaded picture => add error
                /*if ($slideshow->getPictureUrl() == null && $slideshow->getPictureFile() == null)
                    $form->get('pictureFile')->addError(new FormError("Aucune image n'a encore été chargée : vous devez charger une image"));*/

                if ($form->isValid()) {

                    // Process upload
                    $this->processUpload($slideshow);

                    // Process pictures
                    $this->processPictures($slideshow);

                    $entityManager->persist($slideshow);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde de la course OK');

                    return $this->redirect($this->generateUrl('jc_slideshow_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde de la course');
            }
        }
        else
            $form = $this->createForm(new SlideshowType(), $slideshow);

        return $this->render('jcSlideshowBundle:BO:editSlideshow.html.twig', array('slideshowToEdit' => $form->createView()));
    }

    public function deleteSlideshowAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $slideshowToDelete = $entityManager->getRepository('jcSlideshowBundle:Slideshow')->find($id);

                // If slideshow found => delete it
                if ($slideshowToDelete != null) {

                    $relativeFolderPath = $this->container->getParameter('jc_slideshow.root_path') . '/slideshow_' . $id;
                    $folderToDelete = $this->container->getParameter('kernel.root_dir') . '/../web' . $relativeFolderPath;
                    $fileToDelete = $this->container->getParameter('kernel.root_dir') . '/../web' . $slideshowToDelete->getPictureUrl();

                    // NOTE : All pictures linked to slideshow will be removed
                    $entityManager->remove($slideshowToDelete);
                    $entityManager->flush();

                    // Delete slideshow folder with all pictures
                    if (file_exists($folderToDelete)) {

                        $fileSystem = new Filesystem();
                        $fileSystem->remove($folderToDelete);
                    }

                    // Delete slideshow picture file if exist
                    if (file_exists($fileToDelete) && is_file($fileToDelete))
                        unlink($fileToDelete);

                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression de la course OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression de la course');
            }
        }

        // Return to slideshow list
        return $this->redirect($this->generateUrl('jc_slideshow_bo_list'));
    }

    /**
     * Allows to upload file defined in Slideshow object.
     * @param Partner $partner
     */
    private function processUpload($slideshow) {

        // If picture is defined => process upload
        if (null !== $slideshow->getPictureFile()) {

            $relativeFolderPath = $this->container->getParameter('jc_slideshow.root_path');
            $absoluteFolderPath = $this->container->getParameter('kernel.root_dir') . '/../web' . $relativeFolderPath;

            // Remove old picture if exist
            $oldPictureToDelete = $this->container->getParameter('kernel.root_dir') . '/../web' . $slideshow->getPictureUrl();
            if (file_exists($oldPictureToDelete) && is_file($oldPictureToDelete))
                unlink($oldPictureToDelete);

            $pictureName = $slideshow->getPictureFile()->getClientOriginalName();

            // Move file in userfiles folder + save new URL
            $slideshow->getPictureFile()->move($absoluteFolderPath, $pictureName);
            $slideshow->setPictureUrl($relativeFolderPath . '/' . $pictureName);
        }
    }

    /**
     * Allows to process slideshow's pictures to update name or/and rank.
     * @param Slideshow $slideshow slideshow we want to update pictures name/rank
     */
    private function processPictures($slideshow) {

        $request = $this->getRequest();

        foreach ($slideshow->getPictures() as $pictureToUpdate) {

            $pictureId = $pictureToUpdate->getId();

            $name = $request->request->get('picture-name-' . $pictureId);
            $rank = $request->request->get('picture-rank-' . $pictureId);

            $pictureToUpdate->setName($name);
            $pictureToUpdate->setRank($rank);
        }
    }
}
