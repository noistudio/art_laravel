<?php

namespace Tests\Unit\backend\mg;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class MongoDocumentTest extends TestCase {

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

    public function test_object() {
        if (class_exists("\\mg\\config")) {
            \mg\MongoDocument::object();
        }
    }

    public function test_manipulate() {
        if (class_exists("\\mg\\config")) {
            $array_1_test = array('title' => 'title1');
            $key = \mg\MongoDocument::insert($array_1_test, "param1");
            \mg\MongoDocument::get("param1", $key);

            \mg\MongoDocument::one("param1", "title", "title1");
            $array_1_test = array('title' => 'title3', 'ttt' => 'bbb');
            \mg\MongoDocument::update($array_1_test, "param1", $key);


            \mg\MongoDocument::update($array_1_test, "param2", 0);
            \mg\MongoDocument::delete('param1', $key);
            \mg\MongoDocument::delete('param2', 0);



            $array_1_test = array('title' => 'title1');
            $key = \mg\MongoDocument::insert($array_1_test, "param1", true, 0);
            \mg\MongoDocument::get("param1", $key);

            \mg\MongoDocument::one("param1", "title", "title1");
            $array_1_test = array('title' => 'title3', 'ttt' => 'bbb');
            \mg\MongoDocument::update($array_1_test, "param1", $key);


            \mg\MongoDocument::update($array_1_test, "param2", 0);
            \mg\MongoDocument::delete('param1', $key);
            \mg\MongoDocument::delete('param2', 0);
        }
    }

}
