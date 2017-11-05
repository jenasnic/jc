<?php

namespace jc\MovieQuizzBundle\Controller;

use jc\MovieQuizzBundle\Entity\Quizz;
use jc\MovieQuizzBundle\Entity\QuizzResponse;
use jc\MovieQuizzBundle\Entity\Winner;
use jc\MovieQuizzBundle\Form\WinnerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizzFOController extends Controller {

    /**
     * @Route("/movie-quizz/{id}", requirements={"id" = "\d+"}, name="jc_movie_quizz_fo")
     */
    public function quizzDisplay($id) {

        $quizz = $this->getDoctrine()->getManager()->getRepository(Quizz::class)->find($id);

        $winner = new Winner();
        $winner->setQuizz($quizz);

        $form = $this->createForm(WinnerType::class, $winner);

        return $this->render('jcMovieQuizzBundle:FO:quizz.html.twig', array('quizz' => $quizz, 'winner' => $form->createView()));
    }

    /**
     * @Route("/movie-quizz/ask", name="jc_movie_quizz_ask")
     */
    public function quizzAsk(Request $request) {

        try {

            $quizzId = $request->request->get('quizzId');
            $responseToCheck = $request->request->get('response');

            // Remove blank space at the begining and at the end of the response
            $responseToCheck = trim($responseToCheck);

            if ($quizzId > 0 && strlen($responseToCheck) > 0) {

                $entityManager = $this->getDoctrine()->getManager();
                $responseList = $entityManager->getRepository(QuizzResponse::class)->searchMatchingResponseForQuizzId($responseToCheck, $quizzId);

                if (count($responseList) == 1) {

                    $finalResponse = $responseList[0];
                    return new JsonResponse(array('success' => true, 'title' => $finalResponse->getTitle(), 'id' => $finalResponse->getId(),
                            'positionX' => $finalResponse->getPositionX(), 'positionY' => $finalResponse->getPositionY(), 'size' => $finalResponse->getSize()
                    ));
                }
            }

            return new JsonResponse(array('success' => false, 'message' => 'Réponse incorrecte'));
        }
        catch (\Exception $e) {
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors du traitement de la réponse'));
        }
    }

    /**
     * @Route("/movie-quizz/responses/{id}", requirements={"id" = "\d+"}, name="jc_movie_quizz_responses")
     */
    public function quizzResponses($id, Request $request) {

        // If user not logged in => DO NOT DISPLAY RESPONSES
        if(!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') )
            return new JsonResponse(array('success' => false, 'message' => 'Impossible de récupérer les réponses : droits insuffisants'));

        try {

            $quizz = $this->getDoctrine()->getManager()->getRepository(Quizz::class)->find($id);
            $responses = array();

            foreach ($quizz->getResponses() as $response) {
                $responses[] = array('title' => $response->getTitle(), 'id' => $response->getId(),
                        'positionX' => $response->getPositionX(), 'positionY' => $response->getPositionY(), 'size' => $response->getSize()
                );
            }

            return new JsonResponse(array('success' => true, 'responses' => $responses));
        }
        catch (\Exception $e) {
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de la récupération des réponses'));
        }
    }

    /**
     * @Route("/movie-quizz/win/{id}", requirements={"id" = "\d+"}, name="jc_movie_quizz_win")
     */
    public function quizzWin(Request $request, $id) {

        // If user has submit form => save winner
        if ($request->getMethod() == 'POST') {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $quizz = $entityManager->getRepository(Quizz::class)->find($id);

                if ($quizz) {

                    // Get all responses found and check if quizz successfully completed
                    $responses = $request->request->get('responses');
                    $responses = explode(';', $responses);
                    if ($this->checkQuizzResponses($quizz, $responses)) {

                        $winner = new Winner();
                        $winner->setQuizz($quizz);
                        $winner->setDate(new \DateTime());

                        // Update winner object with date from request
                        // NOTE : for comment => replace break lines with HTML tag
                        $winner->setName($request->request->get('name'));
                        $winner->setMail($request->request->get('mail'));
                        $comment = str_replace("\n", "<br/>", $request->request->get('comment'));
                        $winner->setComment($comment);
                        $winner->setTrickCount($request->request->get('trickCount'));

                        $entityManager->persist($winner);
                        $entityManager->flush();

                        return new JsonResponse(array('success' => true, 'message' => 'Vous avez bien été enregistré !'));
                    }
                    else
                        return new JsonResponse(array('success' => false, 'message' => 'Vous n\'avez pas résolu le quizz !'));
                }
                else
                    return new JsonResponse(array('success' => false, 'message' => 'Quizz inconnu'));
            }
            catch (\Exception $e) {
                return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de votre enregistrement'));
            }
        }
        else
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de votre enregistrement'));
    }

    /**
     * @Route("/movie-quizz/trick", requirements={"id" = "\d+"}, name="jc_movie_quizz_trick")
     */
    public function quizzTrick(Request $request) {

        try {

            $quizzId = $request->request->get('quizzId');
            $positionX = $request->request->get('positionX');
            $positionY = $request->request->get('positionY');

            $entityManager = $this->getDoctrine()->getManager();
            $responseList = $entityManager->getRepository(QuizzResponse::class)->searchMatchingResponseWithCoordonate($positionX, $positionY, $quizzId);

            if ($responseList) {

                $responses = array();
                foreach ($responseList as $response)
                    $responses[] = array('title' => $response->getTrick());

                return new JsonResponse(array('success' => true, 'trick' => $responses));
            }
            else
                return new JsonResponse(array('success' => false, 'message' => 'Aucun indice pour la zone indiquée'));
        }
        catch (\Exception $e) {
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors de la récupération des indices'));
        }
    }

    private function checkQuizzResponses(Quizz $quizz, $responses) {

        if (count($responses) != count($quizz->getResponses()))
            return false;

        // Browse quizz response and check with responses found
        foreach ($quizz->getResponses() as $response) {

            if (!in_array($response->getTitle(), $responses))
                return false;
        }

        return true;
    }
}
