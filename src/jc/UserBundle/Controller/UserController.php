<?php

namespace jc\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use jc\UserBundle\Entity\User;
use jc\UserBundle\Form\UserType;
use jc\ToolBundle\Util\PasswordUtil;

class UserController extends Controller {

    public function listAction() {

        $userList = $this->getDoctrine()->getManager()->getRepository('jcUserBundle:User')->findBy(array(), array('username' => 'asc'));
        return $this->render('jcUserBundle:BO:list.html.twig', array('userList' => $userList));
    }

    public function editAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        $user = ($id > 0) ? $entityManager->getRepository('jcUserBundle:User')->find($id) : new User();

        // If user has submit form => save user
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new UserType(), $user);
                $form->bind($request);

                if ($form->isValid()) {

                    $checkUnicity = true;

                    // Check mail + login unicity
                    if (!$entityManager->getRepository('jcUserBundle:User')->checkMailForUser($user->getMail(), $id)) {

                        $form->get('mail')->addError(new FormError("Le mail doit être unique"));
                        $request->getSession()->getFlashBag()->add('bo-warning-message', 'Un autre utilisateur utilise déjà le mail indiqué');
                        $checkUnicity = false;
                    }
                    if (!$entityManager->getRepository('jcUserBundle:User')->checkLoginForUser($user->getUsername(), $id)) {

                        $form->get('username')->addError(new FormError("Le login doit être unique"));
                        $request->getSession()->getFlashBag()->add('bo-warning-message', 'Un autre utilisateur utilise déjà le login indiqué');
                        $checkUnicity = false;
                    }

                    // Save user only if data are unique (mail + login)
                    if ($checkUnicity) {

                        // For new user => generate new password
                        if (! $user->getId())
                            $user->setPassword(PasswordUtil::encodePassword(PasswordUtil::generatePassword(6, true, true, true, false)));

                        $entityManager->persist($user);
                        $entityManager->flush();
                        $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde de l\'utilisateur OK');

                        // If account must be sent to user => update password + send mail
                        if ($request->request->get('send-account')) {

                            $accountMailService = $this->get('jc_user.account_mail');
                            if ($accountMailService->sendNewAccountInformation($user->getId(), true))
                                $request->getSession()->getFlashBag()->add('bo-log-message', 'Envoi du mail à l\'utilisateur OK');
                            else
                                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de l\'envoi du mail');
                        }

                        return $this->redirect($this->generateUrl('jc_user_bo_list'));
                    }
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde de l\'utilisateur');
            }
        }
        else
            $form = $this->createForm(new UserType(), $user);

            // Get role list to select user's role
        $roleList = $this->getDoctrine()->getManager()->getRepository('jcUserBundle:Role')->findAll();

        return $this->render('jcUserBundle:BO:edit.html.twig', array(
                'userToEdit' => $form->createView(),
                'roleList' => $roleList
        ));
    }

    public function deleteAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $userToDelete = $entityManager->getRepository('jcUserBundle:User')->find($id);

                // If user found => delete it
                if ($userToDelete != null) {
                    $entityManager->remove($userToDelete);
                    $entityManager->flush();

                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression de l\'utilisateur OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression de l\'utilisateur');
            }
        }

        // Return to user list
        return $this->redirect($this->generateUrl('jc_user_bo_list'));
    }
}
