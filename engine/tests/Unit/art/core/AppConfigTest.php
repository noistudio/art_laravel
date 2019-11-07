<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppConfigTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_set() {


        \core\AppConfig::set("param", null);
    }

    public function test_get() {


        \core\AppConfig::get("param");
    }

    public function test_is_exists() {
        \core\AppConfig::is_exists("backend");
        \core\AppConfig::is_exists("frontend");
        $result = \core\AppConfig::is_exists("backend43");
        if ($result) {
            $this->fail("Должен был вернуть false");
        }
    }

    public function test_currentManager() {
        \core\AppConfig::currentManager();
    }

}
