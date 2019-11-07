<?php

namespace Tests\Unit\backend\menu\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class MenuBlockTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $menu = null;
    public $block = null;
    public $block_model = null;

    public function setUp(): void {
        parent::setUp();

        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);

        $post = array();
        $post['title'] = "teztmenu";



        $this->withSession($this->session)->post(route("backend/menu/doadd"), $post);
        $menu = null;
        $menus = \db\JsonQuery::all("menus");
        if (count($menus) > 0) {
            foreach ($menus as $row) {
                $menu = $row;
                break;
            }
        }
        $this->menu = \menu\models\MenuModel::get($menu->id);

        $post = array();
        $post['title'] = "test_title1";
        $post['target'] = "_self";
        $post['link'] = "test_link1";
        $post['language'] = "null";
        $post['parent'] = "null";

        $result = $this->withSession($this->session)->post(route("backend/menu/update/add", array('val_0' => $this->menu['id'])), $post);

        $post = array();
        $post['title'] = "test_title2";
        $post['target'] = "_self";
        $post['link'] = "test_link2";
        $post['language'] = "null";
        $post['parent'] = "null";

        $result = $this->withSession($this->session)->post(route("backend/menu/update/add", array('val_0' => $this->menu['id'])), $post);
        $menu = \menu\models\MenuModel::get($menu->id);
        $this->menu = $menu;
        \core\AppConfig::set("app.block_types", "");
        $type_block = $menu['id'] . "_menu";


        $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                    'type' => $type_block,
                    'title' => 'menu2block',
                    '_token' => csrf_token(),
                ])->decodeResponseJson();
        //echo $type_block . "<br>";
        //   dd($response);
        //  exit;
        $block = \blocks\models\BlocksModel::get($response['block_id'], true);
        $this->block = $block;
        $class = $block['type_arr']['class'];
        $op = $block['type_arr']['op'];
        $value = $block['type_arr']['value'];

        $obj = new $class($op, $value, $block['params'], $block);
        $this->block_model = $obj;

        $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/menu/menu" . $this->menu['id'] . ".php";
        file_put_contents($path, "<h2>dsfsdfsdfsdf</h2>");
    }

    public function tearDown(): void {
        $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/menu/menu" . $this->menu['id'] . ".php";
        unlink($path);
        \db\JsonQuery::delete((int) $this->block['id'], "id", "blocks");
        \db\JsonQuery::delete((int) $this->menu['id'], "id", "menus");

        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testRun() {
        \core\AppConfig::set("app.current_manager", "frontend");
        $this->block_model->run();
        \core\AppConfig::set("app.current_manager", "backend");
    }

    public function testEditpage() {
        $this->block_model->editPage();
    }

    public function testAddpage() {
        $this->block_model->addPage();
    }

    public function testValidate() {
        $this->block_model->validate();
    }

}
