<?php

namespace Tests\Unit\backend\mg;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class MongoHelperTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;

    public function setUp(): void {
        parent::setUp();
        if (class_exists("\\mg\\config")) {
            \core\AppConfig::set("app.current_manager", "backend");
            $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
            $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
            $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
        }
    }

    public function testDate() {
        if (class_exists("\\mg\\config")) {
            \mg\MongoHelper::date(time());
        }
    }

    public function test_time() {
        if (class_exists("\\mg\\config")) {

            $date = \mg\MongoHelper::date(time());

            \mg\MongoHelper::time($date);
        }
    }

    public function test_format() {
        if (class_exists("\\mg\\config")) {
            $date = \mg\MongoHelper::date(time());

            \mg\MongoHelper::format("Y-m-d", $date);
        }
    }

    public function test_Id() {
        if (class_exists("\\mg\\config")) {


            \mg\MongoHelper::id();
        }
    }

}
