<?php

namespace Tests\Unit\backend\logs\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class LogsModelTest extends TestCase {

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

    public function testGetAllchannels() {
        \logs\models\LogsModel::getAllchannels();
    }

    public function testGetAllLevels() {
        \logs\models\LogsModel::getAllLevels();
    }

    public function testAdd() {
        $post = array();
        $post['channel'] = "daily";
        $post['level'] = "critical";


        $response = $this->withSession($this->session)->post(route("backend/index"), $post);

        $result = \logs\models\LogsModel::add();

        $this->withSession($this->session)->get(route("backend/logs/delete", array('val_0' => $result->id)));
    }

    public function testUpdate() {
        $post = array();
        $post['channel'] = "daily";
        $post['level'] = "critical";


        $response = $this->withSession($this->session)->post(route("backend/index"), $post);

        $result = \logs\models\LogsModel::add();

        \logs\models\LogsModel::update($result);

        $this->withSession($this->session)->get(route("backend/logs/delete", array('val_0' => $result->id)));
    }

}
