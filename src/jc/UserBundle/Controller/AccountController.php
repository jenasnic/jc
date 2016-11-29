<?php

namespace jc\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\UserBundle\Model\AccountInfo;
use jc\UserBundle\Form\AccountInfoType;
use jc\ToolBundle\Util\ValidateUtil;
use jc\ToolBundle\Util\PasswordUtil;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller {

    /**
     * @Route("/user/account", name="jc_user_account")
     */
    public function accountAction(Request $request) {

        $loggedUser = $this->getUser();

        $accountInfo = new AccountInfo();

        // If user has submit form => save user acount info
        if ($request->getMethod() == 'POST') {

            try {

                $entityManager = $this->getDoctrine()->getManager();

                $form = $this->createForm(new AccountInfoType(), $accountInfo);
                $form->handleRequest($request);

                // If password changed => check password security + password confirmation
                if (strlen($accountInfo->getPassword()) > 0) {

                    if (!ValidateUtil::checkPassword($accountInfo->getPassword(), 1))
                        $form->get('password')->addError(new FormError("Le mot de passe n'est pas assez fort"));
                    else if (strcmp($accountInfo->getPassword(), $accountInfo->getConfirmPassword()) != 0)
                        $form->get('confirmPassword')->addError(new FormError("La confirmation du mot de passe n'est pas correcte"));
                }

                // Check mail unicity
                if (!$entityManager->getRepository('jcUserBundle:User')->checkMailForUser($accountInfo->getMail(), $loggedUser->getId()))
                    $form->get('mail')->addError(new FormError("Ce mail est déjà utilisé"));

                if ($form->isValid()) {

                    // Get User object from database => for update
                    $user = $entityManager->getRepository('jcUserBundle:User')->find($loggedUser->getId());

                    // Populate form data in User object
                    $user->setFirstname($accountInfo->getFirstname());
                    $user->setLastname($accountInfo->getLastname());
                    $user->setMail($accountInfo->getMail());

                    // Encode password using SHA
                    if (strlen($accountInfo->getPassword()) > 0)
                        $user->setPassword(PasswordUtil::encodePassword($accountInfo->getPassword()));

                    // Save User object in database
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('popup-message', 'Votre compte a bien été mis à jour');
                }
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('popup-message', 'Erreur lors de la mise à jour de vos informations personnelles');
            }
        }
        else {

            // Initialize AccountInfo with logged user data
            // NOTE : Ignore password (unchanged if ignored)
            $accountInfo->setFirstname($loggedUser->getFirstname());
            $accountInfo->setLastname($loggedUser->getLastname());
            $accountInfo->setMail($loggedUser->getMail());

            $form = $this->createForm(new AccountInfoType(), $accountInfo);
        }

        return $this->render('jcUserBundle:FO:account.html.twig', array(
                'accountInfo' => $form->createView()
        ));
    }

    /**
     * @Route("/password", name="jc_user_password")
     */
    public function passwordAction(Request $request) {

        // If user has submit form => send new password by mail...
        if ($request->getMethod() == 'POST') {

            $mailAddress = $request->request->get('mail');

            if (!ValidateUtil::checkMail($mailAddress)) {
                $request->getSession()->getFlashBag()->add('popup-message', 'Le mail indiqué n\'est pas valide');
                return $this->render('jcUserBundle:FO:password.html.twig');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $userList = $entityManager->getRepository('jcUserBundle:User')->findBy(array(
                    'mail' => $mailAddress
            ));

            if (count($userList) == 0) {

                $request->getSession()->getFlashBag()->add('popup-message', 'Le mail indiqué est introuvable');
                return $this->render('jcUserBundle:FO:password.html.twig');
            }

            // Update password for user found + send mail
            $user = $userList[0];

            $accountMailService = $this->get('jc_user.account_mail');
            if ($accountMailService->sendNewAccountInformation($user->getId(), false))
                $request->getSession()->getFlashBag()->add('popup-message', 'Un mail contenant votre nouveau mot de passe vous a été envoyé');
            else
                $request->getSession()->getFlashBag()->add('popup-message', 'Erreur lors de l\'envoi du mail');
        }

        return $this->render('jcUserBundle:FO:password.html.twig');
    }
}
