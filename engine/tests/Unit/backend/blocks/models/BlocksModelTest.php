<?php

namespace Tests\Unit\backend\blocks\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class BlocksModelTest extends TestCase {

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

    public function testFindBeetween() {
        $html = "<p>{b}  {b} [t [b</p>";
        \blocks\models\BlocksModel::find_between($html, "{", "}");
        \blocks\models\BlocksModel::find_between($html, "[", "]");
        \blocks\models\BlocksModel::find_between($html, "{", "}", true);
        \blocks\models\BlocksModel::find_between($html, "[", "]", true);
    }

    public function testUpdate() {


        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $block = \blocks\models\BlocksModel::get($block->id, false);
                if (isset($block) and is_array($block)) {
                    \blocks\models\BlocksModel::update($block);

                    break;
                }
            }
        }
    }

    public function testAlltypes() {
        \blocks\models\BlocksModel::allTypes();
    }

    public function testAdd() {
        \blocks\models\BlocksModel::add();
    }

}
