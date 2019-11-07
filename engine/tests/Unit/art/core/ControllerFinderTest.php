<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControllerFinderTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $model_frontend = null;
    public $model_backend = null;

    public function setUp(): void {
        parent::setUp();

        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
        $this->model_frontend = new \core\ControllerFinder("content", "frontend");

        $this->model_backend = new \core\ControllerFinder("content", "backend");
    }

    public function test_all_map() {
        $this->model_frontend->all_map();
        $this->model_backend->all_map();
    }

    public function test_all_routes() {
        $this->model_frontend->all_routes();
        $this->model_backend->all_routes();
    }

}
