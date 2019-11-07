<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotifyTest extends TestCase {

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

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_add() {
        $response = $this->withSession($this->session)->post(route('backend/index'), [
            '_token' => csrf_token(),
        ]);

        \core\Notify::add("sdfdsfdsfsdf");
    }

    public function test_get() {
        $response = $this->withSession($this->session)->post(route('backend/index'), [
            '_token' => csrf_token(),
        ]);

        \core\Notify::get("success");
    }

}
