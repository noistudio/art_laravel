<?php

namespace Tests\Unit\backend\routes\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class RoutesModelTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;

    public function setUp(): void {
        parent::setUp();

        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
    }

    public function test_ajaxUpdate_DoAdd_Get() {

        $post = array();
        $post['old_link'] = "/phpunit";
        $post['new_link'] = "/phpunit2";
        $post['meta_title'] = "title1";
        $post['meta_description'] = "description1";
        $post['meta_keywords'] = "keywords1";
        $this->withSession($this->session)->post(route("backend/index"), $post);
        $result = \routes\models\RoutesModel::doAdd();
        if (!$result) {
            $this->fail("Ответ должен быть true");
        }

        $route = \routes\models\RoutesModel::get("/phpunit");
        if (!(isset($route['id']))) {
            $this->fail("В ответе должен быть ключ id");
        }

        \routes\models\RoutesModel::ajaxUpdate($route);

        $update = \db\JsonQuery::get((int) $route['id'], "routes", "id");

        \routes\models\RoutesModel::isExists("/phpunit2", "old_url", $update);

        $this->withSession($this->session)->get(route("backend/routes/delete", array("val_0" => $route['id'])));
    }

}
