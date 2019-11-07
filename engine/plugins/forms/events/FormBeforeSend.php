<?php

namespace forms\events;

use Illuminate\Queue\SerializesModels;

class FormBeforeSend extends \core\AbstractEvent {

    use SerializesModels;

    private $results = array();
    public $form = null;
    public $result = null;

    public function __construct($form, $result) {

        $this->form = $form;
        $this->result = $result;
    }

    public function addError($error, $field_error) {
        $result = array();
        $result['error'] = $error;
        $result['field'] = $field_error;


        $this->set($result);

        return true;
    }

}
