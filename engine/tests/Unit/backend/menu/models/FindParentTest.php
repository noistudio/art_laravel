<?php

namespace Tests\Unit\backend\menu\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class FindParentTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $menu = null;

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
    }

    public function tearDown(): void {

        $this->withSession($this->session)->get(route("backend/menu/delete", array('val_0' => $this->menu['id'])));
        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testGet() {
        $arr = array('title' => "test title", "target" => "_self", "link" => "link");
        \menu\models\FindParent::get($this->menu, $arr);
    }

}
