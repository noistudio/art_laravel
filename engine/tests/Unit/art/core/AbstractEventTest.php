<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AbstractEventTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testConfig() {


        $event = new \core\AbstractEvent();

        $event->get();

        $event->set(array());
        $event->set(array(), "test");
    }

}
