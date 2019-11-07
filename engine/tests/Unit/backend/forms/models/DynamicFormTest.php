<?php

namespace Tests\Unit\backend\forms\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class DynamicFormTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $form_id = null;
    public $form = null;
    public $form_table = null;
    public $model = null;
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
        if ($this->form->type == "mongodb") {
            $this->model = new \mg\core\DynamicForm($this->form_id);
        } else {
            $this->model = new \forms\models\DynamicForm($this->form_id);
        }

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

    public function testAll() {
        $this->model->all();
    }

    public function testSetCondition() {
        $this->model->setCondition();
    }

    public function testGetFieldSearch() {
        $this->model->getFieldsSearch();
    }

    public function testgetFieldsinList() {
        $this->model->getFieldsinList();
    }

    public function testOffset() {
        $this->model->offset("asdasd");
        $this->model->offset(10);
    }

    public function testLimit() {
        $this->model->limit("asdasd");
        $this->model->limit(10);
    }

    public function testGetForm() {
        $this->model->getForm();
    }

}
