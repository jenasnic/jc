<?php

namespace jc\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use jc\UserBundle\Entity\User;
use jc\UserBundle\Form\UserType;
use jc\ToolBundle\Util\PasswordUtil;
use jc\ToolBundle\Util\ValidateUtil;

class UserController extends Controller {

    /**
     * @Route("/admin/user/list", name="jc_user_bo_list")
     */
    public function listAction() {

        $userList = $this->getDoctrine()->getManager()->getRepository('jcUserBundle:User')->findBy(array(), array('username' => 'asc'));
        return $this->render('jcUserBundle:BO:list.html.twig', array('userList' => $userList));
    }

    /**
     * @Route("/admin/user/edit/{id}", defaults={"id" = 0}, name="jc_user_bo_edit")
     */
    public function editAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $user = ($id > 0) ? $entityManager->getRepository('jcUserBundle:User')->find($id) : new User();

        // If user has submit form => save user
        if ($request->getMethod() == 'POST') {

            try {

                // Keep initial password for further use...
                $initialPassword = $user->getPassword();

                $form = $this->createForm(new UserType(), $user);
                $form->handleRequest($request);

                $generatePassword = $request->request->get('generate-password');

                if ($generatePassword)
                    $user->setPassword(PasswordUtil::generatePassword(6, true, true, true, false));
                else {

                    // For new user or if password changed => check password security + password confirmation
                    if (!$user->getId() || strlen($user->getPassword()) > 0) {

                        if (!ValidateUtil::checkPassword($user->getPassword(), 1))
                            $form->get('password')->addError(new FormError("Le mot de passe n'est pas assez fort"));
                        else if (strcmp($user->getPassword(), $user->getConfirmPassword()) != 0)
                            $form->get('confirmPassword')->addError(new FormError("La confirmation du mot de passe n'est pas correcte"));
                    }
                }

                if ($form->isValid()) {

                    // For generated password, new user or new password => Encode password using SHA
                    if ($generatePassword || !$user->getId() || strlen($user->getPassword()) > 0)
                        $user->setPassword(PasswordUtil::encodePassword($user->getPassword()));
                    // In other case used initial password (unchanged)
                    else
                        $user->setPassword($initialPassword);

                    $entityManager->persist($user);
                    $entityManager->flush();
                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde OK');

                    // If account must be sent to user => update password + send mail
                    if ($request->request->get('generate-password')) {

                        $accountMailService = $this->get('jc_user.account_mail');
                        if ($accountMailService->sendNewAccountInformation($user->getId(), true))
                            $request->getSession()->getFlashBag()->add('bo-log-message', 'Envoi du mail à l\'utilisateur OK');
                        else
                            $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de l\'envoi du mail');
                    }

                    return $this->redirect($this->generateUrl('jc_user_bo_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde');
            }
        }
        else {

            // Erase password information
            $user->setPassword('');
            $form = $this->createForm(new UserType(), $user);
        }

            // Get role list to select user's role
        $roleList = $this->getDoctrine()->getManager()->getRepository('jcUserBundle:Role')->findAll();

        return $this->render('jcUserBundle:BO:edit.html.twig', array(
                'userToEdit' => $form->createView(),
                'roleList' => $roleList
        ));
    }

    /**
     * @Route("/admin/user/delete/{id}", requirements={"id" = "\d+"}, name="jc_user_bo_delete")
     */
    public function deleteAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $userToDelete = $entityManager->getRepository('jcUserBundle:User')->find($id);

                // If user found => delete it
                if ($userToDelete != null) {
                    $entityManager->remove($userToDelete);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
                }
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to user list
        return $this->redirect($this->generateUrl('jc_user_bo_list'));
    }
}
