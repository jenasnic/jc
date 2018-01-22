<?php

namespace jc\EnglishQuizzBundle\Controller\Common;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

abstract class CommonEnglishItemController extends Controller {

    /**
     * Common method to use to search items...
     * @param Request $request
     * @param object $entityClass Class of entity to delete.
     * @param string $viewName Name of view to use to add/edit item (for specified entity).
     * @param string $modelName Name of model used in specified view (see previous parameter).
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchItemAction(Request $request, $entityClass, $viewName, $modelName) {

        // Get page to display (display page 1 per default)
        $property = $request->get('property');
        $value = $request->get('value');

        $entityManager = $this->getDoctrine()->getManager();

        try {

            $itemList = $entityManager->getRepository($entityClass)->searchItem($property, $value);

            return $this->render($viewName, array($modelName => $itemList));
        }
        catch (\Exception $e) {
            return $this->render($viewName, array($modelName => array()));
        }
    }

    /**
     * Common method to use to display list of items...
     * @param Request $request
     * @param string $entityName Name of entity to list (for entity manager).
     * @param string $sortPropertyName Name of entity's property to use to sort entities on list.
     * @param string $viewName Name of view to use to display list items (for specified entity).
     * @param string $modelName Name of model used in specified view (see previous parameter).
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listItemAction(Request $request, $entityName, $sortPropertyName, $viewName, $modelName) {

        // Get page to display (display page 1 per default)
        $page = intval($request->get('page'));
        if ($page == 0)
            $page = 1;

        $paginationService = $this->get('jc_tool.pagination');
        $entityPage = $paginationService->getPaginationInformation($page, $entityName, $sortPropertyName, 'asc', null, 50);

        return $this->render($viewName, array($modelName => $entityPage));
    }

    /**
     * Common method to save/edit item...
     * @param Request $request
     * @param integer $id Identifier of entity to edit (0 for new entity).
     * @param string $className Full class name (with namespace) of entity to edit.
     * @param string $entityClassType Class of form type matching entity to edit.
     * @param string $viewName Name of view to use to add/edit item (for specified entity).
     * @param string $modelName Name of model used in specified view (see previous parameter).
     * @param string $redirectUrl URL identifier for redirect when validating action (add or edit).
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editItemAction(Request $request, $id, $className, $entityClassType, $viewName, $modelName, $redirectUrl) {

        $entityManager = $this->getDoctrine()->getManager();

        $item = ($id > 0) ? $entityManager->getRepository($className)->find($id) : new $className();

        // If user has submit form => save item
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm($entityClassType, $item);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    $entityManager->persist($item);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde OK');

                    return $this->redirect($this->generateUrl($redirectUrl));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (\Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde');
            }
        }
        else
            $form = $this->createForm($entityClassType, $item);

            return $this->render($viewName, array($modelName => $form->createView()));
    }

    /**
     * Common method to delete item...
     * @param Request $request
     * @param integer $id
     * @param object $entityClass Class of entity to delete.
     * @param string $redirectUrl URL identifier for redirect when validating action (delete).
     * @return object Redirect view.
     */
    public function deleteItemAction(Request $request, $id, $entityClass, $redirectUrl) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $itemToDelete = $entityManager->getRepository($entityClass)->find($id);

                // If item found => delete it
                if ($itemToDelete != null) {

                    $entityManager->remove($itemToDelete);
                    $entityManager->flush();
                }

                $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
            }
            catch (\Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to word list
        return $this->redirect($this->generateUrl($redirectUrl));
    }

    /**
     * Common method to import item...
     * @param Request $request
     * @param string $redirectUrl URL identifier for redirect when validating action (add or edit).
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function importItemAction(Request $request, $redirectUrl) {

        try {

            // Process file upload
            $file = $request->files->get('file');

            if ($file) {

                $addedItemCount = 0;
                $updatedItemCount = 0;

                // Move uploaded file
                $rootPath = $this->getParameter('jc_english_quizz.temp_path');
                $fullPath = $this->getParameter('kernel.root_dir') . '/../web' . $rootPath;
                $file->move($fullPath, $file->getClientOriginalName());

                // Process file to import data
                $fileFullName = $fullPath . '/' . $file->getClientOriginalName();
                $fileToProcess = fopen($fileFullName, 'r');

                if ($fileToProcess) {

                    $entityManager = $this->getDoctrine()->getManager();

                    while (($line = fgetcsv($fileToProcess, 310, ";")) !== FALSE) {

                        $item = $this->processItemFromCSVLine($line);

                        if ($item) {

                            ($item->getId() > 0) ? $updatedItemCount++ : $addedItemCount++;
                            $entityManager->persist($item);
                            $entityManager->flush();
                        }
                    }

                    fclose($fileToProcess);
                }

                // Remove file
                unlink($fileFullName);

                $message = 'Fichier chargé : ' . $addedItemCount . ' élément(s) ajouté(s) / ' . $updatedItemCount . ' élément(s) mis à jour';
                $request->getSession()->getFlashBag()->add('bo-log-message', $message);
            }
            else {
                $request->getSession()->getFlashBag()->add('bo-warning-message', 'Vous devez d\'abord sélectionnez un fichier');
            }
        }
        catch (\Exception $e) {
            $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors du chargement du fichier, vérifier le format');
        }

        // Return to main list
        return $this->redirect($this->generateUrl($redirectUrl));
    }

    /**
     * Method to process item matching specified CSV line.
     * @param array $line CSV line containing data for item to create/update...
     * @return object Item to create or to update matching specified CSV line, null if no item to process (already exist).
     */
    abstract protected function processItemFromCSVLine($line);
}
