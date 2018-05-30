<?php

namespace jc\ParisOiseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\ParisOiseBundle\Entity\ContactType;
use jc\ParisOiseBundle\Form\ContactTypeType;

class ContactTypeController extends Controller {

    /**
     * @Route("/contactType/list", name="jc_contact_type_list")
     */
    public function listAction(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        // If user has submit form => save new contact type order (if necessary)
        if ($request->getMethod() == 'POST') {

            try {

                // Get field with new slideshow order
                $newOrderedList = $request->request->get('ordered-contact-list');

                if ($newOrderedList != null) {
                    $newOrderedList = explode('&', str_replace('contact-list[]=', '', $newOrderedList));

                    // Browse each contact type and update rank if necessary
                    for($i = 0; $i < count($newOrderedList); $i ++) {

                        $contactTypeToUpdate = $entityManager->getRepository(ContactType::class)->find($newOrderedList[$i]);
                        if ($contactTypeToUpdate->getRank() != ($i + 1)) {

                            $contactTypeToUpdate->setRank($i + 1);
                            $entityManager->persist($contactTypeToUpdate);
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

        $contactTypeList = $this->getDoctrine()->getManager()->getRepository(ContactType::class)->findBy(array(), array('rank' => 'asc'));
        return $this->render('jcParisOiseBundle:contactType:list.html.twig', array('contactTypeList' => $contactTypeList));
    }

    /**
     * @Route("/contactType/edit/{id}", defaults={"id" = 0}, name="jc_contact_type_edit")
     */
    public function editAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $contactType = ($id > 0) ? $entityManager->getRepository(ContactType::class)->find($id) : new ContactType();

        // If user has submit form => save contactType
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(ContactTypeType::class, $contactType);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    // For new contact type => set rank
                    if ($contactType->getId() == null || $contactType->getId() == 0)
                        $contactType->setRank($entityManager->getRepository(ContactType::class)->getMaxRank() + 1);

                    $entityManager->persist($contactType);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde OK');

                    return $this->redirect($this->generateUrl('jc_contact_type_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde');
            }
        }
        else
            $form = $this->createForm(ContactTypeType::class, $contactType);

            return $this->render('jcParisOiseBundle:contactType:edit.html.twig', array('contactTypeToEdit' => $form->createView()));
    }

    /**
     * @Route("/contactType/delete/{id}", requirements={"id" = "\d+"}, name="jc_contact_type_delete")
     */
    public function deleteAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $contactTypeToDelete = $entityManager->getRepository(ContactType::class)->find($id);

                // If contactType found => delete it
                if ($contactTypeToDelete != null) {

                    $entityManager->remove($contactTypeToDelete);
                    $entityManager->flush();
                }

                $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to contactType list
        return $this->redirect($this->generateUrl('jc_contact_type_list'));
    }
}
