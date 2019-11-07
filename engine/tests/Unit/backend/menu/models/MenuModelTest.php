<?php

namespace Tests\Unit\backend\menu\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class MenuModelTest extends TestCase {

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




        $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/menu/menu" . $this->menu['id'] . ".php";
        file_put_contents($path, "<h2>dsfsdfsdfsdf</h2>");
    }

    public function tearDown(): void {
        $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/menu/menu" . $this->menu['id'] . ".php";
        unlink($path);

        \db\JsonQuery::delete((int) $this->menu['id'], "id", "menus");

        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testUrl() {
        \menu\models\MenuModel::url();
    }

    public function testReplace() {
        \menu\models\MenuModel::replace("/blabla", true);
        \menu\models\MenuModel::replace("/blabla", false);
    }

    public function testGetParents() {
        \menu\models\MenuModel::getParents($this->menu['links'], null);
    }

    public function testRunmenu() {
        \menu\models\MenuModel::runMenu($this->menu['id']);
    }

    public function testEvent() {
        \menu\models\MenuModel::event();
    }

    public function testListTypes() {
        \menu\models\MenuModel::listTypes();
    }

    public function testSave() {
        $this->menu['title'] = "testtitle2";
        \menu\models\MenuModel::save($this->menu);
    }

    public function testGet() {
        \menu\models\MenuModel::get($this->menu['id']);
    }

    public function testLoadTypes() {
        \menu\models\MenuModel::loadTypes();
    }

    public function testEdit() {
        $post = array();
        $post['title'] = "supetut";
        $this->withSession($this->session)->post(route("backend/index"), $post);
        \menu\models\MenuModel::edit($this->menu);
    }

    public function testDeleteLinkInterator() {
        \menu\models\MenuModel::deleteLinkInterator($this->menu['links'], 5, array());
    }

    public function testReplaceLinkInterator() {
        \menu\models\MenuModel::replaceLinkInterator($this->menu['links'], 5, array(), array());
    }

    public function testGetLinkIterator() {
        \menu\models\MenuModel::getLinkIterator($this->menu['links'], 5, array());
    }

    public function testGetLink() {
        \menu\models\MenuModel::getLink($this->menu, "1");
    }

    public function testDeleteLink() {
        $link = \menu\models\MenuModel::getLink($this->menu, "0");

        \menu\models\MenuModel::deleteLink($this->menu, 0, $link);
    }

    public function testSaveLink() {

        $post = array();
        $post['title'] = "test_titleq";
        $post['target'] = "_self";
        $post['link'] = "test_link12";
        $post['language'] = "null";
        $post['parent'] = "null";
        $this->withSession($this->session)->post(route("backend/index"), $post);
        $link = \menu\models\MenuModel::getLink($this->menu, "0");

        \menu\models\MenuModel::saveLink($this->menu, "0", $link);
    }

    public function testAddLink() {
        $post = array();
        $post['title'] = "test_title3";
        $post['target'] = "_self";
        $post['link'] = "test_link3";
        $post['language'] = "null";
        $post['parent'] = "null";
        $this->withSession($this->session)->post(route("backend/index"), $post);
        \menu\models\MenuModel::addLink($this->menu);
    }

    public function testGetAdminAccess() {
        \menu\models\MenuModel::getAdminAccess();
    }

}
