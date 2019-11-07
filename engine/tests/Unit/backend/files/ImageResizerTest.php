<?php

namespace Tests\Unit\backend\files\controllers\backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ImageResizerTest extends TestCase {

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
        $path = public_path() . "/" . env("APP_PATH_RESIZE_FOLDER");
        $files = scandir($path);
        if (count($files)) {
            foreach ($files as $file) {
                $file_path = $path . "/" . $file;
                if (\files\ImageResizer::is_image($file_path)) {
                    unlink($file_path);
                }
            }
        }
        $connection = Env("DB_CONNECTION");
        \DB::disconnect($connection);
        parent::tearDown();
    }

    public function testIsImage() {

        $path = public_path() . "/" . env("APP_ELFINDER_FILES_PATH");
        $data = file_get_contents("https://via.placeholder.com/1000x1000.png");
        file_put_contents($path . "/test.png", $data);
        $url = "/" . env("APP_ELFINDER_FILES_PATH") . "/test.png";
        \files\ImageResizer::is_image($path . "/test.png");
        unlink($path . "/test.png");
    }

    public function testResize() {
        $path = public_path() . "/" . env("APP_ELFINDER_FILES_PATH");
        $data = file_get_contents("https://via.placeholder.com/1000x1000.png");
        file_put_contents($path . "/test.png", $data);
        $url = "/" . env("APP_ELFINDER_FILES_PATH") . "/test.png";
        \files\ImageResizer::is_image($path . "/test.png");
        $result = \files\ImageResizer::resize($url, 500);
        $result = \files\ImageResizer::resize($url, 500, 400);

        unlink($path . "/test.png");
    }

    public function testCrop() {

        $path = public_path() . "/" . env("APP_ELFINDER_FILES_PATH");
        $data = file_get_contents("https://via.placeholder.com/1000x1000.png");
        file_put_contents($path . "/test.png", $data);
        $url = "/" . env("APP_ELFINDER_FILES_PATH") . "/test.png";
        \files\ImageResizer::is_image($path . "/test.png");
        $result = \files\ImageResizer::crop($url, 500, 300);
        $result = \files\ImageResizer::resize($url, 200, 400);

        unlink($path . "/test.png");
    }

}
