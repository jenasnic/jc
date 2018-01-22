<?php

namespace jc\EnglishQuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use jc\EnglishQuizzBundle\Entity\EnglishExpression;
use jc\EnglishQuizzBundle\Entity\EnglishIrregularVerb;
use jc\EnglishQuizzBundle\Entity\EnglishWord;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EnglishQuizzFOController extends Controller {

    /**
     * @Route("/", name="jc_english_quizz_select")
     */
    public function selectEnglishQuizzAction() {
        return $this->render('jcEnglishQuizzBundle:FO:select.html.twig');
    }

    /**
     * @Route("/quizz/{type}", requirements={"type" = "\w+"}, name="jc_english_quizz_start")
     */
    public function startEnglishQuizzAction(Request $request, $type) {

        // If type not valid => return to home page
        if (!in_array($type, ['word', 'irregularVerb', 'expression', 'all']))
            return $this->redirect($this->generateUrl('jc_english_quizz_select'));

        $lang = $request->get('lang', 'EN');

        // Reset session data depending on type
        $entityManager = $this->getDoctrine()->getManager();
        $this->resetSessionForQuizz($request, $type);

        $lessonWordList = array();
        $lessonExpressionList = array();

        // For type 'word' or 'expression' => we get lesson
        if ($type == 'all' || $type == 'word')
            $lessonWordList = $entityManager->getRepository(EnglishWord::class)->getLessonList();
        if ($type == 'all' || $type == 'expression')
            $lessonExpressionList = $entityManager->getRepository(EnglishExpression::class)->getLessonList();

        $lessonList = array_merge($lessonWordList, $lessonExpressionList);
        $lessonList = array_unique($lessonList);

        return $this->render('jcEnglishQuizzBundle:FO:quizz.html.twig', array('type' => $type, 'lang' => $lang, 'lessonList' => $lessonList));
    }

    /**
     * @Route("/ajax/reset-quizz", name="jc_english_quizz_reset_quizz")
     */
    public function resetQuizzAction(Request $request) {

        $type = $request->get('type');
        $lesson = $request->get('lesson');
        $this->resetSessionForQuizz($request, $type, $lesson);

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Route("/ajax/new-quizz-item", name="jc_english_quizz_get_item")
     */
    public function getEnglishItemAction(Request $request) {

        // Get request parameter used to search new item
        $type = $request->get('type');
        $lang = $request->get('lang', 'EN');
        $lesson = $request->get('lesson', 0);

        $typeToUse = $type;
        $itemCount = 0;

        // If type is all => choose random entity
        if ($type == 'all') {

            $typeToUse = $this->getRandomTypeForQuizz($request);
            $itemCount += $request->getSession()->get('wordLeft');
            $itemCount += $request->getSession()->get('irregularVerbLeft');
            $itemCount += $request->getSession()->get('expressionLeft');
        }
        else
            $itemCount = $request->getSession()->get($typeToUse . 'Left');

        // If no more available items for quizz => stop here
        if ($typeToUse == null || $itemCount == 0)
            return $this->render('jcEnglishQuizzBundle:FO/ajax:overItem.html.twig');

        // Initialize variables depending on type of data used for quizz
        $classToUse = null;
        switch($typeToUse) {
            case 'word':
                $classToUse = EnglishWord::class;
                break;
            case 'irregularVerb':
                $classToUse = EnglishIrregularVerb::class;
                break;
            case 'expression':
                $classToUse = EnglishExpression::class;
                break;
        }

        // Get remaining items matching type
        $idList = $request->getSession()->get($typeToUse . 'IdList', array());

        $itemList = $this->getDoctrine()->getManager()->getRepository($classToUse)->getItemExcludingIds($idList, $lesson);
        $itemCount = count($itemList);

        if ($itemCount > 0) {

            // Get random item
            $itemIndex = rand(0, $itemCount - 1);
            $randomItem = $itemList[$itemIndex];

            // Update session
            $idList[] = $randomItem->getId();
            $request->getSession()->set($typeToUse . 'IdList', $idList);
            $request->getSession()->set($typeToUse . 'Left', $itemCount - 1);

            $totalItemLeft = 0;
            if ($type == 'all') {

                $totalItemLeft += $request->getSession()->get('wordLeft');
                $totalItemLeft += $request->getSession()->get('irregularVerbLeft');
                $totalItemLeft += $request->getSession()->get('expressionLeft');
            }
            else
                $totalItemLeft = $request->getSession()->get($typeToUse . 'Left');

            if ($lang == 'FR')
                $randomItem->reverseLanguage();

                return $this->render('jcEnglishQuizzBundle:FO/ajax:' . $typeToUse . 'Item.html.twig', array('item' => $randomItem, 'itemLeft' => $totalItemLeft));
        }
        // If no more word => end of quizz
        else
            return $this->render('jcEnglishQuizzBundle:FO/ajax:overItem.html.twig');
    }

    private function getRandomTypeForQuizz(Request $request) {

        // If data already over for quizz => ignore them for random choice...
        $typeChoice = array();
        if ($request->getSession()->get('wordLeft') > 0)
            $typeChoice[] = 'word';
        if ($request->getSession()->get('irregularVerbLeft') > 0)
            $typeChoice[] = 'irregularVerb';
        if ($request->getSession()->get('expressionLeft') > 0)
            $typeChoice[] = 'expression';

        $typeCount = count($typeChoice);

        // If no available type (i.e. all data already asked) => return null
        if ($typeCount == 0)
            return null;
        else
            return $typeChoice[rand(0, $typeCount - 1)];
    }

    private function resetSessionForQuizz(Request $request, $type, $lesson = 0) {

        $entityManager = $this->getDoctrine()->getManager();

        if ($type == 'all' || $type == 'word') {

            $request->getSession()->set('wordIdList', array());
            $request->getSession()->set('wordLeft', $entityManager->getRepository(EnglishWord::class)->countItem($lesson));
        }
        if ($type == 'all' || $type == 'irregularVerb') {

            $request->getSession()->set('irregularVerbIdList', array());
            $request->getSession()->set('irregularVerbLeft', $entityManager->getRepository(EnglishIrregularVerb::class)->countItem($lesson));
        }
        if ($type == 'all' || $type == 'expression') {

            $request->getSession()->set('expressionIdList', array());
            $request->getSession()->set('expressionLeft', $entityManager->getRepository(EnglishExpression::class)->countItem($lesson));
        }
    }
}
