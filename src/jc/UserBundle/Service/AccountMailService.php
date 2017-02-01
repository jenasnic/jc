<?php

namespace jc\UserBundle\Service;

use Doctrine\ORM\EntityManager;
use jc\ToolBundle\Util\PasswordUtil;
use Symfony\Component\Templating\EngineInterface;
use jc\UserBundle\Entity\User;

class AccountMailService {

    private $entityManager;
    private $mailer;
    private $templating;

    private $prefixMail;
    private $fromMail;
    private $fromName;

    public function __construct($prefixMail, $fromMail, $fromName) {

        $this->prefixMail = $prefixMail;
        $this->fromMail = $fromMail;
        $this->fromName = $fromName;
    }

    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function setMailer(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function setTemplating(EngineInterface $templating) {
        $this->templating = $templating;
    }

    /**
     * Allows to create new password for user and to send his login information by mail.
     * @param integer $userId Identifier of user we want to update password and send mail.
     * @param boolean $newUser TRUE in cas of new user (send login data), FALSE in case of existing user (forgotten password).
     * @return boolean TRUE in case of success, FALSE either.
     */
    public function sendNewAccountInformation($userId, $newUser) {

        $user = $this->entityManager->getRepository(User::class)->find($userId);

        if ($user) {

            try {

                $newPassword = PasswordUtil::generatePassword(6, true, true, true, false);
                $user->setPassword(PasswordUtil::encodePassword($newPassword));

                // Save User object in database
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $messageContent = $this->templating->render('jcUserBundle:mail:password.html.twig', array(
                        'login' => $user->getUsername(),
                        'newPassword' => $newPassword
                ));

                $subject = $newUser ? 'Identifiants de connexion' : 'Mot de passe oublié';
                if (strlen($this->prefixMail) > 0)
                     $subject = '[' . $this->prefixMail . '] - ' . $subject;

                // Create mail and send it
                $mailMessage = \Swift_Message::newInstance()->setSubject($subject)->setFrom($this->fromMail, $this->fromName)->setTo($user->getMail())->setContentType('text/html')->setBody($messageContent);

                $this->mailer->send($mailMessage);

                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }
        else
            return false;
    }
}
