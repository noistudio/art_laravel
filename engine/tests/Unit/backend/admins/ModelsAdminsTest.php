<?php

namespace Tests\Unit\backend\admins;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ModelsAdminsTest extends TestCase {

    public function testAdminAuth_check() {
        $req = $this->app['request'];
        $sessionProp = new \ReflectionProperty($req, 'session');
        $sessionProp->setAccessible(true);
        $sessionProp->setValue($req, $this->app['session']->driver('array'));
        request()->session()->put("bla_bla", "test");
        \admins\models\AdminAuth::check();
    }

    public function testAdminAuth_getMy() {
        $req = $this->app['request'];
        $sessionProp = new \ReflectionProperty($req, 'session');
        $sessionProp->setAccessible(true);
        $sessionProp->setValue($req, $this->app['session']->driver('array'));

        \admins\models\AdminAuth::getMy();
    }

    public function testAdminAuth_have() {
        $req = $this->app['request'];
        $sessionProp = new \ReflectionProperty($req, 'session');
        $sessionProp->setAccessible(true);
        $sessionProp->setValue($req, $this->app['session']->driver('array'));

        \admins\models\AdminAuth::have("blabla");
    }

    public function testAdminAuth_isLogin() {
        $req = $this->app['request'];
        $sessionProp = new \ReflectionProperty($req, 'session');
        $sessionProp->setAccessible(true);
        $sessionProp->setValue($req, $this->app['session']->driver('array'));
        \admins\models\AdminAuth::isLogin();
    }

    public function testAdminAuth_isRoot() {
        $req = $this->app['request'];
        $sessionProp = new \ReflectionProperty($req, 'session');
        $sessionProp->setAccessible(true);
        $sessionProp->setValue($req, $this->app['session']->driver('array'));
        \admins\models\AdminAuth::isRoot();
    }

    public function testAdminAuth_logout() {
        $req = $this->app['request'];
        $sessionProp = new \ReflectionProperty($req, 'session');
        $sessionProp->setAccessible(true);
        $sessionProp->setValue($req, $this->app['session']->driver('array'));
        \admins\models\AdminAuth::logout();
    }

    public function testAdminModel_doAdd() {
        \admins\models\AdminModel::doAdd();
    }

    public function testAdminModel_getQueryString() {
        \admins\models\AdminModel::getQueryString();
    }

    public function testAdminModel_rand_passwd() {
        \admins\models\AdminModel::rand_passwd();
    }

    public function testAdminModel_getAll() {
        \admins\models\AdminModel::getAll();
    }

    public function testAdminModel_getAccess() {
        \admins\models\AdminModel::getAccess();
    }

    public function testAdminModel_updatePassword() {
        \admins\models\AdminModel::updatePassword(null);
    }

    public function testAdminModel_update() {
        \admins\models\AdminModel::update(null, null);
    }

    public function testRulesModel_add() {
        \admins\models\RulesModel::add();
    }

}
