<?php

namespace jc\SudokuBundle\Service;

use jc\SudokuBundle\Model\SudokuGrid;
use jc\SudokuBundle\Model\SudokuCell;
use jc\SudokuBundle\Model\SudokuLink;
use jc\SudokuBundle\Model\Helper\SudokuTool;
use jc\SudokuBundle\Model\SudokuStatus;

class SudokuResolverService {

    const SIMPLE_LEVEL = 1;
    const LINKED_LEVEL = 2;
    const SINGLE_LEVEL = 3;
    const BLOCK_SINGLE_LEVEL = 4;

    /**
     * Allows to find authorized values for a cell looking for existing value on same line, same column and in same block.
     * @param SudokuGrid $sudoku Sudoku to resolve.
     * @return array List of resolved cells (as SudokuCell[]).
     */
    public function resolveSimpleValues(SudokuGrid $sudoku) {

        $resolvedCellList = array();    // SudokuCell[]

        // Browse all cell to remove authorized values defined on same line, same column or in same block
        // NOTE : Get only cells that are not already resolved
        $cellList = $sudoku->getAll(false);
        foreach ($cellList as $cellToProcess) {

            // Remove resolved value on line
            $lineCellList = $sudoku->getLine($cellToProcess->getLine(), true);
            foreach ($lineCellList as $cell)
                $cellToProcess->removeAuthorizedValue($cell->getValue());

            // Remove resolved value on column
            $columnCellList = $sudoku->getColumn($cellToProcess->getColumn(), true);
            foreach ($columnCellList as $cell)
                $cellToProcess->removeAuthorizedValue($cell->getValue());

            // Remove resolved value in block
            $blockCellList = $sudoku->getBlock($cellToProcess->getBlock(), true);
            foreach ($blockCellList as $cell)
                $cellToProcess->removeAuthorizedValue($cell->getValue());

            // If we have found unique authorized value => cell is resolved
            if (count($cellToProcess->getAuthorizedValue()) == 1) {

                $cellToProcess->setValue(array_values($cellToProcess->getAuthorizedValue())[0]);
                $cellToProcess->setStatus(SudokuStatus::RESOLVED);
                $resolvedCellList[] = $cellToProcess;
            }
        }

        return $resolvedCellList;
    }

    /**
     * Allows to find authorized values for a cell taken into account couple of values on same line, same column and in same block.
     * @param SudokuGrid $sudoku Sudoku to resolve.
     * @param integer $range Range to use to make association (2 => couple of values, 3 => triple of values).
     * @return array List of sudoku cell we have found unique value (as SudokuCell[]).
     */
    public function resolveLinkedValues(SudokuGrid $sudoku, $range) {

        $resolvedCellList = array();    // SudokuCell[]

        // Browse all cell to find linked on same line, same column or in same block and remove them from authorized values
        // NOTE : Get only cells that are not already resolved
        $cellList = $sudoku->getAll(false);
        foreach ($cellList as $cellToProcess) {

            $this->removeLinkedValuesForCell($cellToProcess, $sudoku->getLine($cellToProcess->getLine(), false), $range);
            $this->removeLinkedValuesForCell($cellToProcess, $sudoku->getColumn($cellToProcess->getColumn(), false), $range);
            $this->removeLinkedValuesForCell($cellToProcess, $sudoku->getBlock($cellToProcess->getBlock(), false), $range);

            // If we have found unique authorized value => cell is resolved
            if (count($cellToProcess->getAuthorizedValue()) == 1) {

                $cellToProcess->setValue(array_values($cellToProcess->getAuthorizedValue())[0]);
                $cellToProcess->setStatus(SudokuStatus::RESOLVED);
                $resolvedCellList[] = $cellToProcess;
            }
        }

        return $resolvedCellList;
    }

    /**
     * Allows to find authorized values that are defined once on same line, same column or in same block.
     * @param SudokuGrid $sudoku Sudoku to resolve.
     * @return array List of sudoku cell we have found unique value (as SudokuCell[]).
     */
    public function resolveSingleValue(SudokuGrid $sudoku) {

        $resolvedCellList = array();    // SudokuCell[]

        // Browse all cell to find authorized values defined once on same line, same column or in same block and keep it as single authorized value
        // NOTE : Get only cells that are not already resolved
        $cellList = $sudoku->getAll(false);
        foreach ($cellList as $cellToProcess) {

            $this->keepSingleValueForCell($cellToProcess, $sudoku->getLine($cellToProcess->getLine(), false));
            $this->keepSingleValueForCell($cellToProcess, $sudoku->getColumn($cellToProcess->getColumn(), false));
            $this->keepSingleValueForCell($cellToProcess, $sudoku->getBlock($cellToProcess->getBlock(), false));

            // If we have found unique authorized value => cell is resolved
            if (count($cellToProcess->getAuthorizedValue()) == 1) {

                $cellToProcess->setValue(array_values($cellToProcess->getAuthorizedValue())[0]);
                $cellToProcess->setStatus(SudokuStatus::RESOLVED);
                $resolvedCellList[] = $cellToProcess;
            }
        }

        return $resolvedCellList;
    }

    /**
     * Allows to update authorized values on line/column depending on authorized values that are defined for once line/column in a block.
     * @param SudokuGrid $sudoku Sudoku to resolve.
     * @return array List of sudoku cell we have found unique value (as SudokuCell[]).
     */
    public function resolveBlockSingleValue(SudokuGrid $sudoku) {

        $resolvedCellList = array();    // SudokuCell[]

        // Browse all blocks to find value inside block that are unique inside block's line/column
        // In this case, remove this value from other cells on same line/column and in other blocks
        for ($i = 0; $i < $sudoku->getFullSize(); $i++) {

            $unresolvedBlockCellList = $sudoku->getBlock($i, false);

            $this->removeSingleValueFromBlock($unresolvedBlockCellList, $sudoku);

            foreach ($unresolvedBlockCellList as $unresolvedBlockCell) {

                // If we have found unique authorized value => cell is resolved
                if (count($unresolvedBlockCell->getAuthorizedValue()) == 1) {

                    $cellToProcess->setValue(array_values($cellToProcess->getAuthorizedValue())[0]);
                    $cellToProcess->setStatus(SudokuStatus::RESOLVED);
                    $resolvedCellList[] = $unresolvedBlockCell;
                }
            }
        }

        return $resolvedCellList;
    }

    /**
     * Allows to know if specified sudoku is resolved or not (all cells filled + unique value on each line/column/block).
     * @param SudokuGrid $sudoku Sudoku to check.
     * @return boolean TRUE if sudoku is resolved, FALSE either.
     */
    public function isResolved(SudokuGrid $sudoku) {

        // Check all sudoku lines
        for ($i = 0; $i < $sudoku->getFullSize(); $i++) {
            if ($this->checkResolvedCellList($sudoku->getLine($i, true), $sudoku->getFullSize()))
                return false;
        }

        // Check all sudoku columns
        for ($i = 0; $i < $sudoku->getFullSize(); $i++) {
            if ($this->checkResolvedCellList($sudoku->getColumn($i, true), $sudoku->getFullSize()))
                return false;
        }

        // Check all sudoku blocks
        for ($i = 0; $i < $sudoku->getFullSize(); $i++) {
            if ($this->checkResolvedCellList($sudoku->getBlock($i, true), $sudoku->getFullSize()))
                return false;
        }

        return true;
    }

    /**
     * Allows to find linked values in specified cells list and remove them from specified cell.
     * @param SudokuCell $cellToProcess Cell we want to fix authorized values.
     * @param array $unresolvedCellList List of cells used to find linked values in authorized values (as SudokuCell[]).
     * @param integer $range Number of values to take into account to link values (should be less than sudoku's size).
     */
    private function removeLinkedValuesForCell(SudokuCell $cellToProcess, $unresolvedCellList, $range) {

        $linkableCellList = array();    // SudokuCell[]

        // Keep only cells that can be linked each other
        foreach ($unresolvedCellList as $cell) {

            if (!$cell->isSameCell($cellToProcess) && count($cell->getAuthorizedValue()) <= $range)
                $linkableCellList[]= $cell;
        }

        $linkSize = count($linkableCellList);

        // If not enough cells to find linked values => stop here
        if ($linkSize < $range)
            return;

        for ($i = 0; $i < $linkSize - 1; $i++) {

            $linkManager = new SudokuLink();

            // Browse remaining cell to link values
            for ($j = $i + 1; $j < $linkSize; $j++) {

                $linkedValues = array_unique(array_merge($linkableCellList[$i]->getAuthorizedValue(), $linkableCellList[$j]->getAuthorizedValue()));    // integer[]

                // If authorized values are matching => link them
                if (count($linkedValues) == $range)
                    $linkManager->add($linkedValues);
            }

            // If linked values found => remove them from cell to process
            $linkedValues = $linkManager->getLinkedValuesForRange($range);
            if ($linkedValues != null)
                $cellToProcess->removeAuthorizedValueList($linkedValues);
        }
    }

    /**
     * Allows to check if one authorized value for specified cell doesn't appear in specified cells list.
     * In this case, we keep this unique value as authorized value (=> remove all other authorized values).
     * @param SudokuCell $cellToProcess Cell we want to fix authorized values.
     * @param array $unresolvedCellList List of cells used to find linked values in authorized values (as SudokuCell[]).
     */
    private function keepSingleValueForCell(SudokuCell $cellToProcess, $unresolvedCellList) {

        // Remove cell to process from cell list (authorized values for current cell must not be taken into account)
        SudokuTool::removeSudokuCellFromList($cellToProcess, $unresolvedCellList);

        // Browse all authorized values for cell to process
        foreach ($cellToProcess->getAuthorizedValue() as $value) {

            $uniqueValue = true;

            foreach ($unresolvedCellList as $cell) {

                if (in_array($value, $cell->getAuthorizedValue())) {

                    $uniqueValue = false;
                    break;
                }
            }

            // If value is unique on line => keep only this value as authorized value + stop here
            if ($uniqueValue) {

                $cellToProcess->setAuthorizedValue(array($value));
                break;
            }
        }
    }

    /**
     * Allows to check if one authorized value is defined on once line/column in cell's block.
     * In this case, we remove this value from cell defined in other blocks and on same line/column.
     * @param array $unresolvedBlockCellList Block cells used to find single value on once line/column in block (as SudokuCell[]).
     * @param SudokuGrid $sudoku Full sudoku grid containing cell to process.
     */
    private function removeSingleValueFromBlock(array $unresolvedBlockCellList, SudokuGrid $sudoku) {

        foreach ($unresolvedBlockCellList as $cellToProcess) {

            // Browse all authorized values for cell to process
            foreach ($cellToProcess->getAuthorizedValue() as $value) {

                $uniqueLineValue = true;
                $uniqueColumnValue = true;

                // Check if value is unique inside block's line/column
                foreach ($unresolvedBlockCellList as $blockCell) {

                    if (!$blockCell->isSameCell($cellToProcess) && in_array($value, $blockCell->getAuthorizedValue())) {

                        if ($uniqueLineValue && $blockCell->getLine() != $cellToProcess->getLine())
                            $uniqueLineValue = false;
                        if ($uniqueColumnValue && $blockCell->getColumn() != $cellToProcess->getColumn())
                            $uniqueColumnValue = false;
                    }
                }

                // If value is unique in block's line => remove this value from other line's cell (in other blocks)
                if ($uniqueLineValue) {

                    // Get all cells on same line that doesn't belongs to current cell's block
                    $otherLineCellList = $sudoku->getLine($cellToProcess->getLine(), false);        // SudokuCell[]
                    SudokuTool::removeSudokuCellListFromList($unresolvedBlockCellList, $otherLineCellList);

                    foreach ($otherLineCellList as $otherLineCell)
                        $otherLineCell->removeAuthorizedValue($value);
                }

                // If value is unique in block's column => remove this value from other column's cell (in other blocks)
                if ($uniqueColumnValue) {

                    // Get all cells on same line that doesn't belongs to current cell's block
                    $otherColumnCellList = $sudoku->getColumn($cellToProcess->getColumn(), false);      // SudokuCell[]
                    SudokuTool::removeSudokuCellListFromList($unresolvedBlockCellList, $otherColumnCellList);

                    foreach ($otherColumnCellList as $otherColumnCell)
                        $otherColumnCell->removeAuthorizedValue($value);
                }
            }
        }
    }

    /**
     * Allows to check if specified cell list matches sudoku size and contains unique value.<br/>
     * NOTE : This method is used to check if sudoku is resolved or not.
     * @param array $cellList List of cells we want to check values (as SudokuCell[].
     * @param integer $sudokuFullSize Size of sudoku to check cell values (number of values + unicity)
     * @return boolean TRUE if cell list is valid for resolution, FALSE either (missing value, duplicate value...).
     */
    private function checkResolvedCellList($cellList, $sudokuFullSize) {

        if (count($cellList) != $sudokuFullSize)
            return false;

        $foundValueList = array();      // integer[]
        foreach ($cellList as $cell) {

            if (in_array($cell->getValue(), $foundValueList))
                return false;

            $foundValueList[] = $cell.getValue();
        }

        return true;
    }
}
