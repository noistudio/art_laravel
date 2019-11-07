<?php

namespace Tests\Unit\backend\content\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class TableConfigTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $table = "phpunit_mysql";
    public $rows = null;
    public $model = null;

    public function setUp(): void {
        parent::setUp();
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }
        $this->table = $this->table;
        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);


        $post = array();
        $post['name'] = $this->table;
        $post['title'] = $this->table;
        $post['count'] = 20;
        $post['fields'] = array(
            array(
                'type' => 'Stroka',
                'name' => 'title',
                'title' => 'title1',
                'showinlist' => 1,
                'required' => 1
            )
        );

        $result = $this->withSession($this->session)->post(route('backend/content/tables/ajaxadd'), $post)->decodeResponseJson();
        if (!(isset($result['type']) and $result['type'] == "success" )) {
            fwrite(STDERR, print_r($result));
            $this->fail("В ответе type должен быть success");
        }

        $max = 5;
        $rows = array();
        $i = 0;
        while ($i < $max) {

            $array_insert = array();
            $array_insert['enable'] = 1;
            $array_insert['title'] = "title" . rand(0, 9999);
            $array_insert['last_id'] = \db\SqlQuery::insert($array_insert, $this->table);

            $update = array('sort' => $array_insert['last_id']);
            \db\SqlQuery::update($this->table, $update, "last_id=" . $array_insert['last_id']);
            $rows[] = $array_insert;
            $i++;
        }
        $this->rows = $rows;

        $this->model = \content\models\MasterTable::find($this->table);
    }

    public function tearDown(): void {



        $this->withSession($this->session)->post(route('backend/content/tables/delete'), array('table' => $this->table));


        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);

        parent::tearDown();
    }

    public function test_actions() {
        \content\models\TableConfig::actions();
    }

    public function test_add_deleteField() {
        $table = \db\JsonQuery::get($this->table, "tables", "name");
        $table2 = \content\models\TableConfig::get($this->table);
        $field = \content\models\TableConfig::getField("Stroka");
        $field['type'] = "Stroka";
        \content\models\TableConfig::addField($table, 'title2', $field);
        \content\models\TableConfig::deleteField($table2, 'title2');
    }

    public function test_edit() {
        $table = \content\models\TableConfig::get($this->table);
        $post = array();
        $post['title'] = "phpunit_mysql_supersdfsdfsdf";
        $this->withSession($this->session)->post(route('backend/index'), $post);
        \content\models\TableConfig::edit($table);
    }

    public function test_isExist() {
        \content\models\TableConfig::isExist($this->table);
    }

    public function test_fields() {
        \content\models\TableConfig::fields();
    }

    public function test_eventTypes() {
        \content\models\TableConfig::eventTypes();
    }

    public function test_getFieldbyName() {
        \content\models\TableConfig::getFieldbyName("title", $this->table);
    }

    public function test_getField() {
        \content\models\TableConfig::getField("Stroka");
    }

}
