<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DynamicRouteTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_route() {

        $route_model = new \core\DynamicRoute();

        $route_model->getRules();
    }

}
