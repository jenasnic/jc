<?php

namespace jc\MovieQuizzBundle\Controller;

use jc\MovieQuizzBundle\Entity\Quizz;
use jc\MovieQuizzBundle\Entity\QuizzResponse;
use jc\MovieQuizzBundle\Form\QuizzResponseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ResponseBOController extends Controller {

    /**
     * @Route("/admin/movie-quizz/{id}/response/list", requirements={"id" = "\d+"}, name="jc_movie_quizz_bo_response_list")
     */
    public function listResponseAction(Request $request, $id) {

        $quizz = $this->getDoctrine()->getManager()->getRepository(Quizz::class)->find($id);
        return $this->render('jcMovieQuizzBundle:BO:listResponse.html.twig', array('responseList' => $quizz->getResponses()));
    }

    /**
     * @Route("/admin/movie-quizz/{id}/response/edit/{responseId}", requirements={"id" = "\d+"}, defaults={"responseId" = 0}, name="jc_movie_quizz_bo_response_edit")
     */
    public function editResponseAction(Request $request, $id, $responseId) {

        $entityManager = $this->getDoctrine()->getManager();

        if ($responseId > 0)
            $response = $entityManager->getRepository(QuizzResponse::class)->find($responseId);
        else {

            $response = new QuizzResponse();
            $quizz = $entityManager->getRepository(Quizz::class)->find($id);
            $response->setQuizz($quizz);
            $response->setPositionX(0);
            $response->setPositionY(0);
        }

        // If user has submit form => save response
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(QuizzResponseType::class, $response);
                $form->handleRequest($request);

                if ($form->isValid()) {

                    $entityManager->persist($response);
                    $entityManager->flush();

                    return new JsonResponse(array('action' => 'save', 'success' => true));
                }
                else {

                    return new JsonResponse(array(
                            'action' => 'save',
                            'success' => false,
                            'response' => $this->render('jcMovieQuizzBundle:BO:editResponse.html.twig', array(
                                    'responseToEdit' => $form->createView(),
                                    'quizzId' => $id))));
                }
            }
            catch (\Exception $e) {
                return new JsonResponse(array('action' => 'save', 'success' => false, 'response' => 'Erreur lors de la création de la réponse'));
            }
        }
        else
            $form = $this->createForm(QuizzResponseType::class, $response);

        return $this->render('jcMovieQuizzBundle:BO:editResponse.html.twig', array('responseToEdit' => $form->createView()));
    }

    /**
     * @Route("/admin/movie-quizz/{id}/response/delete/{responseId}", requirements={"id" = "\d+", "responseId" = "\d+"}, name="jc_movie_quizz_bo_response_delete")
     */
    public function deleteResponseAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $responseToDelete = $entityManager->getRepository(QuizzResponse::class)->find($id);

                // If quizz found => delete it
                if ($responseToDelete != null) {

                    $entityManager->remove($responseToDelete);
                    $entityManager->flush();

                    return new JsonResponse(1);
                }
            }
            catch (\Exception $e) {
                return new JsonResponse(0);
            }
        }
    }
}
