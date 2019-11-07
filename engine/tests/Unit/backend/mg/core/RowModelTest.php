<?php

namespace Tests\Unit\backend\mg\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class RowModelTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $name_collection = "phpunit";
    public $model = null;
    public $row = null;

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

            $row = array('title' => 'title');

            $this->row = \mg\MongoQuery::insert($row, $this->name_collection);


            $this->model = \mg\core\DynamicCollection::find($this->name_collection);
        }
    }

    public function tearDown(): void {
        if (class_exists("\\mg\\config")) {

            $this->withSession($this->session)->get(route("backend/mg/collections/delete", array("val_0" => $this->name_collection)));


            \mg\MongoQuery::delete($this->name_collection, array());
        }
    }

    public function test_run_multioperations() {
        if (class_exists("\\mg\\config")) {
            $post_params = array();
            $post_params['ids'] = array($this->row['last_id']);
            $post_params['op'] = "enable";
            $this->withSession($this->session)->post(route("backend/index"), $post_params);
            \mg\core\RowModel::run_multioperations($this->name_collection);

            $post_params = array();
            $post_params['ids'] = array($this->row['last_id']);
            $post_params['op'] = "disable";
            $this->withSession($this->session)->post(route("backend/index"), $post_params);
            \mg\core\RowModel::run_multioperations($this->name_collection);

            $post_params = array();
            $post_params['ids'] = array($this->row['last_id']);
            $post_params['op'] = "delete";
            $this->withSession($this->session)->post(route("backend/index"), $post_params);
            \mg\core\RowModel::run_multioperations($this->name_collection);

            $row = array('title' => 'title');

            $this->row = \mg\MongoQuery::insert($row, $this->name_collection);
        }
    }

    public function test_operation_update() {
        if (class_exists("\\mg\\config")) {

            $post_params = array();

            $post_params['title'] = "edited title";
            $this->withSession($this->session)->post(route("backend/index"), $post_params);

            $result = \mg\core\RowModel::operation_update($this->name_collection, $this->row, $this->row['last_id'], "null");
        }
    }

    public function test_operation_add() {
        if (class_exists("\\mg\\config")) {
            $post_params = array();
            $post_params['enable'] = 1;
            $post_params['title'] = "new title";
            $this->withSession($this->session)->post(route("backend/index"), $post_params);

            \mg\core\RowModel::operation_add($this->name_collection, array('enable' => 1, 'title' => 'titlesuper'));
        }
    }

    public function test_editFields() {
        if (class_exists("\\mg\\config")) {
            \mg\core\RowModel::editFields($this->name_collection, $this->row, false, "", "", "null");
        }
    }

    public function test_getArrayRows() {
        if (class_exists("\\mg\\config")) {
            \mg\core\RowModel::getArrayRows($this->name_collection);
        }
    }

}
