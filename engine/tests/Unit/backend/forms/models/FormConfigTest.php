<?php

namespace Tests\Unit\backend\forms\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FormConfigTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $form_id = null;
    public $form = null;
    public $form_table = null;
    public $message = null;

    public function setUp(): void {

        parent::setUp();

        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
        $post_array = array();
        $post_array['_token'] = csrf_token();
        $post_array['title'] = "phpunit_test_form_for_manage";
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
                if ($key == $last) {
                    $this->form_id = $form->id;
                    $this->form = $form;
                    $this->form_table = "forms" . $this->form_id;
                    break;
                }
            }
        }

        $array = array();
        $array['title'] = "test_title";
        $array['date_create'] = \mg\MongoHelper::date();
        $array = \mg\MongoQuery::insert($array, $this->form_table);


        $this->message = $array;
    }

    public function tearDown(): void {

        $forms = \db\JsonQuery::all("forms");
        if (count($forms) > 0) {
            $last = count($forms) - 1;

            foreach ($forms as $key => $form) {
                if ($form->type == "mongodb") {
                    \mg\MongoQuery::delete("forms" . $form->id, array());
                }
                \forms\models\FormConfig::delete($form->id);
            }
        }
        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testSaveNotify() {

        $request = new Request([], ['send_on_email_admin' => 1, 'notify' => 'bla bla bla'], ['info' => 5]);

        $this->withSession($this->session)->post(route('backend/index'), array("notify" => "bla bla bla"));

        $post = request()->post();

        $form = \forms\models\FormConfig::get($this->form_id);
        $result = \forms\models\FormConfig::saveNotify($form);
    }

    public function testEdit() {

        $request = new Request([], ['title' => 'phpunit_test_form_for_manage', 'send_on_email_admin' => 1], ['info' => 5]);

        $this->withSession($this->session)->post(route('backend/index'), array("notify" => "bla bla bla"));

        $post = request()->post();

        $form = \forms\models\FormConfig::get($this->form_id);
        $result = \forms\models\FormConfig::edit($form);
    }

    public function testAdd() {
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


        $this->withSession($this->session)->post(route('backend/index'), $post_array);

        $post = request()->post();

        $form = \forms\models\FormConfig::get($this->form_id);
        $result = \forms\models\FormConfig::add($form);
    }

    public function testIsExists() {
        \forms\models\FormConfig::isExist($this->form_id);
        \forms\models\FormConfig::isExist("sdfsdff");
    }

    public function testGetField() {
        \forms\models\FormConfig::getField("Stroka");
        \forms\models\FormConfig::getField("StrokaBlaBLa");
        \forms\models\FormConfig::getFieldMongodb("Stroka");
        \forms\models\FormConfig::getFieldMongodb("StrokaBlaBLa");
    }

//    public function testAddField() {
//
//     
//        \forms\models\FormConfig::addField("elfinder_files", "test", array('type' => 'Stroka'));
//    }
}
