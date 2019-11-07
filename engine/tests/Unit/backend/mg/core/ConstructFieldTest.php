<?php

namespace Tests\Unit\backend\mg\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ConstructFieldTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $model = null;

    public function setUp(): void {

        parent::setUp();
        if (class_exists("\\mg\\config")) {
            \core\AppConfig::set("app.current_manager", "backend");
            $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
            $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
            $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
            $this->model = new \mg\fields\Fizfield(array(), "test", array('check' => 'check1'));
        }
    }

    public function test_getConfigOptions() {
        if (class_exists("\\mg\\config")) {
            $this->model->getConfigOptions();
        }
    }

    public function test_isHidden() {
        if (class_exists("\\mg\\config")) {
            $this->model->isHidden();
        }
    }

    public function test_isRunonEnd() {
        if (class_exists("\\mg\\config")) {
            $this->model->isRunonEnd();
        }
    }

    public function test_getVal() {
        if (class_exists("\\mg\\config")) {
            $this->model->getVal();
        }
    }

    public function test_upload() {
        if (class_exists("\\mg\\config")) {
            $response = $this->json('POST', route("backend/index"), [
                'test' => UploadedFile::fake()->image('avatar.jpg')
            ]);


            $result = $this->model->upload("image");
            if (!(isset($result) and is_string($result))) {
                $this->fail("Ответ должен вернуться в виде ссылки на изображение доступной из web");
            }
        }
    }

    public function test__set() {
        if (class_exists("\\mg\\config")) {
            $this->model->_set(array());
        }
    }

    public function test_display() {
        if (class_exists("\\mg\\config")) {
            $this->model->display();
        }
    }

    public function test_dbfield() {
        if (class_exists("\\mg\\config")) {
            $this->model->dbfield();
        }
    }

    public function test_value() {
        if (class_exists("\\mg\\config")) {
            $this->model->value();
        }
    }

    public function test_setOtherField() {
        if (class_exists("\\mg\\config")) {
            $this->model->setOtherField("123", "123");
        }
    }

    public function test_set() {
        if (class_exists("\\mg\\config")) {
            $this->model->set();
        }
    }

    public function test_get() {
        if (class_exists("\\mg\\config")) {
            $this->model->get();
        }
    }

}
