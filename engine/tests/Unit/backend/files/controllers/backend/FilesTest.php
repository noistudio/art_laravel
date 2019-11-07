<?php

namespace Tests\Unit\backend\files\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FilesTest extends TestCase {

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

    public function testIndex() {
        $this->withSession($this->session)->get(route("backend/files/index"));
        $this->withSession($this->session)->get(route("backend/files"));
        $this->withSession(array())->get(route("backend/files/index"));
        $this->withSession(array())->get(route("backend/files"));
    }

    public function testDialog() {
        $this->withSession($this->session)->get(route("backend/files/dialog"));

        $this->withSession(array())->get(route("backend/files/dialog"));
    }

}
