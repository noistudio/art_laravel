<?php

namespace Tests\Unit\backend\forms\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FormsTest extends TestCase {

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

    public function tearDown(): void {

        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testAddMongoDB() {
        if (!\core\ManagerConf::isMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mongodb отключен!');
        }
        $post_array = array();
        $post_array['_token'] = csrf_token();
        $post_array['title'] = "phpunit_test_form";
        $post_array['type'] = "mongodb";
        $post_array['email'] = "phpunit@test.ru";
        $post_array['fields'] = array(
            array(
                'type' => 'Stroka',
                'name' => 'title',
                'title' => 'ТИТЛ',
                'showinlist' => 1,
                'showsearch' => 1,
                'required' => 1
            )
        );


        $this->withSession($this->session)->post(route('backend/forms/ajaxadd'), $post_array);

        $forms = \db\JsonQuery::all("forms");
        if (count($forms) > 0) {
            $last = count($forms) - 1;
            foreach ($forms as $key => $form) {

                $this->withSession($this->session)->post(route('backend/forms/delete'), array('form_id' => $form->id));
                break;
            }
        }
    }

    public function testAddMysql() {
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }
        $post_array = array();
        $post_array['_token'] = csrf_token();
        $post_array['title'] = "phpunit_test_form";
        $post_array['type'] = "mysql";
        $post_array['email'] = "phpunit@test.ru";
        $post_array['fields'] = array(
            array(
                'type' => 'Stroka',
                'name' => 'title',
                'title' => 'ТИТЛ',
                'showinlist' => 1,
                'showsearch' => 1,
                'required' => 1
            )
        );


        $this->withSession($this->session)->post(route('backend/forms/ajaxadd'), $post_array);

        $forms = \db\JsonQuery::all("forms");
        if (count($forms) > 0) {
            $last = count($forms) - 1;
            foreach ($forms as $key => $form) {

                $this->withSession($this->session)->post(route('backend/forms/delete'), array('form_id' => $form->id));
                break;
            }
        }
    }

}
