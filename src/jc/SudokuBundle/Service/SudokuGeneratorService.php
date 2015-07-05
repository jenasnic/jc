<?php

namespace jc\SudokuBundle\Service;

use jc\SudokuBundle\Model\Helper\SudokuForm;
use jc\SudokuBundle\Model\SudokuStatus;

class SudokuGeneratorService {

    public function easyFiller(SudokuForm $form) {

        $form->initCell(0, 2, 3, SudokuStatus::INITIAL);
        $form->initCell(0, 3, 8, SudokuStatus::INITIAL);
        $form->initCell(0, 8, 9, SudokuStatus::INITIAL);
        $form->initCell(1, 1, 6, SudokuStatus::INITIAL);
        $form->initCell(1, 2, 7, SudokuStatus::INITIAL);
        $form->initCell(1, 4, 1, SudokuStatus::INITIAL);
        $form->initCell(1, 5, 4, SudokuStatus::INITIAL);
        $form->initCell(1, 7, 5, SudokuStatus::INITIAL);
        $form->initCell(2, 0, 8, SudokuStatus::INITIAL);
        $form->initCell(2, 1, 5, SudokuStatus::INITIAL);
        $form->initCell(2, 4, 9, SudokuStatus::INITIAL);
        $form->initCell(2, 5, 6, SudokuStatus::INITIAL);
        $form->initCell(2, 7, 4, SudokuStatus::INITIAL);
        $form->initCell(3, 4, 4, SudokuStatus::INITIAL);
        $form->initCell(3, 5, 2, SudokuStatus::INITIAL);
        $form->initCell(3, 6, 6, SudokuStatus::INITIAL);
        $form->initCell(3, 8, 5, SudokuStatus::INITIAL);
        $form->initCell(5, 0, 2, SudokuStatus::INITIAL);
        $form->initCell(5, 2, 4, SudokuStatus::INITIAL);
        $form->initCell(5, 3, 7, SudokuStatus::INITIAL);
        $form->initCell(5, 4, 6, SudokuStatus::INITIAL);
        $form->initCell(6, 1, 8, SudokuStatus::INITIAL);
        $form->initCell(6, 3, 5, SudokuStatus::INITIAL);
        $form->initCell(6, 4, 7, SudokuStatus::INITIAL);
        $form->initCell(6, 7, 3, SudokuStatus::INITIAL);
        $form->initCell(6, 8, 2, SudokuStatus::INITIAL);
        $form->initCell(7, 1, 3, SudokuStatus::INITIAL);
        $form->initCell(7, 3, 4, SudokuStatus::INITIAL);
        $form->initCell(7, 4, 2, SudokuStatus::INITIAL);
        $form->initCell(7, 6, 5, SudokuStatus::INITIAL);
        $form->initCell(7, 7, 1, SudokuStatus::INITIAL);
        $form->initCell(8, 0, 5, SudokuStatus::INITIAL);
        $form->initCell(8, 5, 1, SudokuStatus::INITIAL);
        $form->initCell(8, 6, 8, SudokuStatus::INITIAL);
    }

    public function mediumFiller(SudokuForm $form) {

        $form->initCell(0, 0, 5, SudokuStatus::INITIAL);
        $form->initCell(0, 8, 4, SudokuStatus::INITIAL);
        $form->initCell(1, 0, 6, SudokuStatus::INITIAL);
        $form->initCell(1, 1, 3, SudokuStatus::INITIAL);
        $form->initCell(1, 3, 4, SudokuStatus::INITIAL);
        $form->initCell(1, 5, 8, SudokuStatus::INITIAL);
        $form->initCell(2, 0, 7, SudokuStatus::INITIAL);
        $form->initCell(2, 1, 9, SudokuStatus::INITIAL);
        $form->initCell(2, 3, 2, SudokuStatus::INITIAL);
        $form->initCell(2, 7, 3, SudokuStatus::INITIAL);
        $form->initCell(3, 2, 7, SudokuStatus::INITIAL);
        $form->initCell(4, 0, 2, SudokuStatus::INITIAL);
        $form->initCell(4, 1, 5, SudokuStatus::INITIAL);
        $form->initCell(5, 0, 4, SudokuStatus::INITIAL);
        $form->initCell(5, 4, 6, SudokuStatus::INITIAL);
        $form->initCell(6, 3, 8, SudokuStatus::INITIAL);
        $form->initCell(6, 6, 3, SudokuStatus::INITIAL);
        $form->initCell(6, 7, 4, SudokuStatus::INITIAL);
        $form->initCell(7, 1, 4, SudokuStatus::INITIAL);
        $form->initCell(7, 6, 8, SudokuStatus::INITIAL);
        $form->initCell(8, 3, 9, SudokuStatus::INITIAL);
        $form->initCell(8, 5, 2, SudokuStatus::INITIAL);
        $form->initCell(8, 6, 6, SudokuStatus::INITIAL);
        $form->initCell(8, 8, 7, SudokuStatus::INITIAL);
    }

    public function hardFiller(SudokuForm $form) {

        $form->initCell(0, 0, 7, SudokuStatus::INITIAL);
        $form->initCell(0, 3, 2, SudokuStatus::INITIAL);
        $form->initCell(0, 4, 3, SudokuStatus::INITIAL);
        $form->initCell(0, 6, 9, SudokuStatus::INITIAL);
        $form->initCell(0, 7, 4, SudokuStatus::INITIAL);
        $form->initCell(1, 8, 1, SudokuStatus::INITIAL);
        $form->initCell(2, 0, 9, SudokuStatus::INITIAL);
        $form->initCell(2, 6, 2, SudokuStatus::INITIAL);
        $form->initCell(2, 8, 7, SudokuStatus::INITIAL);
        $form->initCell(3, 3, 3, SudokuStatus::INITIAL);
        $form->initCell(3, 4, 2, SudokuStatus::INITIAL);
        $form->initCell(3, 8, 4, SudokuStatus::INITIAL);
        $form->initCell(4, 0, 4, SudokuStatus::INITIAL);
        $form->initCell(4, 5, 5, SudokuStatus::INITIAL);
        $form->initCell(4, 7, 1, SudokuStatus::INITIAL);
        $form->initCell(5, 0, 3, SudokuStatus::INITIAL);
        $form->initCell(5, 4, 4, SudokuStatus::INITIAL);
        $form->initCell(5, 5, 1, SudokuStatus::INITIAL);
        $form->initCell(5, 6, 6, SudokuStatus::INITIAL);
        $form->initCell(5, 7, 2, SudokuStatus::INITIAL);
        $form->initCell(6, 0, 2, SudokuStatus::INITIAL);
        $form->initCell(6, 1, 3, SudokuStatus::INITIAL);
        $form->initCell(6, 3, 9, SudokuStatus::INITIAL);
        $form->initCell(6, 7, 5, SudokuStatus::INITIAL);
        $form->initCell(8, 2, 6, SudokuStatus::INITIAL);
        $form->initCell(8, 3, 1, SudokuStatus::INITIAL);
        $form->initCell(8, 6, 3, SudokuStatus::INITIAL);
        $form->initCell(8, 8, 9, SudokuStatus::INITIAL);
    }

    public function debugFiller(SudokuForm $form) {

        $form->initCell(0, 0, 5, SudokuStatus::INITIAL);
        $form->initCell(0, 1, 2, SudokuStatus::INITIAL);
        $form->initCell(0, 2, 8, SudokuStatus::INITIAL);
        $form->initCell(0, 8, 4, SudokuStatus::INITIAL);
        $form->initCell(1, 0, 6, SudokuStatus::INITIAL);
        $form->initCell(1, 1, 3, SudokuStatus::INITIAL);
        $form->initCell(1, 2, 1, SudokuStatus::INITIAL);
        $form->initCell(1, 3, 4, SudokuStatus::INITIAL);
        $form->initCell(1, 5, 8, SudokuStatus::INITIAL);
        $form->initCell(2, 0, 7, SudokuStatus::INITIAL);
        $form->initCell(2, 1, 9, SudokuStatus::INITIAL);
        $form->initCell(2, 2, 4, SudokuStatus::INITIAL);
        $form->initCell(2, 3, 2, SudokuStatus::INITIAL);
        $form->initCell(2, 5, 6, SudokuStatus::INITIAL);
        $form->initCell(2, 7, 3, SudokuStatus::INITIAL);
        $form->initCell(2, 8, 8, SudokuStatus::INITIAL);
        $form->initCell(3, 0, 8, SudokuStatus::INITIAL);
        $form->initCell(3, 1, 6, SudokuStatus::INITIAL);
        $form->initCell(3, 2, 7, SudokuStatus::INITIAL);
        $form->initCell(3, 8, 1, SudokuStatus::INITIAL);
        $form->initCell(4, 0, 2, SudokuStatus::INITIAL);
        $form->initCell(4, 1, 5, SudokuStatus::INITIAL);
        $form->initCell(4, 2, 3, SudokuStatus::INITIAL);
        $form->initCell(4, 3, 1, SudokuStatus::INITIAL);
        $form->initCell(5, 0, 4, SudokuStatus::INITIAL);
        $form->initCell(5, 1, 1, SudokuStatus::INITIAL);
        $form->initCell(5, 2, 9, SudokuStatus::INITIAL);
        $form->initCell(5, 4, 6, SudokuStatus::INITIAL);
        $form->initCell(5, 6, 2, SudokuStatus::INITIAL);
        $form->initCell(5, 8, 3, SudokuStatus::INITIAL);
        $form->initCell(6, 0, 9, SudokuStatus::INITIAL);
        $form->initCell(6, 1, 7, SudokuStatus::INITIAL);
        $form->initCell(6, 2, 6, SudokuStatus::INITIAL);
        $form->initCell(6, 3, 8, SudokuStatus::INITIAL);
        $form->initCell(6, 6, 3, SudokuStatus::INITIAL);
        $form->initCell(6, 7, 4, SudokuStatus::INITIAL);
        $form->initCell(6, 8, 2, SudokuStatus::INITIAL);
        $form->initCell(7, 0, 1, SudokuStatus::INITIAL);
        $form->initCell(7, 1, 4, SudokuStatus::INITIAL);
        $form->initCell(7, 2, 2, SudokuStatus::INITIAL);
        $form->initCell(7, 6, 8, SudokuStatus::INITIAL);
        $form->initCell(8, 0, 3, SudokuStatus::INITIAL);
        $form->initCell(8, 1, 8, SudokuStatus::INITIAL);
        $form->initCell(8, 2, 5, SudokuStatus::INITIAL);
        $form->initCell(8, 3, 9, SudokuStatus::INITIAL);
        $form->initCell(8, 4, 4, SudokuStatus::INITIAL);
        $form->initCell(8, 5, 2, SudokuStatus::INITIAL);
        $form->initCell(8, 6, 6, SudokuStatus::INITIAL);
        $form->initCell(8, 7, 1, SudokuStatus::INITIAL);
        $form->initCell(8, 8, 7, SudokuStatus::INITIAL);
    }
}
