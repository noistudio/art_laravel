<?php

namespace Tests\Unit\backend\content;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class routeTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $table = "phpunit_mysql";

    public function setUp(): void {
        parent::setUp();
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }
        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);
    }

    public function testBackendRoutes() {


        //создание таблицы для последующей работы с ней.
        $this->withSession($this->session)->get(route('backend/content/tables/index'));
        $this->withSession($this->session)->get(route('backend/content/tables'));
        $this->withSession($this->session)->get(route('backend/content/tables/select'));

        $this->withSession($this->session)->get(route('backend/content/tables/add'));

        $post = array();
        $post['name'] = $this->table;
        $post['title'] = $this->table;
        $post['count'] = 20;
        $post['fields'] = array(
            array(
                'type' => 'Stroka',
                'name' => 'title',
                'title' => 'title1',
                'showinlist' => 1,
                'required' => 1
            )
        );

        $result = $this->withSession($this->session)->post(route('backend/content/tables/ajaxadd'), $post)->decodeResponseJson();
        if (!(isset($result['type']) and $result['type'] == "success" )) {
            fwrite(STDERR, print_r($result));
            $this->fail("В ответе type должен быть success");
        }

        $this->withSession($this->session)->get(route("backend/content/tables/edit", array("val_0" => $this->table)));


        $post_update = array();
        $post_update['name'] = $this->table;
        $post_update['title'] = $this->table;
        $post_update['count'] = 20;
        $post_update['fields'] = array(
            "title" => array(
                'type' => 'Stroka',
                'name' => 'title',
                'title' => 'title1',
                'showinlist' => 1,
                'required' => 1
            )
        );
        $post_update['newfields'] = array(
            array(
                'type' => 'Stroka',
                'name' => 'title2',
                'title' => 'title2',
                'showinlist' => 1,
                'required' => 1
            )
        );
        $result = $this->withSession($this->session)->post(route('backend/content/tables/ajaxedit', array("val_0" => $this->table)), $post_update)->decodeResponseJson();

        if (!(isset($result['type']) and $result['type'] == "success" )) {
            $this->fail("В ответе type должен быть success");
        }

        $this->withSession($this->session)->get(route('backend/content/tables/deletefield', array('val_0' => $this->table, 'val_1' => 'title2')));


        $this->withSession($this->session)->get(route('backend/content/tables/field', array('val_0' => 'Stroka', 'val_1' => 0)));
        $this->withSession($this->session)->get(route('backend/content/tables/field', array('val_0' => 'Stroka', 'val_1' => 1)));

        $max = 5;
        $rows = array();
        $i = 0;
        while ($i < $max) {

            $array_insert = array();
            $array_insert['title'] = "title" . rand(0, 9999);
            $array_insert['last_id'] = \db\SqlQuery::insert($array_insert, $this->table);
            $rows[] = $array_insert;
            $i++;
        }


        $this->withSession($this->session)->get(route('backend/content/manage/index', array('val_0' => $this->table)));
        $this->withSession($this->session)->get(route('backend/content/manage', array('val_0' => $this->table)));
        $this->withSession($this->session)->get(route('backend/content/manage/add', array('val_0' => $this->table)));

        $post_insert = array();
        $post_insert['title'] = "title added";
        $post_insert['enable'] = 1;

        $result_insert = $this->withSession($this->session)->post(route('backend/content/manage/doadd', array('val_0' => $this->table)), $post_insert)->decodeResponseJson();



        if (!(isset($result_insert['type']) and $result_insert['type'] == "success" )) {
            $this->fail("В ответе type должен быть success");
        }

        if (!(isset($result_insert['last_id']) )) {
            $this->fail("В ответе должен быть ключ last_id");
        }



        $this->withSession($this->session)->get(route('backend/content/manage/update', array('val_0' => $this->table, 'val_1' => $result_insert['last_id'])));

        $result_update = $this->withSession($this->session)->post(route('backend/content/manage/doupdate', array('val_0' => $this->table, 'val_1' => $result_insert['last_id'])), $post_insert)->decodeResponseJson();
        if (!(isset($result['type']) and $result['type'] == "success" )) {
            $this->fail("В ответе type должен быть success");
        }


        $this->withSession($this->session)->get(route('backend/content/manage/enable', array('val_0' => $this->table, 'val_1' => $result_insert['last_id'])));

        $post_op = array();
        $post_op['op'] = "disable";
        $post_op['ids'] = array();
        $post_op['ids'][] = $result_insert['last_id'];


        foreach ($rows as $row) {
            $post_op['ids'][] = $row['last_id'];
        }

        $this->withSession($this->session)->post(route('backend/content/manage/ops', array('val_0' => $this->table)), $post_op);

        $post_op['op'] = "enable";
        $this->withSession($this->session)->post(route('backend/content/manage/ops', array('val_0' => $this->table)), $post_op);
        $post_op['op'] = "delete";
        $this->withSession($this->session)->post(route('backend/content/manage/ops', array('val_0' => $this->table)), $post_op);


        $this->withSession($this->session)->get(route('backend/content/template/list', array('val_0' => $this->table)));
        $this->withSession($this->session)->get(route('backend/content/template/one', array('val_0' => $this->table)));
        $this->withSession($this->session)->get(route('backend/content/template/rss', array('val_0' => $this->table)));
        $this->withSession($this->session)->post(route('backend/content/tables/delete'), array('table' => $this->table));
    }

}
