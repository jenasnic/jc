<?php

namespace jc\ParisOiseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\ParisOiseBundle\Entity\Construction;
use jc\ParisOiseBundle\Form\ConstructionType;
use jc\ParisOiseBundle\Entity\ContactType;
use jc\ParisOiseBundle\Entity\Contact;
use jc\ParisOiseBundle\Entity\DocumentType;
use jc\ParisOiseBundle\Entity\Document;

class ConstructionController extends Controller
{
    /**
     * @Route("/construction/list", name="jc_construction_list")
     */
    public function listAction() {

        $constructionList = $this->getDoctrine()->getManager()->getRepository(Construction::class)->findBy(array(), array('id' => 'desc'));
        return $this->render('jcParisOiseBundle:construction:list.html.twig', array('constructionList' => $constructionList));
    }

    /**
     * @Route("/construction/edit/{id}", defaults={"id" = 0}, name="jc_construction_edit")
     */
    public function editAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $construction = null;
        if ($id > 0)
            $construction = $entityManager->getRepository(Construction::class)->find($id);
        // For new construction => initialize construction with contact...
        else {

            $construction = new Construction();

            // Get all contact type and add each contact to construction
            $contactTypeList = $entityManager->getRepository(ContactType::class)->findBy(array(), array('rank' => 'asc'));

            foreach ($contactTypeList as $contactType) {

                $newContact = new Contact();
                $newContact->setType($contactType);
                $construction->addContact($newContact);
            }
        }

        // If user has submit form => save construction
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(ConstructionType::class, $construction);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    $entityManager->persist($construction);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde OK');

                    // For new construction => create all documents
                    if ($construction->getId() == null || $construction->getId() == 0) {

                        $documentTypeList = $entityManager->getRepository(DocumentType::class)->findBy(array(), array('rank' => 'asc'));
                        foreach ($documentTypeList as $documentType) {

                            $newDocument = new Document();
                            $newDocument->setConstruction($construction);
                            $newDocument->setType($documentType);
                            $newDocument->setStatus(Document::STATUS_START);

                            $entityManager->persist($newDocument);
                        }

                        $entityManager->flush();
                    }

                    return $this->redirect($this->generateUrl('jc_construction_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde');
            }
        }
        else
            $form = $this->createForm(ConstructionType::class, $construction);

            return $this->render('jcParisOiseBundle:construction:edit.html.twig', array('constructionToEdit' => $form->createView()));
    }

    /**
     * @Route("/construction/delete/{id}", requirements={"id" = "\d+"}, name="jc_construction_delete")
     */
    public function deleteAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $constructionToDelete = $entityManager->getRepository(Construction::class)->find($id);

                // If construction found => delete it
                if ($constructionToDelete != null) {

                    $entityManager->remove($constructionToDelete);
                    $entityManager->flush();
                }

                $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to construction list
        return $this->redirect($this->generateUrl('jc_construction_list'));
    }
}
