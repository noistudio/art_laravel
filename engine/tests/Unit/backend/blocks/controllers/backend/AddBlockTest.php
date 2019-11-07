<?php

namespace Tests\Unit\backend\blocks\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class AddBlockTest extends TestCase {

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

    public function testVisitAdd() {
        $this->withSession($this->session)->get(route("backend/blocks/add/index"));
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAddSuccess() {

        $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                    'type' => 'html',
                    'title' => 'unit_blocks',
                    'html' => '<p>supertest</p>',
                    '_token' => csrf_token(),
                ])->decodeResponseJson();
    }

}
