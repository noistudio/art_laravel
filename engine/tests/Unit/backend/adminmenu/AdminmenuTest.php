<?php

namespace Tests\Unit\backend\adminmenu;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tests\TestCase;

class AdminmenuTest extends TestCase {

    public $admin_login = null;
    public $admin_password = null;

    public function setUp(): void {
        parent::setUp();
        \core\AppConfig::set("app.current_manager", "backend");
        $this->admin_login = \core\ManagerConf::get("admin_login", "backend");
        $this->admin_password = \core\ManagerConf::get("admin_password", "backend");
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFinderModel() {
        \adminmenu\models\FinderLinks::start();
    }

    public function testLinksModel() {

        \adminmenu\models\LinksModel::all();
    }

    public function testMenu_get() {
        \adminmenu\models\MenuModel::get();
    }

    public function testMenu_getResult() {
        \adminmenu\models\MenuModel::getResult();
    }

    public function testMenu_getStatus() {
        \adminmenu\models\MenuModel::getStatus();
    }

    public function testMenu_saveStatus() {
        \adminmenu\models\MenuModel::saveStatus();
    }

    public function testMenu_getLink() {
        \adminmenu\models\MenuModel::getLink(1, null);
    }

    public function testMenu_save() {

        $links = \adminmenu\models\MenuModel::get();
        \adminmenu\models\MenuModel::save($links);
    }

    public function testMenu_delete() {

        $links = \adminmenu\models\MenuModel::get();
        \adminmenu\models\MenuModel::delete(null, null);
    }

    public function testMenu_up() {

        $links = \adminmenu\models\MenuModel::get();
        \adminmenu\models\MenuModel::up(null);
    }

    public function testMenu_down() {

        $links = \adminmenu\models\MenuModel::get();
        \adminmenu\models\MenuModel::down(null);
    }

    public function testMenu_edit() {

        $links = \adminmenu\models\MenuModel::get();
        $links[0]['first_key'] = 0;
        \adminmenu\models\MenuModel::edit($links[0]);
    }

    public function testMenu_add() {

        $links = \adminmenu\models\MenuModel::get();

        \adminmenu\models\MenuModel::add();
    }

    public function testIndex() {
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/index'), [
            '_token' => csrf_token(),
        ]);
    }

    public function testStatusChange() {
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/savestatus'), [
            'status' => '1',
            '_token' => csrf_token(),
        ]);
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/savestatus'), [
            '_token' => csrf_token(),
        ]);
    }

    public function testManipuleteLink() {
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/addlink'), [
            'title' => 'testlink1',
            'link' => "test1",
            'icon' => "icon1",
            'nav' => '1',
            'name_rule' => '1',
            '_token' => csrf_token(),
        ]);
        $links = \adminmenu\models\MenuModel::get();

        $last = count($links) - 1;

        $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/edit', array('val_0' => $last, 'val_1' => 'null')), [
            '_token' => csrf_token(),
        ]);
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/editlink', array('val_0' => $last, 'val_1' => 'null')), [
            'title' => 'testlink1(after_edit)',
            'link' => "test2",
            'icon' => "icon1",
            'nav' => '1',
            'name_rule' => '1',
            '_token' => csrf_token(),
        ]);
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/arrows/down', array('val_0' => $last, 'val_1' => 'null')), [
            '_token' => csrf_token(),
        ]);
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/arrows/up', array('val_0' => $last, 'val_1' => 'null')), [
            '_token' => csrf_token(),
        ]);
        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/arrows/up', array('val_0' => $last, 'val_1' => 'null')), [
            '_token' => csrf_token(),
        ]);


        $response = $this->withSession(array('admin_is_login' => true, 'admin_login' => $this->admin_login, 'admin_password' => $this->admin_password, 'admin_is_root' => true))->post(route('backend/adminmenu/delete', array('val_0' => $last, 'val_1' => 'null')), [
            '_token' => csrf_token(),
        ]);
    }

}
