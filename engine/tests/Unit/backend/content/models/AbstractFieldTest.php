<?php

namespace Tests\Unit\backend\mg\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class AbstractFieldTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $model = null;

    public function setUp(): void {
        parent::setUp();
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }
        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
        $this->model = new \content\fields\Stroka("test", "test", array('check' => 'check1'));
    }

    public function testGetConfigOptions() {

        $this->model->getConfigOptions();
    }

    public function testParse() {
        $this->model->parse(array());
    }

    public function testIsHidden() {
        $this->model->isHidden();
    }

    public function testIsRunonEnd() {
        $this->model->isRunonEnd();
    }

    public function testGetVal() {
        $this->model->getVal();
    }

    public function testUpload() {
        $response = $this->json('POST', route("backend/index"), [
            'test' => UploadedFile::fake()->image('avatar.jpg')
        ]);




        $result = $this->model->upload("image");

        if (!(isset($result) and is_string($result))) {
            $this->fail("Ответ должен вернуться в виде ссылки на изображение доступной из web");
        }
    }

    public function test_set() {
        $this->model->_set("test2");
    }

    public function testSetOtherField() {
        $this->model->setOtherField("test", "test2");
        \core\AppConfig::set("sql_params", null);
    }

    public function testSet() {
        $this->model->set();
    }

    public function testGet() {
        $this->model->get();
    }

    public function testGetFieldTitle() {
        $this->model->getFieldTitle();
    }

//    public function testOption() {
//        $this->model->option("check");
//    }
//    public function testRender() {
//        $this->model->render();
//    }
}
