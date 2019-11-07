<?php

namespace Tests\Unit\backend\mg\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ArrowModelTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $table = "phpunit_mysql";
    public $rows = array();

    public function setUp(): void {
        parent::setUp();
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }
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
            $this->fail("В ответе type должен быть success");
        }

        $max = 5;
        $rows = array();
        $i = 0;
        while ($i < $max) {

            $array_insert = array();
            $array_insert['title'] = "title" . rand(0, 9999);
            $array_insert['last_id'] = \db\SqlQuery::insert($array_insert, $this->table);

            $update = array('sort' => $array_insert['last_id']);
            \db\SqlQuery::update($this->table, $update, "last_id=" . $array_insert['last_id']);
            $rows[] = $array_insert;
            $i++;
        }
        $this->rows = $rows;
    }

    public function tearDown(): void {



        $this->withSession($this->session)->post(route('backend/content/tables/delete'), array('table' => $this->table));


        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);

        parent::tearDown();
    }

    public function test_up() {

        \content\models\ArrowModel::up($this->table, $this->rows[3]['last_id']);
    }

    public function test_down() {
        \content\models\ArrowModel::down($this->table, $this->rows[1]['last_id']);
    }

    public function test_move() {
        \content\models\ArrowModel::move($this->table, $this->rows[4]['last_id'], 1);
    }

}
