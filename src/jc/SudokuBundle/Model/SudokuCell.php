<?php

namespace jc\SudokuBundle\Model;

use jc\SudokuBundle\Model\Helper\SudokuTool;
/**
 * Allows to define sudoku cell. It contains basic coordonnates (line/column), block number (starting 1 and incrementing from left to right and up to down).<br/>
 * Sudoku cell contains also a list of authorized values (updated when trying to resolve cell) and a value if cell has been resolved.<br/>
 * NOTE : If cell is not resolved, value is null.
 * @author JC
 */
class SudokuCell {

    private $line;      // integer
    private $column;    // integer
    private $block;     // integer

    private $status;    // SudokuStatus

    private $value;             // integer
    private $authorizedValue;   // integer[]

    public function __construct($line, $column, $value, $status, $blockSize) {

        $this->line = $line;
        $this->column = $column;

        $this->value = $value;
        $authorizedValue = array();

        $this->status = $status;

        $this->block = 0;
        $this->block += (int)($this->line / $blockSize) * $blockSize;
        $this->block += (int)($this->column / $blockSize);

        // For empty cell => initialize authorized values (with all existing values for sudoku's size)
        if ($value == null ||$value == 0)
            $this->authorizedValue = SudokuTool::buildDefaultAuthorizedValue($blockSize * $blockSize);
    }

    /**
     * @return integer Index of line in full sudoku grid for cell.
     */
    public function getLine() {
        return $this->line;
    }
    /**
     * @return integer Index of column in full sudoku grid for cell.
     */
    public function getColumn() {
        return $this->column;
    }
    /**
     * @return integer index of block in full sudoku grid for cell (block index starts to 1 and increments from left to right and up to down)
     */
    public function getBlock() {
        return $this->block;
    }

    /**
     * @return integer Value of current cell. 0 if cell is not yet resolved.
     */
    public function getValue() {
        return $this->value;
    }
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * @return array List of authorized values (as integer[]) for cell.
     */
    public function getAuthorizedValue() {
        return $this->authorizedValue;
    }
    public function setAuthorizedValue(array $authorizedValue) {
        $this->authorizedValue = $authorizedValue;
    }

    /**
     * @return SudokuStatus Status of cell.
     */
    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return boolean TRUE if cell is resolved (defined value), FALSE either.
     */
    public function hasValue() {
        return ($this->value != null) && ($this->value > 0);
    }

    /**
     * Allows to know if specified cell match current cell (same position).<br/>
     * NOTE : Value of cells are not taken into account (only position).
     * @param SudokuCell $sudokuCell Cell we want to compare with current cell.
     * @return boolean TRUE if cells are on same place in grid, FALSE either.
     */
    public function isSameCell(SudokuCell $sudokuCell) {
        return ($sudokuCell->line == $this->line && $sudokuCell->column == $this->column);
    }

    /**
     * Allows to remove specified value from authorized value.<br/>
     * NOTE : This method is used when trying to resolve sudoku through SudokuResolverService.
     * @param integer $value Value to remove from authorized value.
     */
    public function removeAuthorizedValue($value) {

        $index = array_search($value, $this->authorizedValue);

        if ($index !== false)
            unset($this->authorizedValue[$index]);
    }

    /**
     * Allows to remove specified value list from authorized value.<br/>
     * NOTE : This method is used when trying to resolve sudoku through SudokuResolverService.
     * @param array $valueList Values to remove from authorized value (as integer[]).
     */
    public function removeAuthorizedValueList($valueList) {

        foreach ($valueList as $value)
            $this->removeAuthorizedValue($value);
    }
}
