<?php

namespace Tests\Unit\art\db;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JsonQueryTest extends TestCase {

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_manipulate() {

        $array = array();
        $array['id'] = 1;
        $array['channel'] = "ch";
        $array['level'] = "level";
        $array['params'] = "params";
        $array['status'] = "status";



        $tmp = \db\JsonQuery::save($array, "logs");
        \db\JsonQuery::get($tmp->id, "logs", "id");
        \db\JsonQuery::all("logs");
        \db\JsonQuery::delete($tmp->id, "id", "logs");
    }

}
