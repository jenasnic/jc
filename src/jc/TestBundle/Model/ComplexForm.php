<?php

namespace jc\TestBundle\Model;

class ComplexForm {

    private $title;
    private $element;

    public function __construct($title, $element) {

        $this->title = $title;
        $this->element = $element;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    public function getElement() {
        return $this->element;
    }
    public function setElement($element) {
        $this->element = $element;
        return $this;
    }
}
