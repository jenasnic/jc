<?php

namespace jc\SudokuBundle\Model;

/**
 * Allows to define possible status for sudoku cell (initial value, resolved value, found value...).
 * @author JC
 */
class SudokuStatus {

    const UNRESOLVED = 0;
    const INITIAL = 1;
    const FOUND = 2;
    const RESOLVED = 3;
}
