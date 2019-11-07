<?php

namespace Tests\Unit\backend\mg\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class CollectionModelTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;

    public function setUp(): void {
        parent::setUp();

        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
    }

    public function testAdd_and_Edit_and_DeleteField_and_DeleteField_and_Get() {
        if (class_exists("\\mg\\config")) {
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
            $this->withSession($this->session)->post(route("backend/index"), $post);

            $result = \mg\core\CollectionModel::add();
            if (!($result == true)) {
                $this->fail("Ответ должен быть true");
            }


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




            $this->withSession($this->session)->post(route("backend/index", array("val_0" => "phpunit")), $post_update);

            $table = \mg\core\CollectionModel::get("phpunit");
            $result = \mg\core\CollectionModel::edit($table);
            $table = \mg\core\CollectionModel::get("phpunit");
            if (!($result == true)) {
                $this->fail("Ответ должен быть true");
            }

            \mg\core\CollectionModel::deleteField($table, "title2");
            \mg\core\CollectionModel::delete('phpunit');
        }
    }

    public function testIsExist() {
        if (class_exists("\\mg\\config")) {
            \mg\core\CollectionModel::isExist("asdasd");
        }
    }

    public function testFields() {
        if (class_exists("\\mg\\config")) {
            \mg\core\CollectionModel::fields();
        }
    }

    public function testGetField() {
        if (class_exists("\\mg\\config")) {
            \mg\core\CollectionModel::getField("Stroka");
        }
    }

}
