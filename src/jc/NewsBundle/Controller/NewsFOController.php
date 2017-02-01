<?php

namespace jc\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\NewsBundle\Entity\News;

class NewsFOController extends Controller {

    /**
     * @Route("/news/{id}", defaults={"id" = 0}, name="jc_news_fo_index")
     */
    public function displayAction($id) {

        $entityManager = $this->getDoctrine()->getManager();

        // If news'id is specified => display specified news
        // NOTE : news must be published
        if ($id > 0) {

            $news = $entityManager->getRepository(News::class)->find($id);

            // If news unpublished => return to news list with specific message
            if (! $news->getPublished()) {

                $request->getSession()->getFlashBag()->add('popup-message', 'Cette actualité a été dépubliée');
                return $this->redirect($this->generateUrl('jc_news_fo_index'));
            }

            return $this->render('jcNewsBundle:FO:news.html.twig', array('news' => $news));
        }
        // Else display all published news
        else {

            $newsList = $entityManager->getRepository(News::class)->findBy(array('published' => true), array('rank' => 'asc'));
            return $this->render('jcNewsBundle:FO:newsList.html.twig', array('newsList' => $newsList));
        }
    }
}
