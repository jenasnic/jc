<?php

namespace jc\SudokuBundle\Model;

/**
 * This class is used when trying to link cell's values to resolve sudoku grid.<br/>
 * It allows to store and to count linked values list for several cells.
 * @author JC
 */
class SudokuLink {

    private $linkedList;    // Map<String, LinkElement>

    public function __construct() {
        $this->linkedList = array();
    }

    /**
     * Allows to add linked values for element.
     * @param array $linkedValues (as integer[])
     */
    public function add(array $linkedValues) {

        asort($linkedValues);
        $key = implode('-', $linkedValues);

        // If linked list already exist => increment counter
        if (array_key_exists($key, $linkedValues))
            $this->linkedList[key]->incrementCounter();
        else
            $this->linkedList[$key] = new LinkElement($linkedValues);
    }

    /**
     * Allows to get 
     * @param int $range Range of linked value we want to make. Minimum value should be 2 and maximum value should be ("sudoku grid size line/column" - 1).
     * @return array List of linked values found matching specified range (as integer[]), NULL if no linked values found.
     */
    public function getLinkedValuesForRange($range) {

        foreach ($this->linkedList as $key => $value){

            $element = $this->linkedList[$key];
            if ($element->getCount() == $range)
                return $element->getValues();
        }

        return null;
    }
}

class LinkElement {

    private $count;     // integer
    private $values;    // integer[]

    public function __construct(array $values) {

        $this->count = 2;
        $this->values = $values;
    }

    public function getCount() {
        return $this->count;
    }
    public function getValues() {
        return $this->values;
    }

    public function incrementCounter() {
        $this->count++;
    }
}
