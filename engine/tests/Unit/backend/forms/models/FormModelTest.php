<?php

namespace Tests\Unit\backend\forms\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FormModelTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $form_id = null;
    public $form = null;
    public $form_table = null;
    public $message = null;
    public $form_array = null;

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
        $this->form_array = \forms\models\FormConfig::get($this->form_id);
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

    public function testGetFormModel() {
        \forms\models\FormModel::getFormModel($this->form_array);
    }

    public function testSend() {

        $post_array = array('title' => "phpunit мессендж");
        $this->withSession($this->session)->post(route('backend/index'), $post_array);

        \forms\models\FormModel::send($this->form_array);
    }

    public function testLoadBlock() {
        \core\AppConfig::set("app.block_types", "");
        $type = $this->form_id . "_form";

        $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                    'type' => $type,
                    'title' => 'form_unit_block',
                    '_token' => csrf_token(),
                ])->decodeResponseJson();
        $block = \blocks\models\BlocksModel::get($response['block_id'], true);
        \forms\models\FormModel::loadBlock($response['block_id'], "");
        \db\JsonQuery::delete((int) $response['block_id'], "id", "blocks");
    }

//    public function testAddField() {
//
//     
//        \forms\models\FormConfig::addField("elfinder_files", "test", array('type' => 'Stroka'));
//    }
}
