<?php

namespace jc\SudokuBundle\Model;

use jc\SudokuBundle\Model\Helper\SudokuForm;
/**
 * Allows to define sudoku grid as matrix of SudokuCell.
 * NOTE : Default size for sudoku is 9X9 (classical sudoku). 
 * @author JC
 */
class SudokuGrid {

    private $sudokuGrid;    // SudokuCell[][]
    private $blockSize;     // integer
    private $fullSize;      // integer

    /**
     * Default constructor that allows to initialize sudoku from form.<br/>
     * NOTE : It also initialize authorized values for empty cell.<br/>
     * @param SudokuForm $sudokuForm Sudoku form containing values to use to initialize sudoku grid.
     */
    public function __construct(SudokuForm $sudokuForm) {

        $this->blockSize = $sudokuForm->getBlockSize();
        $this->fullSize = $this->blockSize * $this->blockSize;

        $this->sudokuGrid = array();

        // Browse all cells and initialize them
        for ($i = 0; $i < $this->fullSize; $i++)
            for ($j = 0; $j < $this->fullSize; $j++)
                $this->sudokuGrid[$i][$j] = new SudokuCell($i, $j, $sudokuForm->getValue($i, $j), $sudokuForm->getStatus($i, $j), $this->blockSize);
    }

    /**
     * @param integer $line
     * @param integer $column
     * @return SudokuCell
     */
    public function getCell($line, $column) {
        return $this->sudokuGrid[$line][$column];
    }
    /**
     * @return SudokuCell[][]
     */
    public function getSudokuGrid() {
        return $this->sudokuGrid;
    }
    public function getBlockSize() {
        return $this->blockSize;
    }
    public function getFullSize() {
        return $this->fullSize;
    }

    /**
     * Allows to get cells list matching specified line.
     * @param integer $index Index of line we want to get cells.
     * @param boolean $withValue TRUE to get only cells that define value, FALSE to get only cells that doesn't define value, NULL to get all cells.
     * @return array List of cells for specified line (as SudokuCell[]).
     */
    public function getLine($index, $withValue) {

        $line = array();

        for ($i = 0; $i < $this->fullSize; $i++) {

            $cell = $this->sudokuGrid[$index][$i];

            if ($withValue === null || $withValue == $cell->hasValue())
                $line[] = $this->sudokuGrid[$index][$i];
        }

        return $line;
    }

    /**
     * Allows to get cells list matching specified column.
     * @param integer $index Index of column we want to get cells.
     * @param boolean $withValue TRUE to get only cells that define value, FALSE to get only cells that doesn't define value, NULL to get all cells.
     * @return array List of cells for specified column (as SudokuCell[]).
     */
    public function getColumn($index, $withValue) {

        $column = array();

        for ($i = 0; $i < $this->fullSize; $i++) {

            $cell = $this->sudokuGrid[$i][$index];

            if ($withValue === null || $withValue == $cell->hasValue())
                $column[] = $this->sudokuGrid[$i][$index];
        }

        return $column;
    }

    /**
     * Allows to get cells list matching specified block.
     * NOTE : Block are defined from left to right and top to bottom.
     * @param integer $index Index of block we want to get cells.
     * @param boolean $withValue TRUE to get only cells that define value, FALSE to get only cells that doesn't define value, NULL to get all cells.
     * @return array List of cells for specified block (as SudokuCell[]).
     */
    public function getBlock($index, $withValue) {

        $block = array();

        $lineStartIndex = (int)($index / $this->blockSize) * $this->blockSize;
        $columnStartIndex = ($index % $this->blockSize) * $this->blockSize;

        for ($i = $lineStartIndex; $i < $lineStartIndex + $this->blockSize; $i++) {

            for ($j = $columnStartIndex; $j < $columnStartIndex + $this->blockSize; $j++) {

                if ($i > 8 || $j > 8 || $i < 0 || $j < 0)
                    echo 'out of index [' . $index . '] => ' . $i . ' // ' . $j . '<br/>';
                $cell = $this->sudokuGrid[$i][$j];

                if ($withValue === null || $withValue == $cell->hasValue())
                    $block[] = $this->sudokuGrid[$i][$j];
            }
        }

        return $block;
    }

    /**
     * Allows to get all sudoku's cells as flat list.<br/>
     * NOTE : Cells are defined from left to right and top to bottom.
     * @param boolean $withValue TRUE to get only cells that define value, FALSE to get only cells that doesn't define value, NULL to get all cells.
     * @return array List of all cells (as SudokuCell[]).
     */
    public function getAll($withValue) {

        $cellList = array();

        for ($i = 0; $i < $this->fullSize; $i++) {

            for ($j = 0; $j < $this->fullSize; $j++) {

                $cell = $this->sudokuGrid[$i][$j];

                if ($withValue === null || $withValue == $cell->hasValue())
                    $cellList[] = $this->sudokuGrid[$i][$j];
            }
        }

        return $cellList;
    }
}
