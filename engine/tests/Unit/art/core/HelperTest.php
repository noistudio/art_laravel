<?php

namespace Tests\Unit\art\core;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelperTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_route() {

        $object = new \stdClass();
        $object->key1 = "key1";
        $object->key2 = "key2";
        \core\Helper::toArray($object);
    }

}
