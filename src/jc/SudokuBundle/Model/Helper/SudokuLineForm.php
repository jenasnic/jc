<?php

namespace jc\SudokuBundle\Model\Helper;

/**
 * This class allows to define line for sudoku in SudokuForm.
 * @see SudokuForm
 * @author JC
 */
class SudokuLineForm {

    private $cellList;    // SudokuCellForm[]

    public function __construct($blockSize = 3) {
        $this->initCellList($blockSize);
    }

    /**
     * @param interger $column Index of cell we want to get.
     * @return SudokuCellForm Cell maching specified column in line.
     */
    public function getCell($column) {
        return $this->cellList[$column];
    }

    /**
     * @param interger $column Index of cell we want to set value.
     * @param SudokuCellForm Cell maching specified column in line.
     * @param SudokuStatus $status Status to define state of cell.
     */
    public function initCell($column, $value, $status) {

        $this->cellList[$column]->setValue($value);
        $this->cellList[$column]->setStatus($status);
    }

    public function getCellList() {
        return $this->cellList;
    }
    public function setCellList($cellList) {
        $this->cellList = $cellList;
        return $this;
    }

    private function initCellList($blockSize) {

        $fullSize = $blockSize * $blockSize;

        for ($i = 0; $i < $fullSize; $i++)
            $this->cellList[$i] = new SudokuCellForm();
    }
}
