<?php

namespace forms\controllers\frontend;

use forms\models\ContactModel;
use forms\models\ApplicationModel;

class Forms extends \managers\frontend\Controller {

    public function actionIndex() {
        
    }

    public function send($id) {

        $form = \forms\models\FormConfig::get($id);
        if (is_array($form)) {


            $result = \forms\models\FormModel::send($form);
            $json = array('type' => 'success');

            if (!$result) {
                $error = \core\Notify::get("error");
                if (isset($error)) {
                    $json = array('type' => 'error', 'message' => $error);
                }
            }
            if ($json['type'] == "success") {
                $json['message'] = __("frontend/forms.success_msg");
            }
            return $json;
        }
        return array();
    }

}
