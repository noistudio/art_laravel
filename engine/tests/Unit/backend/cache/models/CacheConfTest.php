<?php

namespace Tests\Unit\backend\cache\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class CacheConfTest extends TestCase {

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

    public function testIs() {
        \cache\models\CacheConf::is();
    }

    public function testSave() {
        \cache\models\CacheConf::save();
    }

}
