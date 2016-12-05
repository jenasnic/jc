<?php

namespace jc\QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use jc\QuizzBundle\Entity\QuizzResponse;
use jc\QuizzBundle\Entity\Quizz;

class QuizzFOController extends Controller {

    /**
     * @Route("/quizz/{id}", requirements={"id" = "\d+"}, name="jc_quizz_fo")
     */
    public function quizzDisplay($id) {

        $quizz = $this->getDoctrine()->getManager()->getRepository(Quizz::class)->find($id);
        return $this->render('jcQuizzBundle:FO:quizz.html.twig', array('quizz' => $quizz));
    }

    /**
     * @Route("/quizz/ask", name="jc_quizz_ask")
     */
    public function quizzAsk(Request $request) {

        try {

            $quizzId = $request->request->get('quizzId');
            $responseToCheck = $request->request->get('response');

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
        catch (Exception $e) {
            return new JsonResponse(array('success' => false, 'message' => 'Erreur lors du traitement de la réponse'));
        }
    }
}
