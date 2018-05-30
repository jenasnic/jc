<?php

namespace jc\ParisOiseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\ParisOiseBundle\Entity\Document;
use jc\ParisOiseBundle\Entity\Construction;

class DocumentController extends Controller {

    /**
     * @Route("/document/{construction_id}/list", requirements={"construction_id" = "\d+"}, name="jc_document_list")
     */
    public function listAction(Request $request, $construction_id) {

        $construction = $this->getDoctrine()->getManager()->getRepository(Construction::class)->find($construction_id);
        $documentList = $this->getDoctrine()->getManager()->getRepository(Document::class)->getOrderedDocumentForConstruction($construction);
        return $this->render('jcParisOiseBundle:document:list.html.twig', array('construction' => $construction, 'documentList' => $documentList));
    }
}
