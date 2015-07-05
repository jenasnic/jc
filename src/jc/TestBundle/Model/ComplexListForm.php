<?php

namespace jc\TestBundle\Model;

class ComplexListForm {

    private $title;
    private $elementList;

    public function __construct($title, $elementList) {

        $this->title = $title;
        $this->elementList = $elementList;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    public function getElementList() {
        return $this->elementList;
    }
    public function setElementList($elementList) {
        $this->elementList = $elementList;
        return $this;
    }
}
