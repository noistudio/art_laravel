<?php

namespace Tests\Unit\backend\mg;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FieldsTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $fields = null;

    public function setUp(): void {
        parent::setUp();
        if (class_exists("\\mg\\config")) {
            \core\AppConfig::set("app.current_manager", "backend");
            $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
            $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
            $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
            $this->fields = \mg\core\CollectionModel::fields();
        }
    }

    public function test_set() {
        if (class_exists("\\mg\\config")) {
            foreach ($this->fields as $field) {
                $field['obj']->set();
            }
        }
    }

    public function test_get() {
        if (class_exists("\\mg\\config")) {
            foreach ($this->fields as $field) {
                $field['obj']->get();
            }
        }
    }

    public function test_display() {
        if (class_exists("\\mg\\config")) {
            foreach ($this->fields as $field) {
                $field['obj']->display();
            }
        }
    }

    public function test_getFieldTitle() {
        if (class_exists("\\mg\\config")) {
            foreach ($this->fields as $field) {
                $field['obj']->getFieldTitle();
            }
        }
    }

    public function test_value() {
        if (class_exists("\\mg\\config")) {
            foreach ($this->fields as $field) {
                $field['obj']->value();
            }
        }
    }

    public function test_dbfield() {
        if (class_exists("\\mg\\config")) {
            foreach ($this->fields as $field) {
                $field['obj']->dbfield();
            }
        }
    }

}
