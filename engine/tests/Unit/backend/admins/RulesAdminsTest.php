<?php

namespace Tests\Unit\backend\admins;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class RulesAdminsTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;

    public function setUp(): void {
        parent::setUp();
        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
    }

    public function testRules_Index() {
        $response = $this->withSession($this->session)->post(route('backend/admins/rules/index'), [
            '_token' => csrf_token(),
        ]);
    }

    public function testManipulteRules() {
        $response = $this->withSession($this->session)->post(route('backend/admins/rules/add'), [
            'links' => 'link1',
            'name' => 'testrule',
            'title' => 'testrule',
            '_token' => csrf_token(),
        ]);
        $rules = \db\SqlDocument::all("admin_access");
        $last = count($rules) - 1;

        $response = $this->withSession($this->session)->post(route('backend/admins/rules/delete', array('val_0' => $last)), [
            '_token' => csrf_token(),
        ]);
    }

}
