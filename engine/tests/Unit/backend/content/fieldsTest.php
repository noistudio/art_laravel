<?php

namespace Tests\Unit\backend\content;

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
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }
        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
        $this->fields = \content\models\TableConfig::fields();
    }

    public function test_set() {

        foreach ($this->fields as $field) {
            $field['obj']->set();
        }
    }

    public function test_get() {

        foreach ($this->fields as $field) {
            $field['obj']->get();
        }
    }

    public function test_getFieldTitle() {

        foreach ($this->fields as $field) {
            $field['obj']->getFieldTitle();
        }
    }

    public function test_getConfigOptions() {

        foreach ($this->fields as $field) {
            $field['obj']->getConfigOptions();
        }
    }

    public function test_isHidden() {

        foreach ($this->fields as $field) {
            $field['obj']->isHidden();
        }
    }

    public function test_isRunonEnd() {

        foreach ($this->fields as $field) {
            $field['obj']->isRunonEnd();
        }
    }

    public function test_getVal() {

        foreach ($this->fields as $field) {
            $field['obj']->getVal();
        }
    }

    public function test_parse() {

        foreach ($this->fields as $field) {
            $field['obj']->parse(array());
        }
    }

}
