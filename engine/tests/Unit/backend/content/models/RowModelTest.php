<?php

namespace Tests\Unit\backend\content\models;

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

    public function test_run_multioperations() {

        $post_array = array();
        $post_array['ids'] = array();
        foreach ($this->rows as $row) {
            $post_array['ids'][] = $row['last_id'];
        }
        $post_array['op'] = "enable";
        $this->withSession($this->session)->post(route('backend/index'), $post_array);

        $result = \content\models\RowModel::run_multioperations($this->table);
        if (!$result) {
            $this->fail("Результат должен быть true");
        }

        $post_array['op'] = "disable";
        $this->withSession($this->session)->post(route('backend/index'), $post_array);

        $result = \content\models\RowModel::run_multioperations($this->table);
        if (!$result) {
            $this->fail("Результат должен быть true");
        }

        $post_array['op'] = "delete";
        $this->withSession($this->session)->post(route('backend/index'), $post_array);

        $result = \content\models\RowModel::run_multioperations($this->table);
        if (!$result) {
            $this->fail("Результат должен быть true");
        }
    }

    public function test_run_parse() {
        \content\models\RowModel::run_parse($this->rows, $this->table);
    }

    public function test_operation_update() {

        $post_array = array();

        $post_array['title'] = "newmegatitle";
        $this->withSession($this->session)->post(route('backend/index'), $post_array);

        \content\models\RowModel::operation_update($this->table, $this->rows[0], $this->rows[0]['last_id']);
    }

    public function test_operation_add() {

        $post_array = array();

        $post_array['title'] = "newmegatitle";
        $post_array['enable'] = 1;
        $this->withSession($this->session)->post(route('backend/index'), $post_array);

        \content\models\RowModel::operation_update($this->table, array(), "null");
    }

}
