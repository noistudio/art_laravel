<?php

namespace Tests\Unit\backend\blocks\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class BlockTest extends TestCase {

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

    public function testLoadType() {
        $this->withSession($this->session)->get(route("backend/blocks/loadtype", array("val_0" => '123213213')));
    }

    public function testEnable() {
        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {

                $this->withSession($this->session)->get(route("backend/blocks/enable", array('val_0' => $block->id)));
            }
        }
    }

    public function testDisable() {
        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $this->withSession($this->session)->get(route("backend/blocks/disable", array('val_0' => $block->id)));
                break;
            }
        }
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testOps() {

        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $this->withSession($this->session)->post(route('backend/blocks/ops'), [
                    'op' => 'enable',
                    'ids' => array($block->id),
                    '_token' => csrf_token(),
                ]);
                $this->withSession($this->session)->post(route('backend/blocks/ops'), [
                    'op' => 'disable',
                    'ids' => array($block->id),
                    '_token' => csrf_token(),
                ]);
                $this->withSession($this->session)->post(route('backend/blocks/ops'), [
                    'op' => 'delete',
                    'ids' => array($block->id),
                    '_token' => csrf_token(),
                ]);
                break;
            }
        }
    }

    public function testDelete() {

        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $this->withSession($this->session)->post(route('backend/blocks/delete', array('val_0' => $block->id)), [
                    '_token' => csrf_token(),
                ]);

                break;
            }
        }
    }

}
