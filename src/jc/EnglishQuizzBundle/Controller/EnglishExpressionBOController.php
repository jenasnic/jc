<?php

namespace jc\EnglishQuizzBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use jc\EnglishQuizzBundle\Controller\Common\CommonEnglishItemController;
use jc\EnglishQuizzBundle\Form\EnglishExpressionType;
use jc\EnglishQuizzBundle\Entity\EnglishExpression;

class EnglishExpressionBOController extends CommonEnglishItemController {

    /**
     * @Route("/admin/english-quizz/expression/manage", name="jc_english_quizz_bo_expression_manage")
     */
    public function manageExpressionAction(Request $request) {
        return $this->render('jcEnglishQuizzBundle:BO:expressionManage.html.twig', array('ajaxURL' => '/admin/ajax/english-quizz/expression/search'));
    }

    /**
     * @Route("/admin/ajax/english-quizz/expression/search", name="jc_english_quizz_bo_expression_search")
     */
    public function searchExpressionAction(Request $request) {
        return $this->searchItemAction($request, EnglishExpression::class, 'jcEnglishQuizzBundle:BO/ajax:expressionSearch.html.twig', 'expressionList');
    }

    /**
     * @Route("/admin/english-quizz/expression/list", name="jc_english_quizz_bo_expression_list")
     */
    public function listExpressionAction(Request $request) {
        return $this->listItemAction($request, 'jcEnglishQuizzBundle:EnglishExpression', 'textEN', 'jcEnglishQuizzBundle:BO:expressionList.html.twig', 'expressionPage');
    }

    /**
     * @Route("/admin/english-quizz/expression/edit/{id}", defaults={"id" = 0}, name="jc_english_quizz_bo_expression_edit")
     */
    public function editExpressionAction(Request $request, $id) {
        return $this->editItemAction($request, $id, 'jc\EnglishQuizzBundle\Entity\EnglishExpression', EnglishExpressionType::class,
                'jcEnglishQuizzBundle:BO:expressionEdit.html.twig', 'expressionToEdit', 'jc_english_quizz_bo_expression_manage');
    }

    /**
     * @Route("/admin/english-quizz/expression/delete/{id}", requirements={"id" = "\d+"}, name="jc_english_quizz_bo_expression_delete")
     */
    public function deleteExpressionAction(Request $request, $id) {
        return $this->deleteItemAction($request, $id, EnglishExpression::class, 'jc_english_quizz_bo_expression_manage');
    }

    /**
     * @Route("/admin/english-quizz/expression/import", name="jc_english_quizz_bo_expression_import")
     */
    public function importExpressionAction(Request $request) {
        return $this->importItemAction($request, 'jc_english_quizz_bo_expression_manage');
    }

    /**
     * Method to process expression matching specified CSV line.
     * @param array $line CSV line containing data for expression to create/update...
     * @return object Expression to create or to update matching specified CSV line, null if no expression to process (already exist).
     */
    protected function processItemFromCSVLine($line) {

        $expression = new EnglishExpression();
        $expression->setTextEN($line[0]);
        $expression->setTextFR($line[1]);
        $expression->setLesson(isset($line[2]) ? $line[2] : 0);
        $expression->setPage(isset($line[3]) ? $line[3] : 0);

        // If expression already exist => check to update it
        $existingExpression = $this->getDoctrine()->getManager()->getRepository(EnglishExpression::class)->findOneBy(array('textEN' => $expression->getTextEN()));
        if ($existingExpression) {

            $expressionUpdated = false;

            // If existing expression doesn't define lesson => update it if necessary
            if ($existingExpression->getLesson() == 0 and $expression->getLesson() > 0) {

                $existingExpression->setLesson($expression->getLesson());
                $expressionUpdated = true;
            }

            // If existing expression doesn't define page => update it if necessary
            if ($existingExpression->getPage() == 0 and $expression->getPage() > 0) {

                $existingExpression->setPage($expression->getPage());
                $expressionUpdated = true;
            }

            // If new translation doesn't exist yet => add it
            if (strpos($existingExpression->getTextFR(), $expression->getTextFR()) === false) {

                $existingExpression->setTextFR($existingExpression->getTextFR() . ' / ' . $expression->getTextFR());
                $expressionUpdated = true;
            }

            if ($expressionUpdated)
                return $existingExpression;

        }
        if ($existingExpression) {

            $traduction = $existingExpression->getTextFR();
            if (strpos($traduction, $expression->getTextFR()) === false) {

                $existingExpression->setTextFR($traduction . ' / ' . $expression->getTextFR());
                return $existingExpression;
            }
        }
        // If expression not found => add it
        else
            return $expression;

        return null;
    }
}
