<?php

namespace Tests\Unit\backend\languages\models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class LanguageHelpTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;
    public $session = null;

    public function testGetDefault() {
        \languages\models\LanguageHelp::getDefault();
    }

    public function testSet() {
        \languages\models\LanguageHelp::set("ru");
        \languages\models\LanguageHelp::set(null);
        \languages\models\LanguageHelp::set();
    }

    public function testIs() {
        \languages\models\LanguageHelp::is();
    }

    public function testGetAll() {
        \languages\models\LanguageHelp::getAll();
    }

}
