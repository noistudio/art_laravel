<?php

namespace Tests\Unit\backend\menu;

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

        $this->withSession($this->session)->get(route("backend/menu/index"));
        $this->withSession($this->session)->get(route("backend/menu"));
        $this->withSession($this->session)->get(route("backend/menu/add"));
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

        $this->withSession($this->session)->get(route("backend/menu/delete", array('val_0' => $menu->id)));


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
        $this->withSession($this->session)->get(route("backend/menu/update/index", array('val_0' => $menu->id)));
        $this->withSession($this->session)->get(route("backend/menu/update", array('val_0' => $menu->id)));

        $post = array();
        $post['title'] = "test_title1";
        $post['target'] = "_self";
        $post['link'] = "test_link1";
        $post['language'] = "null";
        $post['parent'] = "null";

        $result = $this->withSession($this->session)->post(route("backend/menu/update/add", array('val_0' => $menu->id)), $post);

        $result->assertSessionHas("success");

        $this->withSession($this->session)->get(route("backend/menu/update/template", array('val_0' => $menu->id)));

        $post = array();
        $post['title'] = "teztmenu2";


        $this->withSession($this->session)->post(route("backend/menu/update/doedit", array('val_0' => $menu->id)), $post);

        $this->withSession($this->session)->get(route("backend/menu/update/editlink", array('val_0' => $menu->id, 'val_1' => 0)));

        $post = array();
        $post['title'] = "test_title222";
        $post['target'] = "_self";
        $post['link'] = "test_link222";
        $post['language'] = "null";

        $this->withSession($this->session)->post(route("backend/menu/update/doeditlink", array('val_0' => $menu->id, 'val_1' => 0)), $post);


        $this->withSession($this->session)->get(route("backend/menu/arrows/up", array('val_0' => $menu->id, 'val_1' => 0)));
        $this->withSession($this->session)->get(route("backend/menu/arrows/down", array('val_0' => $menu->id, 'val_1' => 0)));


        $this->withSession($this->session)->get(route("backend/menu/update/delete", array("val_0" => $menu->id, 'val_1' => 0)));

        $this->withSession($this->session)->get(route("backend/menu/delete", array('val_0' => $menu->id)));
    }

}
