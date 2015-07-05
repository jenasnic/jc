<?php

namespace jc\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsFOController extends Controller {

    public function displayAction($id) {

        $entityManager = $this->getDoctrine()->getManager();

        // If news'id is specified => display specified news
        // NOTE : news must be published
        if ($id > 0) {

            $news = $entityManager->getRepository('jcNewsBundle:News')->find($id);
            // TODO : If news unpublished => display specific message
            return $this->render('jcNewsBundle:FO:news.html.twig', array('news' => $news));
        }
        // Else display all published news
        else {

            $newsList = $entityManager->getRepository('jcNewsBundle:News')->findBy(array('published' => true), array('rank' => 'asc'));
            return $this->render('jcNewsBundle:FO:newsList.html.twig', array('newsList' => $newsList));
        }
    }
}
