<?php

namespace Tests\Unit\backend\mg\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class DynamicCollectionTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $name_collection = "phpunit";
    public $model = null;

    public function setUp(): void {
        parent::setUp();
        if (class_exists("\\mg\\config")) {
            \core\AppConfig::set("app.current_manager", "backend");
            $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
            $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
            $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);

            $post = array();
            $post['name'] = $this->name_collection;
            $post['title'] = $this->name_collection;
            $post['count'] = 20;
            $post['fields'] = array(
                array(
                    'type' => 'Stroka',
                    'name' => 'title',
                    'title' => 'title',
                    'showinlist' => 1,
                )
            );



            $result = $this->withSession($this->session)->post(route("backend/mg/collections/ajaxadd"), $post)->decodeResponseJson();
            if (!(isset($result['type']) and $result['type'] == "success")) {
                $this->fail("Ответ должен быть success");
            }

            $this->model = \mg\core\DynamicCollection::find($this->name_collection);
        }
    }

    public function tearDown(): void {

        if (class_exists("\\mg\\config")) {
            $this->withSession($this->session)->get(route("backend/mg/collections/delete", array("val_0" => $this->name_collection)));

            \mg\MongoQuery::delete($this->name_collection, array());
        }
    }

    public function testCondition() {
        if (class_exists("\\mg\\config")) {
            $this->model->condition(array('enable' => 1));
        }
    }

    public function testAll() {
        if (class_exists("\\mg\\config")) {
            $this->model->all();
        }
    }

    public function test_insert() {
        if (class_exists("\\mg\\config")) {
            $array = array('last_id' => 9, 'title' => 'title1');
            $this->model->_insert($array);
            \mg\MongoQuery::delete("phpunit", array('last_id' => $array['last_id']));
        }
    }

    public function test__update() {
        if (class_exists("\\mg\\config")) {
            $array = array('last_id' => 9, 'title' => 'title1');
            \mg\MongoQuery::update(array('title' => 'title2'), "phpunit", array('last_id' => 9));
            \mg\MongoQuery::delete("phpunit", array('last_id' => $array['last_id']));
        }
    }

    public function test_parse() {
        if (class_exists("\\mg\\config")) {
            $this->model->parse(array());
        }
    }

    public function test_getFieldsinList() {
        if (class_exists("\\mg\\config")) {
            $this->model->getFieldsinList();
        }
    }

    public function test_offset() {
        if (class_exists("\\mg\\config")) {
            $this->model->offset(10);
        }
    }

    public function test_limit() {
        if (class_exists("\\mg\\config")) {
            $this->model->limit(10);
        }
    }

    public function test_getCollection() {
        if (class_exists("\\mg\\config")) {
            $this->model->getCollection();
        }
    }

}
