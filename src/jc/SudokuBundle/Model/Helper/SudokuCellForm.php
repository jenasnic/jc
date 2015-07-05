<?php

namespace jc\SudokuBundle\Model\Helper;

use jc\SudokuBundle\Model\SudokuStatus;
/**
 * This class allows to define cell for sudoku's line in SudokuLineForm.
 * @see SudokuLineForm
 * @author JC
 */
class SudokuCellForm {

    private $value;     // integer
    private $status;    // SudokuStatus

    public function __construct($value = null, $status = SudokuStatus::UNRESOLVED) {

        $this->value = $value;
        $this->status = $status;
    }

    public function getValue() {
        return $this->value;
    }
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    /**
     * @return SudokuStatus
     */
    public function getStatus() {
        return $this->status;
    }
    /**
     * @param SudokuStatus $status
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
}
