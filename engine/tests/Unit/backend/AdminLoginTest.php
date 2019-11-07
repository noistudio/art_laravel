<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class AdminLoginTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;

    public function setUp(): void {
        parent::setUp();

        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSuccessLogin() {

        //$this->markTestSkipped('must be revisited.');
        //$this->assertTrue(true);




        $response = $this->post(route('backend/login/doit'), [
            'login' => $this->admin_login,
            'password' => $this->admin_password,
            '_token' => csrf_token(),
        ]);

//
        $response->assertSessionHas("admin_login");
        $response->assertSessionHas("admin_password");
        $response->assertRedirect(route('backend/index'));
    }

    public function testSuccessFail() {

        //$this->markTestSkipped('must be revisited.');
        $this->assertTrue(true);

        $response = $this->post(route('backend/login/doit'), [
            'login' => $this->admin_password,
            'password' => "12!23",
            '_token' => csrf_token(),
        ]);

        $response->assertRedirect(route('backend/login/index'));
    }

}
