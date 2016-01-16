<?php

namespace jc\SlideshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\SlideshowBundle\Entity\Picture;
use jc\SlideshowBundle\Entity\Slideshow;
use Symfony\Component\HttpFoundation\JsonResponse;

class PictureBOController extends Controller {

    public function uploadPictureAction() {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        try {

            // Create new picture
            $picture = new Picture();

            // Set slideshow + rank
            $slideshowId = $request->request->get('slideshowId');
            $slideshow = $entityManager->getRepository('jcSlideshowBundle:Slideshow')->find($slideshowId);
            $picture->setSlideshow($slideshow);
            $picture->setRank($entityManager->getRepository('jcSlideshowBundle:Picture')->getMaxRankForSlideshow($slideshow) + 1);

            // Process file upload
            $file = $request->files->get('file');

            $relativeFolderPath = $this->container->getParameter('jc_slideshow.root_path') . '/slideshow_' . $slideshowId;
            $absoluteFolderPath = $this->container->getParameter('kernel.root_dir') . '/../web' . $relativeFolderPath;

            // Create folder if necessary
            if (!is_dir($absoluteFolderPath))
                mkdir($absoluteFolderPath);

            // Move file into appropriate folder
            $file->move($absoluteFolderPath, $file->getClientOriginalName());

            $picture->setPictureUrl($relativeFolderPath . '/' . $file->getClientOriginalName());

            // For picture's name => use file name without extension
            $name = $file->getClientOriginalName();
            $name = substr($name, 0, strrpos($name, '.'));
            $picture->setName($name);

            // Save new picture
            $entityManager->persist($picture);
            $entityManager->flush();

            return new JsonResponse(array('success' => true, 'id' => $picture->getId(), 'name' => $picture->getName(), 'rank' => $picture->getRank()));
        }
        catch (Exception $e) {
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de la création de l\'image'));
        }
    }

    public function deletePictureAction() {

        $request = $this->getRequest();
        $pictureId = $request->request->get('pictureId');

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

                    return new JsonResponse(array('success' => true));
                }

                return new JsonResponse(array('success' => false, 'message' => 'Image non trouvée'));
            }
            catch (Exception $e) {
                return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de la suppression de l\'image'));
            }
        }
    }
}
