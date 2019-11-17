<?php

namespace blocks\models;

use plugsystem\GlobalParams;

abstract class AbstractBlock {

    protected $op = null;
    protected $value = null;
    protected $params = null;
    protected $old_params = array();
    private $error = null;
    public $block = array();

    public function __construct($op, $value, $params = array(), $block = array()) {

        $this->op = $op;

        $this->value = $value;

        $this->params = $params;

        $this->block = $block;
    }

    public function setOldParams($old_params) {
        $this->old_params = $old_params;
    }

    public function addError($title) {
        $this->error = $title;
    }

    public function isError() {
        if (!is_null($this->error)) {
            return true;
        }
        return false;
    }

    public function success() {

        return $this->params;
    }

    public function needCache() {
        return true;
    }

    public function getError() {
        return $this->error;
    }

    public function show($type) {
        $result = "";
        if ($type == "edit") {
            $result = $this->editPage();
        } else {
            $result = $this->addPage();
        }
        $result = str_replace("{param}", "param", $result);
        return $result;
    }

    abstract public function addPage();

    abstract public function validate();

    abstract public function editPage();

    abstract public function run();
}
