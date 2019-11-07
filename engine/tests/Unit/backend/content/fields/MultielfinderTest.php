<?php

namespace Tests\Unit\backend\content\fields;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class MultielfinderTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;
    public $full_path = null;
    public $web_path = null;
    public $field = null;

    public function setUp(): void {
        parent::setUp();
        if (\core\ManagerConf::isOnlyMongodb()) {
            $this->markTestSkipped('Тест пропущен,так как mysql отключен!');
        }

        $path = public_path() . "/" . env("APP_ELFINDER_FILES_PATH");
        $data = file_get_contents("https://via.placeholder.com/1000x1000.png");
        file_put_contents($path . "/test.png", $data);
        $this->full_path = $path . "/test.png";
        $this->web_path = "/" . env("APP_ELFINDER_FILES_PATH") . "/test.png";
        $this->field = new \content\fields\Multielfinder(array($this->web_path), "test", array('isimage' => true, 'row' => array('last_id' => 5)), false, "", "", $table = "news");
    }

    public function tearDown(): void {
        unlink($this->full_path);
        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function test_set() {

        $this->field->set();
    }

    public function test_getType() {
        $this->field->getType();
    }

    public function test_parse() {
        $row = array();
        $row['last_id'] = 5;
        $row['test_val'] = $this->field->set();
        $row['test'] = $row['test_val'];
        $result = array($row);

        $this->field->parse($result);
    }

    public function test_all() {
        $this->field->all();
    }

}
