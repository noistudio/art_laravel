<?php

namespace Tests\Unit\backend\logs;

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

        $this->withSession($this->session)->get(route("backend/logs/add/index"));
        $this->withSession($this->session)->get(route("backend/logs/add"));

        $this->withSession($this->session)->get(route("backend/logs/index"));
        $this->withSession($this->session)->get(route("backend/logs"));
        $this->withSession($this->session)->get(route("backend/logs"));


        $post = array();
        $post['channel'] = "daily";
        $post['level'] = "critical";


        $response = $this->withSession($this->session)->post(route("backend/logs/add/ajaxadd"), $post)->decodeResponseJson();

        $log_id = $response['log_id'];
        $post['status'] = 1;

        $this->withSession($this->session)->get(route("backend/logs/update/index", array('val_0' => $log_id)));
        $this->withSession($this->session)->get(route("backend/logs/update", array('val_0' => $log_id)));
        $this->withSession($this->session)->post(route("backend/logs/update/ajaxedit", array('val_0' => $log_id)), $post);

        $this->withSession($this->session)->get(route("backend/logs/delete", array('val_0' => $log_id)));
    }

}
