<?php

namespace Tests\Unit\backend\content\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ContentBlockTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $model = null;
    public $table = "phpunit_mysql";
    public $rows = null;
    public $block_list = null;
    public $block_list_model = null;
    public $block_one = null;
    public $block_one_model = null;

    public function setUp(): void {
        parent::setUp();
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }
        $this->table = $this->table;
        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
        $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);


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

        $max = 5;
        $rows = array();
        $i = 0;
        while ($i < $max) {

            $array_insert = array();
            $array_insert['enable'] = 1;
            $array_insert['title'] = "title" . rand(0, 9999);
            $array_insert['last_id'] = \db\SqlQuery::insert($array_insert, $this->table);

            $update = array('sort' => $array_insert['last_id']);
            \db\SqlQuery::update($this->table, $update, "last_id=" . $array_insert['last_id']);
            $rows[] = $array_insert;
            $i++;
        }
        $this->rows = $rows;

        $type = $this->table . "_list";
        \core\AppConfig::set("app.block_types", "");
        $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                    'type' => $type,
                    'param' => array('order_field' => 'arrow_sort'),
                    'title' => $this->table . "_list",
                    '_token' => csrf_token(),
                ])->decodeResponseJson();
        $this->block_list = \blocks\models\BlocksModel::get($response['block_id'], true);


        $class = $this->block_list['type_arr']['class'];
        $op = $this->block_list['type_arr']['op'];
        $value = $this->block_list['type_arr']['value'];
        //  $this->block_list['params'] = array('postfix_template' => "", "order_field" => 'arrow_sort');

        $obj = new $class($op, $value, $this->block_list['params'], $this->block_list);
        $this->block_list_model = $obj;

        foreach ($this->rows as $row) {
            \core\AppConfig::set("app.block_types", "");
            $type = $this->table . "_one_" . $row['last_id'];
            $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                        'type' => $type,
                        'title' => $this->table . "_one",
                        '_token' => csrf_token(),
                    ])->decodeResponseJson();



            $this->block_one = \blocks\models\BlocksModel::get($response['block_id'], true);

            $class = $this->block_one['type_arr']['class'];
            $op = $this->block_one['type_arr']['op'];
            $value = $this->block_one['type_arr']['value'];
            //  $this->block_one['params'] = array('postfix_template' => "", "order_field" => 'arrow_sort');


            $obj = new $class($op, $value, $this->block_one['params'], $this->block_one);
            $this->block_one_model = $obj;
            break;
        }

        $path_list = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $this->table . "_list.php";
        $path_one = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $this->table . "_one.php";
        file_put_contents($path_list, "<h2>dsfsdfsdfsdf</h2>");
        file_put_contents($path_one, "<h2>dsfsdfsdfsdf</h2>");
    }

    public function tearDown(): void {

        $path_list = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $this->table . "_list.php";
        $path_one = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $this->table . "_one.php";

        unlink($path_list);
        unlink($path_one);

        \db\JsonQuery::delete((int) $this->block_list['id'], "id", "blocks");
        \db\JsonQuery::delete((int) $this->block_one['id'], "id", "blocks");

        $this->withSession($this->session)->post(route('backend/content/tables/delete'), array('table' => $this->table));


        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);

        parent::tearDown();
    }

    public function testAddPage() {

        $this->block_list_model->addPage();
        $this->block_one_model->addPage();
    }

    public function testEditPage() {

        $this->block_list_model->editPage();
        $this->block_one_model->editPage();
    }

    public function testRun() {

        \core\AppConfig::set("app.current_manager", "frontend");
        $this->block_list_model->run();
        $this->block_one_model->run();
        \core\AppConfig::set("app.current_manager", "backend");
    }

    public function testValidate() {

        $this->block_list_model->validate();
        $this->block_one_model->validate();
    }

}
