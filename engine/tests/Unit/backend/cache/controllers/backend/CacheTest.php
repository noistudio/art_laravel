<?php

namespace Tests\Unit\backend\cache\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class CacheTest extends TestCase {

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

    public function tearDown(): void {

        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testIndex() {
        $this->withSession($this->session)->get(route("backend/cache/index"));
        $this->withSession($this->session)->get(route("backend/cache"));
    }

    public function testClear() {
        $this->withSession($this->session)->get(route("backend/cache/clear"));
    }

    public function cacheSave() {
        $this->withSession($this->session)->post(route('backend/cache/save',), [
            'status' => 'enable',
            '_token' => csrf_token(),
        ]);
        $this->withSession($this->session)->post(route('backend/cache/save',), [
            'status' => 'disable',
            '_token' => csrf_token(),
        ]);
    }

}
