<?php

namespace Tests\Unit\backend\forms\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FormBlockTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $form_id = null;
    public $form = null;
    public $form_table = null;
    public $message = null;
    public $form_array = null;
    public $block = null;
    public $block_model = null;

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


        \core\AppConfig::set("app.block_types", "");
        $type = $this->form_id . "_form";

        $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                    'type' => $type,
                    'title' => 'form_unit_block',
                    '_token' => csrf_token(),
                ])->decodeResponseJson();
        $block = \blocks\models\BlocksModel::get($response['block_id'], true);
        $this->block = $block;
        $class = $block['type_arr']['class'];
        $op = $block['type_arr']['op'];
        $value = $block['type_arr']['value'];

        $obj = new $class($op, $value, $block['params'], $block);
        $this->block_model = $obj;

        $this->message = $array;
        \core\AppConfig::set("app.current_manager", "frontend");
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
        \db\JsonQuery::delete((int) $this->block['id'], "id", "blocks");
        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testRun() {
        $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/forms/form" . $this->form_id . ".php";
        file_put_contents($path, "<h2>dsfsdfsdfsdf</h2>");

        $this->block_model->run();
        unlink($path);
    }

    public function testNeedCache() {
        $this->block_model->needCache();
    }

    public function testEditPage() {
        $this->block_model->editPage();
    }

    public function testValidate() {
        $this->block_model->validate();
    }

    public function testAddpage() {
        $this->block_model->addPage();
    }

//    public function testAddField() {
//
//     
//        \forms\models\FormConfig::addField("elfinder_files", "test", array('type' => 'Stroka'));
//    }
}
