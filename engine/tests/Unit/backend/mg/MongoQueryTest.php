<?php

namespace Tests\Unit\backend\mg;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class MongoQueryTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $name_collection = "phpunit";

    public function setUp(): void {
        parent::setUp();
        if (class_exists("\\mg\\config")) {
            \core\AppConfig::set("app.current_manager", "backend");
            $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
            $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
            $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
        }
    }

    public function testCount() {
        if (class_exists("\\mg\\config")) {
            \mg\MongoQuery::count($this->name_collection, array());
        }
    }

    public function testGet() {
        if (class_exists("\\mg\\config")) {
            $array = array();
            $array['title'] = "dsfsdf";
            $array = \mg\MongoQuery::insert($array, $this->name_collection);

            \mg\MongoQuery::get($this->name_collection, array('last_id' => $array['last_id']));
            \mg\MongoQuery::execute($this->name_collection, array('last_id' => $array['last_id']));
            \mg\MongoQuery::execute_one($this->name_collection, array('last_id' => $array['last_id']));
            \mg\MongoQuery::all($this->name_collection, array('last_id' => $array['last_id']));
            \mg\MongoQuery::execute2($this->name_collection, array('last_id' => $array['last_id']));

            \mg\MongoQuery::update(array('title' => 'edited'), $this->name_collection, array('last_id' => $array['last_id']));


            $last_Id = \mg\MongoQuery::getLastId($this->name_collection);
            \mg\MongoQuery::delete($this->name_collection, array('last_id' => $array['last_id']));
        }
    }

}
