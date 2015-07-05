<?php

namespace jc\DoodleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\DoodleBundle\Entity\DoodleReply;
use jc\DoodleBundle\Form\DoodleReplyType;

class DoodleFOController extends Controller {

    public function listAction() {

        $loggedUser = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

        $doodleReplyList = $entityManager->getRepository('jcDoodleBundle:DoodleReply')->getReplyForUser($loggedUser);
        $unreplyDoodleList = $entityManager->getRepository('jcDoodleBundle:Doodle')->getUnreplyDoodleForUser($loggedUser);

        return $this->render('jcDoodleBundle:FO:doodleList.html.twig', array(
                'doodleReplyList' => $doodleReplyList,
                'unreplyDoodleList' => $unreplyDoodleList
        ));
    }

    public function replyAction($id) {

        $loggedUser = $this->getUser();

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $doodle = $entityManager->getRepository('jcDoodleBundle:Doodle')->find($id);

        // If doodle doesn't exist => stop here
        if ($doodle == null) {
            $request->getSession()->getFlashBag()->add('bo-warning-message', 'Le Doodle auquel vous essayez de répondre n\'existe plus');
            return $this->redirect($this->generateUrl('jc_doodle_fo_index'));
        }

        $doodleReply = null;

        // If user has submit form => save user
        if ($request->getMethod() == 'POST') {

            try {

                $doodleReply = new DoodleReply();
                $form = $this->createForm(new DoodleReplyType(), $doodleReply);
                $form->bind($request);

                if ($form->isValid()) {

                    $doodleReply->setDoodle($doodle);
                    $doodleReply->setUser($loggedUser);

                    $entityManager->persist($doodleReply);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Réponse au Doodle envoyée');

                    return $this->redirect($this->generateUrl('jc_doodle_fo_index'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de l\'envoi de la réponse au Doodle');
            }
        }
        else {

            $doodleReply = $entityManager->getRepository('jcDoodleBundle:DoodleReply')->getReplyForUserAndDoodleId($loggedUser, $id);

            if ($doodleReply == null)
                $doodleReply = new DoodleReply();

            $hasAlreadyReply = false;
            foreach ($doodle->getReplyList() as $replyToCheck) {

                if ($replyToCheck->getUser() == $loggedUser) {
                    $hasAlreadyReply = true;
                    break;
                }
            }

            $form = $this->createForm(new DoodleReplyType(), $doodleReply);
        }

        return $this->render('jcDoodleBundle:FO:doodleReply.html.twig', array(
                'doodle' => $doodle,
                'doodleReply' => $form->createView(),
                'hasReply' => $hasAlreadyReply
        ));
    }
}
