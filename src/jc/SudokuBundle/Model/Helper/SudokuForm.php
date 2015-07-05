<?php

namespace jc\SudokuBundle\Model\Helper;

use jc\SudokuBundle\Model\SudokuStatus;

/**
 * This class allows to work on sudoku grid through symfony form's mechanisms.
 * @author JC
 */
class SudokuForm {

    private $blockSize;     // integer
    private $lineList;      // SudokuLineForm[]

    public function __construct(SudokuGrid $sudoku = null, $blockSize = 3) {

        $this->blockSize = $blockSize;
        $this->initLine($blockSize);

        if ($sudoku != null) {

            $cellList = $sudoku->getAll(true);
            foreach ($cellList as $cell) {

                $this->lineList[$cell->getLine()]->getCell($cell->getColumn())->setValue($cell->getValue());
                $this->lineList[$cell->getLine()]->getCell($cell->getColumn())->setValue($cell->getStatus());
            }
        }
    }

    /**
     * Allows to set value of specified cell in matrix.
     * @param integer $line Cell's line in matrix we want to get value.
     * @param integer $column Cell's column in matrix we want to get value.
     * @param integer $value Value to set for specified cell.
     * @param SudokuStatus $status Status to set for specified cell.
     */
    public function initCell($line, $column, $value, $status) {
        $this->lineList[$line]->initCell($column, $value, $status);
    }

    /**
     * Allows to get value of specified cell in matrix.
     * @param integer $line Cell's line in matrix we want to get value.
     * @param integer $column Cell's column in matrix we want to get value.
     * @return Value of specified cell (NULL if no value).
     */
    public function getValue($line, $column) {
        return $this->lineList[$line]->getCell($column)->getValue();
    }

    /**
     * Allows to get status of specified cell in matrix.
     * @param integer $line Cell's line in matrix we want to get value.
     * @param integer $column Cell's column in matrix we want to get value.
     * @return Status of specified cell.
     */
    public function getStatus($line, $column) {
        return $this->lineList[$line]->getCell($column)->getStatus();
    }

    public function getBlockSize() {
        return $this->blockSize;
    }
    public function setBlockSize($blockSize) {
        $this->blockSize = $blockSize;
        return $this;
    }
    public function getLineList() {
        return $this->lineList;
    }
    public function setLineList($lineList) {
        $this->lineList = $lineList;
        return $this;
    }

    private function initLine($blockSize) {

        $fullSize = $blockSize * $blockSize;

        for ($i = 0; $i < $fullSize; $i++)
            $this->lineList[$i] = new SudokuLineForm();

    }
}
