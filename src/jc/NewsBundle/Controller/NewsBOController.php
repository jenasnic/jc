<?php

namespace jc\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use jc\NewsBundle\Entity\News;
use jc\NewsBundle\Form\NewsType;

class NewsBOController extends Controller {

    /**
     * @Route("/admin/news/list", name="jc_news_bo_list")
     */
    public function listNewsAction(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        // If user has submit form => save new news order (if necessary)
        if ($request->getMethod() == 'POST') {

            try {

                // Get field with new menu order
                $newOrderedList = $request->request->get('ordered-news-list');

                if ($newOrderedList != null) {
                    $newOrderedList = explode('&', str_replace('news-list[]=', '', $newOrderedList));

                    // Browse each news and update rank if necessary
                    for($i = 0; $i < count($newOrderedList); $i ++) {

                        $newsToUpdate = $entityManager->getRepository(News::class)->find($newOrderedList[$i]);
                        if ($newsToUpdate->getRank() != ($i + 1)) {

                            $newsToUpdate->setRank($i + 1);
                            $entityManager->persist($newsToUpdate);
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

        $orderedNewsList = $entityManager->getRepository(News::class)->findBy(array(), array('rank' => 'asc'));

        return $this->render('jcNewsBundle:BO:list.html.twig', array('newsList' => $orderedNewsList));
    }

    /**
     * @Route("/admin/news/edit/{id}", defaults={"id" = 0}, name="jc_news_bo_edit")
     */
    public function editNewsAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $news = ($id > 0) ? $entityManager->getRepository(News::class)->find($id) : new News();

        // If user has submit form => save news
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(NewsType::class, $news);
                $form->handleRequest($request);

                // If no picture already loaded nor uploaded picture => add error
                if ($news->getPictureUrl() == null && $news->getPictureFile() == null)
                    $form->get('pictureFile')->addError(new FormError("Aucune image n'a encore été chargée : vous devez charger une image"));

                if ($form->isValid()) {

                    // Process upload
                    $this->processUpload($news);

                    // For new news => set rank
                    if ($news->getId() == null || $news->getId() == 0)
                        $news->setRank($entityManager->getRepository(News::class)->getMaxRank() + 1);

                    $entityManager->persist($news);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde OK');

                    return $this->redirect($this->generateUrl('jc_news_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde');
            }
        }
        else
            $form = $this->createForm(NewsType::class, $news);

        return $this->render('jcNewsBundle:BO:edit.html.twig', array('newsToEdit' => $form->createView()));
    }

    /**
     * @Route("/admin/news/delete/{id}", requirements={"id" = "\d+"}, name="jc_news_bo_delete")
     */
    public function deleteNewsAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $newsToDelete = $entityManager->getRepository(News::class)->find($id);

                // If news found => delete it
                if ($newsToDelete != null) {

                    $fileToDelete = $this->getParameter('kernel.root_dir') . '/../web' . $newsToDelete->getPictureUrl();

                    $entityManager->remove($newsToDelete);
                    $entityManager->flush();

                    // Delete banner picture file if exist
                    if (file_exists($fileToDelete) && is_file($fileToDelete))
                        unlink($fileToDelete);

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
                }
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to news list
        return $this->redirect($this->generateUrl('jc_news_bo_list'));
    }

    /**
     * Allows to upload file defined in News object.
     * @param News $news
     */
    private function processUpload($news) {

        // If picture is defined => process upload
        if (null !== $news->getPictureFile()) {

            $relativeFolderPath = $this->getParameter('jc_news.root_path');
            $absoluteFolderPath = $this->getParameter('kernel.root_dir') . '/../web' . $relativeFolderPath;

            // Remove old picture if exist
            $oldPictureToDelete = $this->getParameter('kernel.root_dir') . '/../web' . $news->getPictureUrl();
            if (file_exists($oldPictureToDelete) && is_file($oldPictureToDelete))
                unlink($oldPictureToDelete);

            // For picture's file => use unique name
            $originalName = $news->getPictureFile()->getClientOriginalName();
            $dotIndex = strrpos($originalName, '.');
            $extension = substr($originalName, $dotIndex + 1);
            $uniqueFileName = $this->getUniqueFileNameForPicture($absoluteFolderPath, $extension);

            // Move file in userfiles folder + save new URL
            $news->getPictureFile()->move($absoluteFolderPath, $uniqueFileName);
            $news->setPictureUrl($relativeFolderPath . '/' . $uniqueFileName);
        }
    }

    private function getUniqueFileNameForPicture($newsPath, $extension) {

        $i = 1;
        do {
            $fileName = 'news_' . sprintf("%'.03d", $i++) . '.' . $extension;
        }
        while (file_exists($newsPath . '/' . $fileName));

        return $fileName;
    }
}
