<?php

namespace builder\models;

use mg\core\RowModel;
use blocks\models\AbstractBlock;
use plugsystem\GlobalParams;

class Block extends AbstractBlock {

    public function __construct($op, $value, $params = array(), $block = array()) {

        parent::__construct($op, $value, $params, $block);
    }

    public function run() {
        $controller = new \builder\controllers\frontend\Builder();
        if (!isset($this->params['postfix_template'])) {
            $this->params['postfix_template'] = "";
        }
        $postfix_template = $this->params['postfix_template'];
        return $controller->actionIndex($this->op);
    }

    public function editPage() {


        return "";
    }

    public function validate() {
        return "";
    }

    public function addPage() {
        return "";
    }

}
