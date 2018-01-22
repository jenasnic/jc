<?php

namespace jc\EnglishQuizzBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use jc\EnglishQuizzBundle\Entity\EnglishWord;
use Symfony\Component\HttpFoundation\Request;
use jc\EnglishQuizzBundle\Form\EnglishWordType;
use jc\EnglishQuizzBundle\Controller\Common\CommonEnglishItemController;

class EnglishWordBOController extends CommonEnglishItemController {

    /**
     * @Route("/admin/english-quizz/word/manage", name="jc_english_quizz_bo_word_manage")
     */
    public function manageWordAction(Request $request) {
        return $this->render('jcEnglishQuizzBundle:BO:wordManage.html.twig', array('ajaxURL' => '/admin/ajax/english-quizz/word/search'));
    }

    /**
     * @Route("/admin/ajax/english-quizz/word/search", name="jc_english_quizz_bo_word_search")
     */
    public function searchWordAction(Request $request) {
        return $this->searchItemAction($request, EnglishWord::class, 'jcEnglishQuizzBundle:BO/ajax:wordSearch.html.twig', 'wordList');
    }

    /**
     * @Route("/admin/english-quizz/word/list", name="jc_english_quizz_bo_word_list")
     */
    public function listWordAction(Request $request) {
        return $this->listItemAction($request, 'jcEnglishQuizzBundle:EnglishWord', 'nameEN', 'jcEnglishQuizzBundle:BO:wordList.html.twig', 'wordPage');
    }

    /**
     * @Route("/admin/english-quizz/word/edit/{id}", defaults={"id" = 0}, name="jc_english_quizz_bo_word_edit")
     */
    public function editWordAction(Request $request, $id) {
        return $this->editItemAction($request, $id, 'jc\EnglishQuizzBundle\Entity\EnglishWord', EnglishWordType::class,
                'jcEnglishQuizzBundle:BO:wordEdit.html.twig', 'wordToEdit', 'jc_english_quizz_bo_word_manage');
    }

    /**
     * @Route("/admin/english-quizz/word/delete/{id}", requirements={"id" = "\d+"}, name="jc_english_quizz_bo_word_delete")
     */
    public function deleteWordAction(Request $request, $id) {
        return $this->deleteItemAction($request, $id, EnglishWord::class, 'jc_english_quizz_bo_word_manage');
    }

    /**
     * @Route("/admin/english-quizz/word/import", name="jc_english_quizz_bo_word_import")
     */
    public function importWordAction(Request $request) {
        return $this->importItemAction($request, 'jc_english_quizz_bo_word_manage');
    }

    /**
     * Method to process word matching specified CSV line.
     * @param array $line CSV line containing data for word to create/update...
     * @return object Word to create or to update matching specified CSV line, null if no word to process (already exist).
     */
    protected function processItemFromCSVLine($line) {

        $word = new EnglishWord();
        $word->setNameEN($line[0]);
        $word->setNameFR($line[1]);
        $word->setLesson(isset($line[2]) ? $line[2] : 0);
        $word->setPage(isset($line[3]) ? $line[3] : 0);

        // If word already exist => check to update it
        $existingWord = $this->getDoctrine()->getManager()->getRepository(EnglishWord::class)->findOneBy(array('nameEN' => $word->getNameEN()));
        if ($existingWord) {

            $wordUpdated = false;

            // If existing word doesn't define lesson => update it if necessary
            if ($existingWord->getLesson() == 0 and $word->getLesson() > 0) {

                $existingWord->setLesson($word->getLesson());
                $wordUpdated = true;
            }

            // If existing word doesn't define page => update it if necessary
            if ($existingWord->getPage() == 0 and $word->getPage() > 0) {

                $existingWord->setPage($word->getPage());
                $wordUpdated = true;
            }

            // If new translation doesn't exist yet => add it
            if (strpos($existingWord->getNameFR(), $word->getNameFR()) === false) {

                $existingWord->setNameFR($existingWord->getNameFR() . ' / ' . $word->getNameFR());
                $wordUpdated = true;
            }

            if ($wordUpdated)
                return $existingWord;

        }
        // If word not found => add it
        else
            return $word;

        return null;
    }
}
