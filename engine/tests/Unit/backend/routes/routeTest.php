<?php

namespace Tests\Unit\backend\routes;

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



        $this->withSession($this->session)->get(route("backend/routes/add/index"));
        $this->withSession($this->session)->get(route("backend/routes/add"));

        //подготовка данных для создания временной колекции
        $post = array();
        $post['old_link'] = "/phpunit";
        $post['new_link'] = "/phpunit2";
        $post['meta_title'] = "title1";
        $post['meta_description'] = "description1";
        $post['meta_keywords'] = "keywords1";
        $result = $this->withSession($this->session)->post(route("backend/routes/add/doadd"), $post);
        $result->assertSessionHas("success", __("backend/routes.success_add"));

        $this->withSession($this->session)->get(route("backend/routes/ajax/show", array("url" => "/phpunit")));
        //подготовка данных для проверки обновления коллекции
        $post_update = array();
        $post_update['old_link'] = "/phpunit";
        $post_update['new_link'] = "/phpunit3";
        $post_update['meta_title'] = "title1";
        $post_update['meta_description'] = "description1";
        $post_update['meta_keywords'] = "keywords1";





        $result = $this->withSession($this->session)->post(route("backend/routes/ajax/save"), $post_update)->decodeResponseJson();
        if (!(isset($result['type']) and $result['type'] == "success")) {

            fwrite(STDERR, print_r($result));
            $this->fail("Ответ должен быть success");
        }

        $this->withSession($this->session)->get(route('backend/routes/index'));

        $this->withSession($this->session)->get(route("backend/routes"));


        $route = \routes\models\RoutesModel::get("/phpunit");

        if (!(isset($route['id']) )) {
            $this->fail("Должен был вернуть ID");
        }


        $this->withSession($this->session)->get(route('backend/routes/update/index', array("val_0" => $route['id'])));
        $this->withSession($this->session)->get(route('backend/routes/update', array("val_0" => $route['id'])));

        $post_update = array();
        $post_update['old_link'] = "/phpunit";
        $post_update['new_link'] = "/phpunit5";
        $post_update['meta_title'] = "title1";
        $post_update['meta_description'] = "description1";
        $post_update['meta_keywords'] = "keywords1";

        $this->withSession($this->session)->post(route('backend/routes/update/doupdate', array('val_0' => $route['id'])), $post_update);



        $this->withSession($this->session)->get(route("backend/routes/delete", array("val_0" => $route['id'])));
    }

}
