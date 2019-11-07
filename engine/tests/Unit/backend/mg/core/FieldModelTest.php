<?php

namespace Tests\Unit\backend\mg\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FieldModelTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $model = null;

    public function setUp(): void {
        parent::setUp();
        if (class_exists("\\mg\\config")) {
            \core\AppConfig::set("app.current_manager", "backend");
            $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
            $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
            $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
            $this->model = new \mg\core\FieldModel("test", "test", array(), "Stroka");
        }
    }

    public function test_setup() {
        if (class_exists("\\mg\\config")) {
            $this->model->setup();
        }
    }

}
