<?php

namespace jc\SudokuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jc\SudokuBundle\Service\SudokuGeneratorService;
use jc\SudokuBundle\Service\SudokuResolverService;
use jc\SudokuBundle\Model\Helper\SudokuForm;
use jc\SudokuBundle\Model\SudokuGrid;
use jc\SudokuBundle\Form\SudokuFormType;

class SudokuController extends Controller {

    public function indexAction() {

        $request = $this->getRequest();
        $sudokuForm = new SudokuForm(null, 3);

        $debugGridList = array();
        $resolvedCell = null;

        // If user has submit form => resolve sudoku
        if ($request->isMethod('POST')) {

            $form = $this->createForm(new SudokuFormType(), $sudokuForm);
            $form->handleRequest($request);

            $sudokuResolverService = $this->getSudokuResolverService();

            // If user has clicked on "debug button" => display all sudoku "help grid"
            if ($request->request->has('debug')) {

                // We create one grid for each resolve method
                $help1 = new SudokuGrid($sudokuForm);
                $help2 = new SudokuGrid($sudokuForm);
                $help3 = new SudokuGrid($sudokuForm);
                $help4 = new SudokuGrid($sudokuForm);

                $sudokuResolverService->resolveSimpleValues($help1);
                $sudokuResolverService->resolveSimpleValues($help2);
                $sudokuResolverService->resolveSimpleValues($help3);
                $sudokuResolverService->resolveSimpleValues($help4);

                $sudokuResolverService->resolveLinkedValues($help2, 2);
                $sudokuResolverService->resolveLinkedValues($help3, 2);
                $sudokuResolverService->resolveLinkedValues($help4, 2);

                $sudokuResolverService->resolveSingleValue($help3);
                $sudokuResolverService->resolveSingleValue($help4);

                $resolvedList4 = $sudokuResolverService->resolveBlockSingleValue($help4);

                $debugGridList[] = $help1;
                $debugGridList[] = $help2;
                $debugGridList[] = $help3;
                $debugGridList[] = $help4;
            }
            // If user requires help to resolve sudoku => add one resolved cell with message
            else if ($request->request->has('help')) {

                $resolveLevel = SudokuResolverService::SIMPLE_LEVEL;
                $resolvedGrid = new SudokuGrid($sudokuForm);

                // Try to find value looking for existing value on same line, same column and in same block
                $cellList = $sudokuResolverService->resolveSimpleValues($resolvedGrid);

                // Try to find value using linked value => i.e. couple of values to remove on line/column or in block
                if (count($cellList) == 0) {

                    $resolveLevel = SudokuResolverService::LINKED_LEVEL;
                    $cellList = $sudokuResolverService->resolveLinkedValues($resolvedGrid, 2);
                }

                // Try to find value that appears once on line/column or in block
                if (count($cellList) == 0) {

                    $resolveLevel = SudokuResolverService::SINGLE_LEVEL;
                    $cellList = $sudokuResolverService->resolveSingleValue($resolvedGrid);
                }

                // Try to find value removing value that appears on unique line/column in a block
                if (count($cellList) == 0) {

                    $resolveLevel = SudokuResolverService::BLOCK_SINGLE_LEVEL;
                    $cellList = $sudokuResolverService->resolveBlockSingleValue($resolvedGrid);
                }

                if (count($cellList) > 0) {

                    $resolvedCell = $cellList[0];
                    $sudokuForm->initCell($resolvedCell->getLine(), $resolvedCell->getColumn(), $resolvedCell->getValue(), $resolvedCell->getStatus());
                    $form = $this->createForm(new SudokuFormType(), $sudokuForm);
                }
            }
        }
        // Generate new sudoku
        else {

            $sudokuGeneratorService = $this->getSudokuGeneratorService();
            $sudokuGeneratorService->mediumFiller($sudokuForm);

            $form = $this->createForm(new SudokuFormType(), $sudokuForm);
        }

        return $this->render('jcSudokuBundle::sudoku.html.twig', array(
                'sudoku' => $form->createView(),
                'debugGridList' => $debugGridList,
                'resolvedCell' => $resolvedCell
        ));
    }

    /**
     * @return SudokuGeneratorService
     */
    private function getSudokuGeneratorService() {
        return $this->get('jc_sudoku.generator');
    }

    /**
     * @return SudokuResolverService
     */
    private function getSudokuResolverService() {
        return $this->get('jc_sudoku.resolver');
    }
}
