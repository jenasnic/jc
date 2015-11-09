<?php

namespace jc\DoodleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\DoodleBundle\Entity\Doodle;
use jc\DoodleBundle\Form\DoodleType;

class DoodleBOController extends Controller {

    public function listAction() {

        $doodleList = $this->getDoctrine()->getManager()->getRepository('jcDoodleBundle:Doodle')->findBy(array(), array('eventDate' => 'asc'));
        return $this->render('jcDoodleBundle:BO:list.html.twig', array('doodleList' => $doodleList));
    }

    public function editAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $doodle = ($id > 0) ? $entityManager->getRepository('jcDoodleBundle:Doodle')->find($id) : new Doodle();

        // If user has submit form => save doodle
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new DoodleType(), $doodle);
                $form->bind($request);

                if ($form->isValid()) {

                    $entityManager->persist($doodle);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du doodle OK');

                    return $this->redirect($this->generateUrl('jc_doodle_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde du doodle');
            }
        }
        else {

            $form = $this->createForm(new DoodleType(), $doodle);
            // TODO : If doodle already contains reply => edition not allowed
        }

        return $this->render('jcDoodleBundle:BO:edit.html.twig', array(
                'doodleToEdit' => $form->createView()
        ));
    }

    public function deleteAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $doodleToDelete = $entityManager->getRepository('jcDoodleBundle:Doodle')->find($id);

                // If doodle found => delete it
                if ($doodleToDelete != null) {

                    $entityManager->remove($doodleToDelete);
                    $entityManager->flush();

                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression du doodle OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression du doodle');
            }
        }

        // Return to doodle list
        return $this->redirect($this->generateUrl('jc_doodle_bo_list'));
    }

    public function replyAction($id) {

        $entityManager = $this->getDoctrine()->getManager();

        $doodle = $entityManager->getRepository('jcDoodleBundle:Doodle')->find($id);
        $userList = $entityManager->getRepository('jcDoodleBundle:Doodle')->getMissingUserForDoodle($doodle);

        return $this->render('jcDoodleBundle:BO:reply.html.twig', array(
                'doodle' => $doodle,
                'userList' => $userList
        ));
    }
}
