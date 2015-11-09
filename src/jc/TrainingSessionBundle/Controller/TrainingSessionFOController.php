<?php

namespace jc\TrainingSessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\TrainingSessionBundle\Entity\TrainingSession;
use jc\TrainingSessionBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\JsonResponse;

class TrainingSessionFOController extends Controller {

    public function displayAction($id) {

        $entityManager = $this->getDoctrine()->getManager();

        if ($id > 0) {

            $trainingSession = $entityManager->getRepository('jcTrainingSessionBundle:TrainingSession')->find($id);
            return $this->render('jcTrainingSessionBundle:FO:trainingSession.html.twig', array('trainingSession' => $trainingSession));
        }
        else {

            // Get page to display (display page 1 per default)
            $page = intval($this->getRequest()->get('page'));
            if ($page == 0)
                $page = 1;

            $paginationService = $this->get('jc_tool.pagination');
            $paginationInformation = $paginationService->getPaginationInformation($page, 'jcTrainingSessionBundle:TrainingSession', 'date', 'desc');

            return $this->render('jcTrainingSessionBundle:FO:trainingSessionList.html.twig', array('paginationInformation' => $paginationInformation));
        }
    }

    public function editCommentAction($trainingSessionId) {

        $request = $this->getRequest();

        // Check if request use POST methode
        if ($request->getMethod() == 'POST') {

            $entityManager = $this->getDoctrine()->getManager();
            $trainingSession = $entityManager->getRepository('jcTrainingSessionBundle:TrainingSession')->find($trainingSessionId);

            $comment = new Comment();
            $comment->setAuthor($this->getUser());
            $comment->setDate(new \DateTime());
            $comment->setTrainingSession($trainingSession);
            $comment->setText($request->request->get('comment'));

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->render('jcTrainingSessionBundle:FO:comment.html.twig', array('comment' => $comment));
        }
    }

    public function deleteCommentAction($id) {

        $request = $this->getRequest();

        // Check if request use POST methode + identifier defined
        if (($request->getMethod() == 'POST') && ($id > 0)) {

            $entityManager = $this->getDoctrine()->getManager();
            $commentToDelete = $entityManager->getRepository('jcTrainingSessionBundle:Comment')->find($id);

            // If comment found => delete it
            if ($commentToDelete != null) {

                // NOTE : Only administrator and comment's author can delete comment
                if ($commentToDelete->getAuthor()->getId() == $this->getUser()->getId() || $this->getUser()->isAdmin()) {
                    $entityManager->remove($commentToDelete);
                    $entityManager->flush();
                }

                return new JsonResponse(1);
            }
        }

        return new JsonResponse(0);
    }
}
