<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagerConfTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_plugins_path() {
        \core\ManagerConf::plugins_path();
    }

    public function test_isMongodb() {
        \core\ManagerConf::isMongodb();
    }

    public function test_isOnlyMongodb() {
        \core\ManagerConf::isOnlyMongodb();
    }

    public function test_render_path() {
        \core\ManagerConf::render_path("backend", false);
        \core\ManagerConf::render_path("backend", true);
        \core\ManagerConf::render_path("frontend", false);
        \core\ManagerConf::render_path("frontend", true);
    }

    public function test_get() {
        \core\ManagerConf::get('theme_path', "frontend");
        \core\ManagerConf::get('theme_path', "backend");
        \core\ManagerConf::get('theme_path3', "frontend");
    }

    public function test_getTemplateFolder() {
        \core\ManagerConf::getTemplateFolder(true, "backend");
        \core\ManagerConf::getTemplateFolder(false, "backend");
        \core\ManagerConf::getTemplateFolder(true, "frontend");
        \core\ManagerConf::getTemplateFolder(false, "frontend");
    }

    public function test_link() {
        \core\ManagerConf::link("sdfdsfdsf");
    }

    public function test_getUrl() {
        \core\ManagerConf::getUrl("frontend");
        \core\ManagerConf::getUrl("backend");
    }

    public function test_redirect() {
        \core\ManagerConf::redirect("/sdfsdfsdf");
    }

    public function test_current() {
        \core\ManagerConf::current();
    }

}
