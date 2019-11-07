<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;
use content\models\SqlModel;

class SaveBuilder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex() {

        $id = \builder\models\BuilderConf::add();
        if (is_bool($id) and $id == false) {
            return "<p>Произошла ошибка!</p>";
        } else {
            return \core\ManagerConf::link("builder/" . $id);
        }
    }

    public function actionTitle($id) {
        $page = \builder\models\BuilderConf::get($id, false);

        if (is_object($page)) {
            \builder\models\BuilderConf::updateTitle($page);
            NotifyModel::add("Страница успешно сохранена!");
        } else {
            NotifyModel::add("Страница не найдена!");
        }
        back();
    }

    public function actionPage($id) {
        $post = \yii::$app->request->post();

        if (isset($post['localstorage'])) {
            $page = \builder\models\BuilderConf::get($id, false);

            if (is_object($page)) {
                \builder\models\BuilderConf::update($page, $post['localstorage']);
            }
        }
        back();
    }

}
