<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AbstractConfigTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testConfig() {


        $config = new \content\config();
        $config->isEnable();
    }

}
