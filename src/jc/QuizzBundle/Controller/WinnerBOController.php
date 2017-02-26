<?php

namespace jc\QuizzBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\QuizzBundle\Entity\Quizz;
use Symfony\Component\HttpFoundation\Request;
use jc\QuizzBundle\Entity\Winner;

class WinnerBOController extends Controller {

    /**
     * @Route("/admin/quizz/winner/list/{id}", requirements={"id" = "\d+"}, name="jc_quizz_bo_winner_list")
     */
    public function winnerListAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $quizz = $entityManager->getRepository(Quizz::class)->find($id);
        $winnerList = $entityManager->getRepository(Winner::class)->getWinnerForQuizzId($id);

        return $this->render('jcQuizzBundle:BO:listWinner.html.twig', array(
                'quizz' => $quizz,
                'winnerList' => $winnerList
        ));
    }

    /**
     * @Route("/admin/quizz/winner/clear/{id}", requirements={"id" = "\d+"}, name="jc_quizz_bo_winner_clear")
     */
    public function winnerClearAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $winnerList = $this->getDoctrine()->getManager()->getRepository(Winner::class)->removeWinnerForQuizzId($id);
                $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to quizz list
        return $this->redirect($this->generateUrl('jc_quizz_bo_list'));
    }
}
