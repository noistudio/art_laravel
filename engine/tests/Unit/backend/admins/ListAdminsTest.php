<?php

namespace Tests\Unit\backend\admins;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ListAdminsTest extends TestCase {

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

    public function testList_Index() {
        $response = $this->withSession($this->session)->post(route('backend/admins/list/index'), [
            '_token' => csrf_token(),
        ]);
    }

    public function testList_ManipulteAdmins() {
        $response = $this->withSession($this->session)->post(route('backend/admins/list/add'), [
            'access' => array('subroot'),
            'login' => 'test',
            'password' => 'test',
            '_token' => csrf_token(),
        ]);
        $admins = \admins\models\AdminModel::getAll();
        $last = count($admins) - 1;
        $response = $this->withSession($this->session)->post(route('backend/admins/list/edit', array('val_0' => $last)), [
            '_token' => csrf_token(),
        ]);
        $response = $this->withSession($this->session)->post(route('backend/admins/list/doedit', array('val_0' => $last)), [
            'login' => 'test2',
            '_token' => csrf_token(),
        ]);
        $response = $this->withSession($this->session)->post(route('backend/admins/list/delete', array('val_0' => $last)), [
            '_token' => csrf_token(),
        ]);
    }

}
