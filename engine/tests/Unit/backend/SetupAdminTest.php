<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class SetupAdminTest extends TestCase {

    public function setUp(): void {
        parent::setUp();
        \core\AppConfig::set("app.current_manager", "backend");
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testEditSuccess() {
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => \core\ManagerConf::get("admin_login", "backend"), 'admin_password' => \core\ManagerConf::get("admin_password", "backend"), 'admin_is_root' => true))->post(route('backend/setup/save'), [
            'css' => 'amethyst.css',
            'name' => "edit from php unit",
            'link' => "https://ya.ru",
            '_token' => csrf_token(),
        ]);
        $response->assertRedirect(route('backend/setup'));
    }

}
