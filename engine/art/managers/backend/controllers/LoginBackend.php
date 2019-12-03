<?php

// app/Http/Controllers/MongoController.php

namespace managers\backend\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use \Symfony\Component\HttpFoundation\Request;

class LoginBackend extends \managers\backend\AdminController {

    public function actionIndex() {


        $data = array();
        return $this->render("login", $data);
    }

    public function actionDoit(Request $request) {

        $admin_login = \core\ManagerConf::get("admin_login");
        $admin_password = \core\ManagerConf::get("admin_password");

        $result = \admins\models\AdminAuth::check();

        if ($result) {

            return redirect(route("backend/index"));
        } else {
            \core\Notify::add(__("backend/main.incorrect_l_p"), "error");
        }

        return redirect(route("backend/login/index"));
        //Or, you can throw an exception here.
    }

    public function render($file, $data = array()) {

        $islogin = false;
        $data = array();
        $data['_admin_url'] = \core\ManagerConf::getUrl() . "/";
        $data['flash_success'] = \core\Notify::get("success");
        $data['flash_error'] = \core\Notify::get("error");
        $data['current_lang'] = \languages\models\LanguageHelp::get();
        $data['languages'] = \languages\models\LanguageHelp::getAll("backend");
        $data['pwa_meta'] = \managers\backend\models\AdminPwa::generate();
        $result = view("app::login", $data)->render();
        $result = $this->_after_render($result);
        return $result;
    }

}
