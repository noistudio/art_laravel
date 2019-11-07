<?php

namespace Tests\Unit\backend\blocks\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class UpdateBlockTest extends TestCase {

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

    public function testUpdateIndex() {
        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {

            foreach ($blocks as $block) {
                $this->withSession($this->session)->get(route("backend/blocks/update/index", array('var_ 0' => $block->id)));
            }
        }
    }

    public function testUpdateAjaxEdit() {

        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $this->withSession($this->session)->post(route('backend/blocks/update/ajaxedit', array('var_0' => $block->id)), [
                    'title' => 'after_edit2',
                    '_token' => csrf_token(),
                ]);

                break;
            }
        }
    }

}
