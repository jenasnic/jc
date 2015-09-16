<?php

namespace jc\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\ContactBundle\Model\ContactForm;
use jc\ContactBundle\Model\ContactFormType;

class ContactController extends Controller {

    public function contactAction() {

        $contactForm = $this->createForm(new ContactFormType(), new ContactForm());
        $request = $this->getRequest();

        // If user has submit form => send mail
        if ($request->getMethod() == 'POST') {
            $contactForm->bind($request);

            if ($contactForm->isValid()) {
                $sendRequestOK = $this->sendRequestMail($contactForm->getViewData());

                if ($sendRequestOK) {
                    $this->sendConfirmMail($contactForm->getViewData());
                    return $this->render('jcContactBundle::contactConfirm.html.twig');
                }
                else
                    return $this->render('jcContactBundle::contactError.html.twig');
            }
            else
                var_dump($contactForm);
        }

        return $this->render('jcContactBundle::contactRequest.html.twig', array(
                'contactForm' => $contactForm->createView()
        ));
    }

    private function sendRequestMail($contactForm) {

        try {

            $mail = $contactForm->getMail();
            $message = $contactForm->getMessage();
            $body = "Demande de contact [$mail]\r\n\r\n" . $message;

            $fromMail = $this->container->getParameter('website_mail');
            $webmasterMail = $this->container->getParameter('webmaster_mail');

            // Create mail and send it
            $mailMessage = \Swift_Message::newInstance()->setSubject("[Thé'OTrail] Demande de contact")->setFrom($fromMail, "Thé'OTrail")->setTo($webmasterMail)->setContentType('text/plain')->setBody($body);

            $this->get('mailer')->send($mailMessage);

            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    private function sendConfirmMail($contactForm) {

        try {

            $mail = $contactForm->getMail();
            $body = $this->get('templating')->render('jcContactBundle:mail:contact.html.twig');
            $fromMail = $this->container->getParameter('website_mail');

            // Create mail and send it
            $mailMessage = \Swift_Message::newInstance()->setSubject("[Thé'OTrail] Contact")->setFrom($fromMail, "Thé'OTrail")->setTo($mail)->setContentType('text/html')->setBody($body);

            $this->get('mailer')->send($mailMessage);

            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
}
