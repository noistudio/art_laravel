<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppEnvTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_env() {

        $APP_NAME = env("APP_NAME");
        \core\AppEnv::all();
        \core\AppEnv::save(array('APP_NAME' => 'asdasdasd'));
        \core\AppEnv::save(array('APP_NAME' => $APP_NAME));
    }

}
