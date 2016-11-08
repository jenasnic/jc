<?php

namespace jc\ContactBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\ContactBundle\Model\ContactForm;
use jc\ContactBundle\Model\ContactFormType;

class ContactController extends Controller {

    /**
     * @Route("/contact", name="jc_contact")
     */
    public function contactAction(Request $request) {

        $contactForm = $this->createForm(new ContactFormType(), new ContactForm());

        // If user has submit form => send mail
        if ($request->getMethod() == 'POST') {

            $contactForm->handleRequest($request);

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

            $contactMail = $this->getParameter('jc_contact.mail');
            $contactName = $this->getParameter('jc_contact.name');
            $contactSubject = $this->getParameter('jc_contact.subject');

            // Create mail and send it
            $mailMessage = \Swift_Message::newInstance()->setSubject("$contactSubject")->setFrom($contactMail, $contactName)->setTo($contactMail)->setContentType('text/plain')->setBody($body);

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

            $contactMail = $this->getParameter('jc_contact.mail');
            $contactName = $this->getParameter('jc_contact.name');
            $contactSubject = $this->getParameter('jc_contact.subject');

            // Create mail and send it
            $mailMessage = \Swift_Message::newInstance()->setSubject($contactSubject)->setFrom($contactMail, $contactName)->setTo($mail)->setContentType('text/html')->setBody($body);

            $this->get('mailer')->send($mailMessage);

            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
}
