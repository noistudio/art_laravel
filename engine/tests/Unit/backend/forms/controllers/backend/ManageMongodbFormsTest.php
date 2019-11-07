<?php

namespace Tests\Unit\backend\forms\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ManageMongodbFormsTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $form_id = null;
    public $form = null;
    public $form_table = null;
    public $message = null;

    public function setUp(): void {
        parent::setUp();

        if (!\core\ManagerConf::isMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mongodb отключен!');
        }

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

    public function testShow() {
        $this->withSession($this->session)->get(route("backend/forms/manage/show", array('val_0' => $this->form_id, 'val_1' => $this->message['last_id'])));
    }

    public function testFields() {
        $post_array = array();
        $post_array['_token'] = csrf_token();
        $post_array['title'] = "phpunit_test_form2_manage";


        $post_array['newfields'] = array(
            array(
                'type' => 'Stroka',
                'name' => 'title2',
                'title' => 'ТИТЛ2',
                'showinlist' => 1,
                'showsearch' => 1,
                'required' => 1
            )
        );


        $this->withSession($this->session)->post(route('backend/forms/manage/ajaxedit', array('val_0' => $this->form_id)), $post_array);



        $this->withSession($this->session)->get(route('backend/forms/manage/deletefield', array('val_0' => $this->form_id, 'val_1' => 'title2')));
    }

    public function testDelete() {
        $array = array();
        $array['title'] = "test_title2";
        $array['date_create'] = \mg\MongoHelper::date();
        $array = \mg\MongoQuery::insert($array, $this->form_table);
        $this->withSession($this->session)->get(route('backend/forms/manage/delete', array('val_0' => $this->form_id, 'val_1' => $array['last_id'])));
    }

    public function testOps() {

        $array = array();
        $array['title'] = "test_title3";
        $array['date_create'] = \mg\MongoHelper::date();
        $array = \mg\MongoQuery::insert($array, $this->form_table);
        $post_array['newfields'] = array(
            array(
                'op' => 'delete',
                'ids' => array($array['last_id']),
            )
        );


        $this->withSession($this->session)->post(route('backend/forms/manage/ops', array('val_0' => $this->form_id)), $post_array);
    }

    public function testSaveNotify() {
        $this->withSession($this->session)->post(route('backend/forms/manage/savenotify', array('val_0' => $this->form_id)), array(
            'notify' => 'edited_notify'
        ));
    }

}
