<?php

namespace jc\QuizzBundle\Controller;

use jc\QuizzBundle\Entity\QuizzResponse;
use jc\QuizzBundle\Form\QuizzResponseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResponseBOController extends Controller {

    /**
     * @Route("/admin/quizz/{id}/response/list", requirements={"id" = "\d+"}, name="jc_quizz_bo_response_list")
     */
    public function listResponseAction(Request $request, $id) {

        $quizz = $this->getDoctrine()->getManager()->getRepository('jcQuizzBundle:Quizz')->find($id);
        return $this->render('jcQuizzBundle:BO:listResponse.html.twig', array('responseList' => $quizz->getResponses()));
    }

    /**
     * @Route("/admin/quizz/{id}/response/edit/{responseId}", requirements={"id" = "\d+"}, defaults={"responseId" = 0}, name="jc_quizz_bo_response_edit")
     */
    public function editResponseAction(Request $request, $id, $responseId) {

        $entityManager = $this->getDoctrine()->getManager();

        $response = ($responseId > 0) ? $entityManager->getRepository('jcQuizzBundle:QuizzResponse')->find($responseId) : new QuizzResponse();

        // If user has submit form => save response
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(QuizzResponseType::class, $response);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    // For new response => set quizz
                    if ($responseId == 0) {

                        $quizz = $entityManager->getRepository('jcQuizzBundle:Quizz')->find($id);
                        $response->setQuizz($quizz);
                    }

                    $entityManager->persist($response);
                    $entityManager->flush();

                    return new JsonResponse(array('action' => 'save', 'success' => true));
                }
                else {

                    return new JsonResponse(array(
                            'action' => 'save',
                            'success' => false,
                            'response' => $this->render('jcQuizzBundle:BO:editResponse.html.twig', array(
                                    'responseToEdit' => $form->createView(),
                                    'quizzId' => $id))));
                }
            }
            catch (Exception $e) {
                return new JsonResponse(array('action' => 'save', 'success' => false, 'response' => 'Erreur lors de la création de la réponse'));
            }
        }
        else
            $form = $this->createForm(QuizzResponseType::class, $response);

        return $this->render('jcQuizzBundle:BO:editResponse.html.twig', array(
                'responseToEdit' => $form->createView(),
                'quizzId' => $id));
    }

    /**
     * @Route("/admin/quizz/{id}/response/delete/{responseId}", requirements={"id" = "\d+", "responseId" = "\d+"}, name="jc_quizz_bo_response_delete")
     */
    public function deleteResponseAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $responseToDelete = $entityManager->getRepository('jcQuizzBundle:QuizzResponse')->find($id);

                // If quizz found => delete it
                if ($responseToDelete != null) {

                    $entityManager->remove($responseToDelete);
                    $entityManager->flush();

                    return new JsonResponse(1);
                }
            }
            catch (Exception $e) {
                return new JsonResponse(0);
            }
        }
    }
}
