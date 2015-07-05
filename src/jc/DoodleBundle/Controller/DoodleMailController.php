<?php

namespace jc\DoodleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use jc\DoodleBundle\Entity\Doodle;
use jc\DoodleBundle\Form\DoodleType;

class DoodleMailController extends Controller {

    public function sendAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $doodle = $entityManager->getRepository('jcDoodleBundle:Doodle')->find($id);

        if ($doodle == null) {
            $request->getSession()->getFlashBag()->add('bo-log-message', 'Le doodle spécifié est introuvable');
            return $this->redirect($this->generateUrl('jc_doodle_bo_list'));
        }

        $userList = $this->getDoctrine()->getManager()->getRepository('jcDoodleBundle:Doodle')->getMissingUserForDoodle($doodle);
        $mailList = $this->extractMailList($userList);

        $fromMail = $this->container->getParameter('from_mail');
        $fromName = $this->container->getParameter('from_name');

        $messageContent = $doodle->getSent()
                ? $this->renderView('jcDoodleBundle:mail:reminder.html.twig', array('doodle' => $doodle))
                : $this->renderView('jcDoodleBundle:mail:doodle.html.twig', array('doodle' => $doodle));

        // Create mail and send it
        $mail = \Swift_Message::newInstance()->setSubject($doodle->getTitle())->setFrom($fromMail, $fromName)->setBcc($mailList)->setContentType('text/html')->setBody($messageContent);

        try {

            $this->get('mailer')->send($mail);

            // Update doodle status
            $doodle->setSent(true);
            $entityManager->persist($doodle);
            $entityManager->flush();
        }
        catch (Exception $e) {
            $request->getSession()->getFlashBag()->add('bo-log-message', 'Erreur lors de l\'envoi du mail');
        }

        return $this->redirect($this->generateUrl('jc_doodle_bo_list'));
    }

    protected function extractMailList($userList) {

        $mailList = array();

        foreach ($userList as $user) {
            if (strlen($user->getMail()) > 0)
                $mailList[] = $user->getMail();
        }

        return $mailList;
    }
}
