<?php

namespace forms\controllers\frontend;

use forms\models\ContactModel;
use forms\models\ApplicationModel;

class Forms extends \managers\frontend\Controller {

    public function actionIndex() {
        
    }

    public function actionSend($id) {
        \plugsystem\GlobalParams::set("isajax", true);
        $form = \forms\models\FormConfig::get($id);
        if (is_array($form)) {
            \plugsystem\GlobalParams::get("isajax", true);

            $result = \forms\models\FormModel::send($form);
            $json = array('type' => 'success');

            if (!$result) {
                $error = \core\Notify::get("error");
                if (isset($error)) {
                    $json = array('type' => 'error', 'message' => $error);
                }
                $rows = \plugsystem\models\NotifyModel::getAll();
            }
            if ($json['type'] == "success") {
                $json['message'] = "Сообщение успешно отправлено!";
            }
            return $json;
        }
    }

}
