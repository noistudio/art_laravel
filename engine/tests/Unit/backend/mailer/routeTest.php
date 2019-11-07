<?php

namespace Tests\Unit\backend\mailer;

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

        $this->withSession($this->session)->get(route("backend/mailer/test/index"));
        $this->withSession($this->session)->get(route("backend/mailer/test"));
        $post = array();
        $post['to'] = "artem@noibiz.com";
        $post['subject'] = "asdasdasd";
        $post['content'] = "supertest";
        $this->withSession($this->session)->post(route("backend/mailer/test/send"), $post);
        $this->withSession($this->session)->get(route("backend/mailer/config/index"));
        $this->withSession($this->session)->get(route("backend/mailer/config"));

        $post = array();
        $post['encryption'] = "null";
        $post['type'] = "sendmail";
        $post['host'] = "localhost";
        $post['port'] = "25";
        $post['email'] = "phpunit@phpunit.test";
        $post['password'] = "12312312";
        $this->withSession($this->session)->post(route("backend/mailer/config/save"), $post);
    }

}
