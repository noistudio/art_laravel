<?php

namespace Tests\Unit\backend\languages\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class LanguageParseTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;

    public function testStartList() {
        \languages\models\LanguageParse::start_list(null, "test");
        \languages\models\LanguageParse::start_list(array(), "test");
    }

    public function testStartOne() {
        \languages\models\LanguageParse::start_one(null, "test");
        \languages\models\LanguageParse::start_one(array(), "test");
    }

}
