<?php

namespace Tests\Unit\backend\forms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class routeTest extends TestCase {

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

    public function testBackendRoutes() {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->withSession($this->session)->get(route("backend/forms"));
        $this->withSession($this->session)->get(route("backend/forms/index"));
        $this->withSession($this->session)->post(route("backend/forms/delete"), array("form_id" => 99999));
        $result = $this->withSession($this->session)->get(route("backend/forms/add"));


        $this->withSession($this->session)->get(route("backend/forms/ajaxadd"));

        $this->withSession($this->session)->get(route("backend/forms/manage/show", array('val_0' => 9999, 'val_1' => 999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/deletefield", array('val_0' => 9999, 'val_1' => 99999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/delete", array('val_0' => 9999, 'val_1' => 99999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/setup", array('val_0' => 9999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/ops", array('val_0' => 9999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/savenotify", array('val_0' => 9999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/templateemail", array('val_0' => 9999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/template", array('val_0' => 9999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/ajaxedit", array('val_0' => 9999)));
        $this->withSession($this->session)->get(route("backend/forms/manage/index", array('val_0' => 9999)));
        $this->withSession($this->session)->get(route("backend/forms/manage", array('val_0' => 9999)));
    }

}
