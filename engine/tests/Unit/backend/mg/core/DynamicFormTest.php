<?php

namespace Tests\Unit\backend\mg\core;

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
    public $form_data = null;
    public $form_table = null;
    public $model = null;
    public $message = null;
    public $row = null;

    public function setUp(): void {
        parent::setUp();
        if (class_exists("\\mg\\config")) {
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
            $this->row = $array;
            $this->form_data = \forms\models\FormConfig::get($this->form_id);
            $obj_form = \forms\models\FormModel::getFormModel($this->form_data);

            $this->model = $obj_form->getModel();
            $this->message = $array;
        }
    }

    public function tearDown(): void {
        if (class_exists("\\mg\\config")) {

            $forms = \db\JsonQuery::all("forms");
            \mg\MongoQuery::delete("forms" . $this->form->id, array());
            \forms\models\FormConfig::delete($this->form->id);
            $connection = Env("DB_CONNECTION");
            \DB::disconnect($connection);
        }
        parent::tearDown();
    }

    public function testGetArrayRows() {
        if (class_exists("\\mg\\config")) {
            \mg\core\DynamicForm::getArrayRows($this->form->id);
        }
    }

    public function test_parse() {
        if (class_exists("\\mg\\config")) {
            $this->model->parse(array($this->row));
        }
    }

    public function test_one() {
        if (class_exists("\\mg\\config")) {
            $this->model->one($this->row['last_id']);
        }
    }

    public function test_all() {
        if (class_exists("\\mg\\config")) {
            $this->model->one($this->row['last_id']);
        }
    }

    public function test_setCondition() {
        if (class_exists("\\mg\\config")) {
            $get_params = array();
            $get_params['conditions'] = array('title');
            $get_params['type_title'] = "LIKE";
            $get_params['title'] = "test";
            $this->withSession($this->session)->get(route('backend/index'), $get_params);
            $this->model->setCondition();
            $this->model->all();
        }
    }

    public function test_getFieldsSearch() {
        if (class_exists("\\mg\\config")) {
            $this->model->getFieldsSearch();
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

    public function test_getForm() {
        if (class_exists("\\mg\\config")) {
            $this->model->getForm();
        }
    }

}
