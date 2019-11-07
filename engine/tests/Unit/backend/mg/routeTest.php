<?php

namespace Tests\Unit\backend\mg;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class routeTest extends TestCase {

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

    public function testBackendRoutes() {

        if (class_exists("\\mg\\config")) {

            $this->withSession($this->session)->get(route("backend/mg/collections/index"));
            $this->withSession($this->session)->get(route("backend/mg/collections"));
            $this->withSession($this->session)->get(route("backend/mg/collections/add"));
            $this->withSession($this->session)->get(route("backend/mg/collections/select"));
            //подготовка данных для создания временной колекции
            $post = array();
            $post['name'] = "phpunit";
            $post['title'] = "phpunit";
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
            $this->withSession($this->session)->get(route("backend/mg/collections/edit", array("val_0" => "phpunit")));
            //подготовка данных для проверки обновления коллекции
            $post_update = array();
            $post_update['title'] = "phpunit_updated";
            $post_update['count'] = 21;
            $post_update['sort'] = "order_last_id";
            $post_update['fields'] = array(
                "title" => array(
                    'type' => 'Stroka',
                    'name' => 'title',
                    'title' => 'title2',
                    'showinlist' => 1,
                )
            );
            $post_update['newfields'] = array(
                array(
                    'type' => 'Stroka',
                    'name' => 'title2',
                    'title' => 'title',
                    'showinlist' => 1,
                )
            );




            $result = $this->withSession($this->session)->post(route("backend/mg/collections/ajaxedit", array("val_0" => "phpunit")), $post_update)->decodeResponseJson();
            if (!(isset($result['type']) and $result['type'] == "success")) {
                $this->fail("Ответ должен быть success");
            }

            $this->withSession($this->session)->get(route('backend/mg/collections/deletefield', array('val_0' => 'phpunit', 'val_1' => 'title2')));

            $this->withSession($this->session)->get(route("backend/mg/collections/field", array("val_0" => 'Stroka')));

            //проверка manage 

            $this->withSession($this->session)->get(route("backend/mg/manage/add", array("val_0" => "phpunit")));

            //подготовка данных для вставки нескольких элементов

            $posts_insert = array();

            $posts_insert[] = array(
                'title' => 'title1',
                'enable' => 1,
            );
            $posts_insert[] = array(
                'title' => 'title2',
                'enable' => 1,
            );
            $posts_insert[] = array(
                'title' => 'title3',
                'enable' => 1,
            );
            foreach ($posts_insert as $key => $row) {
                $result = $this->withSession($this->session)->post(route("backend/mg/manage/doadd", array("val_0" => "phpunit")), $row)->decodeResponseJson();
                if (!(isset($result['type']) and $result['type'] == "success")) {
                    $this->fail("Ответ должен быть success");
                }
                $posts_insert[$key] = \mg\MongoQuery::get("phpunit", array("last_id" => $result['last_id']));
            }

            foreach ($posts_insert as $post) {
                $this->withSession($this->session)->get(route("backend/mg/arrows/up", array("val_0" => "phpunit", "val_1" => $post['last_id'])));
                $this->withSession($this->session)->get(route("backend/mg/arrows/down", array("val_0" => "phpunit", "val_1" => $post['last_id'])));
                $this->withSession($this->session)->get(route("backend/mg/manage/enable", array("val_0" => "phpunit", "val_1" => $post['last_id'])));
                $this->withSession($this->session)->get(route("backend/mg/manage/clone", array("val_0" => "phpunit", "val_1" => $post['last_id'])));
            }

            $this->withSession($this->session)->get(route("backend/mg/manage/index", array("val_0" => "phpunit")));
            $this->withSession($this->session)->get(route("backend/mg/manage", array("val_0" => "phpunit")));


            $post_ops_params = array();
            $post_ops_params['op'] = "enable";
            $post_ops_params['ids'] = array();
            foreach ($posts_insert as $post) {
                $post_ops_params['ids'][] = $post['last_id'];
            }
            $this->withSession($this->session)->post(route("backend/mg/manage/ops", array('val_0' => "phpunit")), $post_ops_params);

            $condition_rows = array('$or' => array());
            foreach ($posts_insert as $post) {
                $condition_rows['$or'][] = array("last_id" => (int) $post['last_id']);
            }
            $tmp_rows = \mg\MongoQuery::all("phpunit", $condition_rows);

            if (!(isset($tmp_rows) and is_array($tmp_rows) and count($tmp_rows) > 0)) {

                $this->fail("Результат должен быть массивов с обьектами");
            }
            foreach ($tmp_rows as $row) {
                if (!(isset($row['enable']) and $row['enable'] == 1)) {
                    $this->fail("у last_id " . $row['last_id'] . " enable должен равняться 1");
                }

                $this->withSession($this->session)->get(route("backend/mg/manage/update", array("val_0" => "phpunit", "val_1" => $row['last_id'])));
                $post_update = array();
                $post_update['title'] = "title" . rand(0, 9999);

                $result_update = $this->withSession($this->session)->post(route("backend/mg/manage/doupdate", array("val_0" => 'phpunit', "val_1" => $row['last_id'])), $post_update)->decodeResponseJson();
                if (!(isset($result_update['type']) and $result_update['type'] == "success")) {
                    $this->fail("Ответ должен быть success");
                }
            }

            //проверка template 
            $this->withSession($this->session)->get(route("backend/mg/template/list", array("val_0" => 'phpunit')));
            $this->withSession($this->session)->get(route("backend/mg/template/one", array("val_0" => 'phpunit')));
            $this->withSession($this->session)->get(route("backend/mg/template/rss", array("val_0" => 'phpunit')));

            foreach ($tmp_rows as $row) {
                $this->withSession($this->session)->get(route("backend/mg/manage/delete", array("val_0" => 'phpunit', "val_1" => $row['last_id'])));
            }





            $this->withSession($this->session)->post(route("backend/mg/collections/delete", array("val_0" => 'phpunit')));
        }
    }

}
