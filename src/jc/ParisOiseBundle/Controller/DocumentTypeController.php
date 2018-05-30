<?php

namespace jc\ParisOiseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\ParisOiseBundle\Entity\DocumentType;
use jc\ParisOiseBundle\Form\DocumentTypeType;

class DocumentTypeController extends Controller {

    /**
     * @Route("/documentType/list", name="jc_document_type_list")
     */
    public function listAction(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        // If user has submit form => save new document type order (if necessary)
        if ($request->getMethod() == 'POST') {

            try {

                // Get field with new slideshow order
                $newOrderedList = $request->request->get('ordered-document-list');

                if ($newOrderedList != null) {
                    $newOrderedList = explode('&', str_replace('document-list[]=', '', $newOrderedList));

                    // Browse each document type and update rank if necessary
                    for($i = 0; $i < count($newOrderedList); $i ++) {

                        $documentTypeToUpdate = $entityManager->getRepository(DocumentType::class)->find($newOrderedList[$i]);
                        if ($documentTypeToUpdate->getRank() != ($i + 1)) {

                            $documentTypeToUpdate->setRank($i + 1);
                            $entityManager->persist($documentTypeToUpdate);
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

        $documentTypeList = $this->getDoctrine()->getManager()->getRepository(DocumentType::class)->findBy(array(), array('rank' => 'asc'));
        return $this->render('jcParisOiseBundle:documentType:list.html.twig', array('documentTypeList' => $documentTypeList));
    }

    /**
     * @Route("/documentType/edit/{id}", defaults={"id" = 0}, name="jc_document_type_edit")
     */
    public function editAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $documentType = ($id > 0) ? $entityManager->getRepository(DocumentType::class)->find($id) : new DocumentType();

        // If user has submit form => save documentType
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(DocumentTypeType::class, $documentType);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    // For new document type => set rank
                    if ($documentType->getId() == null || $documentType->getId() == 0)
                        $documentType->setRank($entityManager->getRepository(DocumentType::class)->getMaxRank() + 1);

                    $entityManager->persist($documentType);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde OK');

                    return $this->redirect($this->generateUrl('jc_document_type_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde');
            }
        }
        else
            $form = $this->createForm(DocumentTypeType::class, $documentType);

            return $this->render('jcParisOiseBundle:documentType:edit.html.twig', array('documentTypeToEdit' => $form->createView()));
    }

    /**
     * @Route("/documentType/delete/{id}", requirements={"id" = "\d+"}, name="jc_document_type_delete")
     */
    public function deleteAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $documentTypeToDelete = $entityManager->getRepository(DocumentType::class)->find($id);

                // If documentType found => delete it
                if ($documentTypeToDelete != null) {

                    $entityManager->remove($documentTypeToDelete);
                    $entityManager->flush();
                }

                $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to documentType list
        return $this->redirect($this->generateUrl('jc_document_type_list'));
    }
}
