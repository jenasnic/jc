<?php

namespace jc\EnglishQuizzBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use jc\EnglishQuizzBundle\Entity\EnglishIrregularVerb;
use Symfony\Component\HttpFoundation\Request;
use jc\EnglishQuizzBundle\Form\EnglishIrregularVerbType;
use jc\EnglishQuizzBundle\Controller\Common\CommonEnglishItemController;

class EnglishIrregularVerbBOController extends CommonEnglishItemController {

    /**
     * @Route("/admin/english-quizz/irregular-verb/manage", name="jc_english_quizz_bo_irregular_verb_manage")
     */
    public function manageIrregularVerbAction(Request $request) {
        return $this->render('jcEnglishQuizzBundle:BO:irregularVerbManage.html.twig', array('ajaxURL' => '/admin/ajax/english-quizz/irregular-verb/search'));
    }

    /**
     * @Route("/admin/ajax/english-quizz/irregular-verb/search", name="jc_english_quizz_bo_irregular_verb_search")
     */
    public function searchIrregularVerbAction(Request $request) {
        return $this->searchItemAction($request, EnglishIrregularVerb::class, 'jcEnglishQuizzBundle:BO/ajax:irregularVerbSearch.html.twig', 'irregularVerbList');
    }

    /**
     * @Route("/admin/english-quizz/irregular-verb/list", name="jc_english_quizz_bo_irregular_verb_list")
     */
    public function listIrregularVerbAction(Request $request) {
        return $this->listItemAction($request, 'jcEnglishQuizzBundle:EnglishIrregularVerb', 'verbEN', 'jcEnglishQuizzBundle:BO:irregularVerbList.html.twig', 'irregularVerbPage');
    }

    /**
     * @Route("/admin/english-quizz/irregular-verb/edit/{id}", defaults={"id" = 0}, name="jc_english_quizz_bo_irregular_verb_edit")
     */
    public function editIrregularVerbdAction(Request $request, $id) {
        return $this->editItemAction($request, $id, 'jc\EnglishQuizzBundle\Entity\EnglishIrregularVerb', EnglishIrregularVerbType::class,
                'jcEnglishQuizzBundle:BO:irregularVerbEdit.html.twig', 'irregularVerbToEdit', 'jc_english_quizz_bo_irregular_verb_manage');
    }

    /**
     * @Route("/admin/english-quizz/irregular-verb/delete/{id}", requirements={"id" = "\d+"}, name="jc_english_quizz_bo_irregular_verb_delete")
     */
    public function deleteIrregularVerbAction(Request $request, $id) {
        return $this->deleteItemAction($request, $id, EnglishIrregularVerb::class, 'jc_english_quizz_bo_irregular_verb_manage');
    }

    /**
     * @Route("/admin/english-quizz/irregular-verb/import", name="jc_english_quizz_bo_irregular_verb_import")
     */
    public function importVerbAction(Request $request) {
        return $this->importItemAction($request, 'jc_english_quizz_bo_irregular_verb_manage');
    }

    /**
     * Method to process irregular verb matching specified CSV line.
     * @param array $line CSV line containing data for irregular verb to create/update...
     * @return object Irregular verb to create or to update matching specified CSV line, null if no irregular verb to process (already exist).
     */
    protected function processItemFromCSVLine($line) {

        $verb = new EnglishIrregularVerb();
        $verb->setVerbEN($line[0]);
        $verb->setPreterit($line[1]);
        $verb->setPast($line[2]);
        $verb->setVerbFR($line[3]);

        // If verb already exist => check to update it
        $existingVerb = $this->getDoctrine()->getManager()->getRepository(EnglishIrregularVerb::class)->findOneBy(array('verbEN' => $verb->getVerbEN()));
        if ($existingVerb) {

            // If new translation doesn't exist yet => add it
            if (strpos($existingVerb->getVerbFR(), $verb->getVerbFR()) === false) {

                $existingVerb->setVerbFR($existingVerb->getVerbFR() . ' / ' . $verb->getNameFR());
                return $existingVerb;
            }
        }
        // If verb not found => add it
        else
            return $verb;

        return null;
    }
}
