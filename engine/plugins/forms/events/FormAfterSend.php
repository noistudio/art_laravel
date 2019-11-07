<?php

namespace forms\events;

use Illuminate\Queue\SerializesModels;

class FormAfterSend extends \core\AbstractEvent {

    use SerializesModels;

    private $results = array();
    public $form = null;
    public $result = null;

    public function __construct($form, $result) {

        $this->form = $form;
        $this->result = $result;
    }

}
