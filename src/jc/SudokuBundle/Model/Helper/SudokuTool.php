<?php

namespace jc\SudokuBundle\Model\Helper;

use jc\SudokuBundle\Model\SudokuCell;

/**
 * This class contains usefull methods to process SudokuCell array.
 * @author JC
 */
class SudokuTool{

    /**
     * Allows to remove sudoku cell from specified list
     * @param SudokuCell $cellToRemove
     * @param array $cellList SudokuCell[]
     */
    public static function removeSudokuCellFromList(SudokuCell $cellToRemove, &$cellList) {

        foreach ($cellList as $index => $cell) {

            if ($cellToRemove->isSameCell($cell))
                unset($cellList[$index]);
        }
    }

    /**
     * Allows to remove sudoku cell from specified list
     * @param array $cellToRemove[]
     * @param array $cellList SudokuCell[]
     */
    public static function removeSudokuCellListFromList($cellsToRemove, &$cellList) {

        foreach ($cellsToRemove as $cellToRemove)
            self::removeSudokuCellFromList($cellToRemove, $cellList);
    }

    /**
     * Allows to build default authorized values list (depending on sudoku size).
     * @param integer $count Number of values allowed for cell (depends on block size).
     * @return array List of authorized values per default (as integer[]).
     */
    public static function buildDefaultAuthorizedValue($count) {

        // Initialize authorized values
        $authorizedValue = array();

        for ($i = 1; $i <= $count; $i++)
            $authorizedValue[] = $i;

        return $authorizedValue;
    }
}
