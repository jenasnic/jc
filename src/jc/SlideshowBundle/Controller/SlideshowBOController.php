<?php

namespace jc\SlideshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormError;
use jc\SectionBundle\Entity\Section;
use jc\SlideshowBundle\Entity\Picture;
use jc\SlideshowBundle\Entity\Slideshow;
use jc\SlideshowBundle\Form\SlideshowType;

class SlideshowBOController extends Controller {

    public function listSlideshowAction() {

        $slideshowList = $this->getDoctrine()->getManager()->getRepository('jcSlideshowBundle:Slideshow')->findBy(array(), array('rank' => 'asc'));
        return $this->render('jcSlideshowBundle:BO:listSlideshow.html.twig', array('slideshowList' => $slideshowList));
    }

    public function editSlideshowAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $slideshow = ($id > 0) ? $entityManager->getRepository('jcSlideshowBundle:Slideshow')->find($id) : new Slideshow();

        // If user has submit form => save slideshow
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new SlideshowType(), $slideshow);
                $form->bind($request);

                // If no picture already loaded nor uploaded picture => add error
                if ($slideshow->getPictureUrl() == null && $slideshow->getPictureFile() == null)
                    $form->get('pictureFile')->addError(new FormError("Aucune image n'a encore été chargée : vous devez charger une image"));

                if ($form->isValid()) {

                    // Process upload
                    $this->processUpload($slideshow);

                    // For new slideshow => set rank
                    if ($slideshow->getId() == null || $slideshow->getId() == 0)
                        $slideshow->setRank($entityManager->getRepository('jcSlideshowBundle:Slideshow')->getMaxRank() + 1);
                    // For existing slideshow => get picture order and update rank if necessary
                    else {

                        // Get field with new picture order
                        $newOrderedList = $request->request->get('ordered-picture-list');

                        if ($newOrderedList != null) {
                            $newOrderedList = explode('&', str_replace('picture-list[]=', '', $newOrderedList));

                            // Browse each picture and update rank if necessary
                            for($i = 0; $i < count($newOrderedList); $i ++) {

                                $pictureToUpdate = $entityManager->getRepository('jcSlideshowBundle:Picture')->find($newOrderedList[$i]);

                                if ($pictureToUpdate->getRank() != ($i + 1)) {
                                    $pictureToUpdate->setRank($i + 1);
                                    $entityManager->persist($pictureToUpdate);
                                }
                            }

                            $request->getSession()->getFlashBag()->add('bo-log-message', 'Classement des images OK');
                        }
                    }

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
}
