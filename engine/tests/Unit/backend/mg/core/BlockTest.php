<?php

namespace Tests\Unit\backend\mg\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class BlockTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $model = null;
    public $collection = "phpunit";
    public $rows = null;
    public $block_list = null;
    public $block_list_model = null;
    public $block_one = null;
    public $block_one_model = null;

    public function setUp(): void {
        parent::setUp();
        if (class_exists("\\mg\\config")) {
            $this->collection = $this->collection;
            \core\AppConfig::set("app.current_manager", "backend");
            $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
            $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
            $this->session = array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true);


            $post = array();
            $post['name'] = $this->collection;
            $post['title'] = $this->collection;
            $post['count'] = 20;
            $post['fields'] = array(
                array(
                    'type' => 'Stroka',
                    'name' => 'title',
                    'title' => 'title',
                    'showinlist' => 1,
                )
            );



            $result = $this->withSession($this->session)->post(route("backend/mg/collections/ajaxadd"), $post)->decodeResponseJson();

            if (!(isset($result['type']) and $result['type'] == "success")) {


                $this->fail("Ответ должен быть success");
            }

            $max = 5;
            $i = 0;
            $this->rows = array();
            while ($i < $max) {
                $array_insert = array();
                $array_insert['enable'] = 1;
                $array_insert['title'] = "title" . $i;

                $array_insert = \mg\MongoQuery::insert($array_insert, $this->collection);

                $this->rows[] = $array_insert;

                $i++;
            }
            $type = $this->collection . "_list";

            $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                        'type' => $type,
                        'param' => array('order_field' => 'arrow_sort'),
                        'title' => $this->collection . "_list",
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
                $type = $this->collection . "_one_" . $row['last_id'];
                $response = $this->withSession($this->session)->post(route('backend/blocks/add/ajaxadd'), [
                            'type' => $type,
                            'title' => $this->collection . "_one",
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

            $path_list = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/" . $this->collection . "_list.php";
            $path_one = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/" . $this->collection . "_one.php";
            file_put_contents($path_list, "<h2>dsfsdfsdfsdf</h2>");
            file_put_contents($path_one, "<h2>dsfsdfsdfsdf</h2>");
        }
    }

    public function tearDown(): void {
        if (class_exists("\\mg\\config")) {
            $path_list = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/" . $this->collection . "_list.php";
            $path_one = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/" . $this->collection . "_one.php";

            unlink($path_list);
            unlink($path_one);


            \mg\MongoQuery::delete($this->collection, array());

            \db\JsonQuery::delete((int) $this->block_list['id'], "id", "blocks");
            \db\JsonQuery::delete((int) $this->block_one['id'], "id", "blocks");

            $this->withSession($this->session)->get(route("backend/mg/collections/delete", array("val_0" => $this->collection)));
            $connection = Env("DB_CONNECTION");
            \DB::disconnect($connection);
        }
        parent::tearDown();
    }

    public function testAddPage() {
        if (class_exists("\\mg\\config")) {
            $this->block_list_model->addPage();
            $this->block_one_model->addPage();
        }
    }

    public function testEditPage() {
        if (class_exists("\\mg\\config")) {
            $this->block_list_model->editPage();
            $this->block_one_model->editPage();
        }
    }

    public function testRun() {
        if (class_exists("\\mg\\config")) {
            \core\AppConfig::set("app.current_manager", "frontend");
            $this->block_list_model->run();
            $this->block_one_model->run();
            \core\AppConfig::set("app.current_manager", "backend");
        }
    }

    public function testValidate() {
        if (class_exists("\\mg\\config")) {
            $this->block_list_model->validate();
            $this->block_one_model->validate();
        }
    }

}
