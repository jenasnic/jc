<?php

namespace jc\MovieQuizzBundle\Controller;

use jc\MovieQuizzBundle\Entity\Quizz;
use jc\MovieQuizzBundle\Entity\Winner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WinnerBOController extends Controller {

    /**
     * @Route("/admin/movie-quizz/winner/list/{id}", requirements={"id" = "\d+"}, name="jc_movie_quizz_bo_winner_list")
     */
    public function winnerListAction(Request $request, $id) {

        $entityManager = $this->getDoctrine()->getManager();

        $quizz = $entityManager->getRepository(Quizz::class)->find($id);
        $winnerList = $entityManager->getRepository(Winner::class)->getWinnerForQuizzId($id);

        return $this->render('jcMovieQuizzBundle:BO:listWinner.html.twig', array(
                'quizz' => $quizz,
                'winnerList' => $winnerList
        ));
    }

    /**
     * @Route("/admin/movie-quizz/winner/clear/{id}", requirements={"id" = "\d+"}, name="jc_movie_quizz_bo_winner_clear")
     */
    public function winnerClearAction(Request $request, $id) {

        if ($id > 0) {

            try {

                $winnerList = $this->getDoctrine()->getManager()->getRepository(Winner::class)->removeWinnerForQuizzId($id);
                $request->getSession()->getFlashBag()->add('bo-log-message', 'Suppression OK');
            }
            catch (\Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression');
            }
        }

        // Return to quizz list
        return $this->redirect($this->generateUrl('jc_movie_quizz_bo_list'));
    }
}
