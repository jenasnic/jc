<?php

namespace jc\TestBundle\Model;

class SimpleForm {

    private $code;
    private $label;
    private $value;

    public function __construct($code=null, $label=null, $value=null) {

        $this->code = $code;
        $this->label = $label;
        $this->value = $value;
    }

    public function getCode() {
        return $this->code;
    }
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }
    public function getLabel() {
        return $this->label;
    }
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }
    public function getValue() {
        return $this->value;
    }
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
}
