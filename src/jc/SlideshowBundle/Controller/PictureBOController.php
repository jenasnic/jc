<?php

namespace jc\SlideshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use jc\SlideshowBundle\Entity\Picture;
use jc\SlideshowBundle\Entity\Slideshow;
use jc\SlideshowBundle\Form\PictureType;

class PictureBOController extends Controller {

    public function editPictureAction($slideshowId, $pictureId) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $picture = ($pictureId > 0) ? $entityManager->getRepository('jcSlideshowBundle:Picture')->find($pictureId) : new Picture();
        $slideshow = ($pictureId > 0) ? $picture->getSlideshow() : $entityManager->getRepository('jcSlideshowBundle:Slideshow')->find($slideshowId);

        // If user has submit form => save picture
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new PictureType(), $picture);
                $form->bind($request);

                // If no picture already loaded nor uploaded picture => add error
                if ($picture->getPictureUrl() == null && $picture->getPictureFile() == null)
                    $form->get('pictureFile')->addError(new FormError("Aucune image n'a encore été chargée : vous devez charger une image"));

                if ($form->isValid()) {

                    // For new picture => set slideshow + rank
                    if ($picture->getId() == null || $picture->getId() == 0) {

                        $picture->setSlideshow($slideshow);
                        $picture->setRank($entityManager->getRepository('jcSlideshowBundle:Picture')->getMaxRankForSlideshow($slideshow) + 1);
                    }

                    // Process upload for picture
                    $this->processUpload($picture);

                    $entityManager->persist($picture);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde de l\'image OK');

                    return $this->redirect($this->generateUrl('jc_slideshow_bo_edit', array('id' => $slideshowId)));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde de l\'image');
            }
        }
        else
            $form = $this->createForm(new PictureType(), $picture);

        return $this->render('jcSlideshowBundle:BO:editPicture.html.twig', array(
                'pictureToEdit' => $form->createView(),
                'slideshow' => $slideshow
        ));
    }

    public function deletePictureAction($slideshowId, $pictureId) {

        if ($pictureId > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $pictureToDelete = $entityManager->getRepository('jcSlideshowBundle:Picture')->find($pictureId);

                // If picture found => delete it
                if ($pictureToDelete != null) {

                    $pictureFileToDelete = $this->container->getParameter('kernel.root_dir') . '/../web' . $pictureToDelete->getPictureUrl();

                    $entityManager->remove($pictureToDelete);
                    $entityManager->flush();

                    // Delete main picture file if exist
                    if (file_exists($pictureFileToDelete))
                        unlink($pictureFileToDelete);

                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression de l\'image OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression de l\'image');
            }
        }

        // Return to slideshow edition page
        return $this->redirect($this->generateUrl('jc_slideshow_bo_edit', array('id' => $slideshowId)));
    }

    /**
     * Allows to upload files defined in picture object.
     * @param Picture $picture
     */
    private function processUpload($picture) {

        $relativeFolderPath = $this->container->getParameter('jc_slideshow.root_path') . '/slideshow_' . $picture->getSlideshow()->getId();
        $absoluteFolderPath = $this->container->getParameter('kernel.root_dir') . '/../web' . $relativeFolderPath;

        // Create folder if necessary
        if (! is_dir($absoluteFolderPath))
            mkdir($absoluteFolderPath);

        // If main picture is defined => process upload
        if (null !== $picture->getPictureFile()) {

            $pictureName = $picture->getPictureFile()->getClientOriginalName();

            // Move file in userfiles folder + save new URL
            $picture->getPictureFile()->move($absoluteFolderPath, $pictureName);
            $picture->setPictureUrl($relativeFolderPath . '/' . $pictureName);
        }
    }
}
