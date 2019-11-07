<?php

namespace admins\models;

use db\SqlDocument;
use core\AppConfig;

class AdminModel {

    static function getQueryString() {
        $manager_url = \core\ManagerConf::getUrl();


        $result = str_replace($manager_url, "", "/" . \Request::path());
        return $result;
    }

    public static function doAdd() {
        $access = AdminModel::getAccess();

        $post = request()->post();
        $post_access = null;
        if (isset($post['access']) and is_array($post['access']) and count($post['access']) > 0) {
            foreach ($post['access'] as $h => $ac) {
                if (!isset($access[$ac])) {
                    unset($post['access'][$h]);
                }
            }
            $post_access = array_values($post['access']);
        }
        $name = null;
        if (isset($post['login']) and is_string($post['login'])) {
            $allowed = array(".", "-", "_");
            if (strlen($post['login']) >= 3 and strlen($post['login']) < 16 and ctype_alnum(str_replace($allowed, '', $post['login']))) {
                $name = $post['login'];
            }
        }
        if (is_null($name)) {
            \core\Notify::add(__("backend/admins.not_filled_login"), "error");
            return false;
        }
        if (!(isset($post['password']) and is_string($post['password']) and strlen($post['password']))) {
            \core\Notify::add(__("backend/admins.not_filled_password"), "error");
            return false;
        }
        if (!(isset($post_access) and is_array($post_access) and count($post_access) > 0)) {
            \core\Notify::add(__("backend/admins.not_filled_access"), "error");

            return false;
        }
        $res = SqlDocument::all("admins", "login", $name);
        if (count($res) > 0) {
            \core\Notify::add(__("backend/admins.login_exist"), "error");

            return false;
        }
        $insert = array();
        $insert['login'] = strtolower($name);

        $insert['salt'] = AdminModel::rand_passwd();
        $insert['password'] = hash("sha512", $post['password'] . "" . $insert['salt']);
        $insert['access'] = $post_access;
        SqlDocument::insert($insert, "admins");

        \core\Notify::add(__("backend/admins.admin_add_in_system"), "success");
        return false;
    }

    public static function rand_passwd($length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
        return substr(str_shuffle($chars), 0, $length);
    }

    public static function getAll() {
        $rows = SqlDocument::all("admins");


        $access = AdminModel::getAccess();
        if (count($rows)) {
            foreach ($rows as $key => $row) {
                if (count($access)) {
                    foreach ($row['access'] as $kk => $ac) {
                        if ($access[$ac]) {
                            $row['access'][$kk] = $access[$ac]['title'];
                        }
                    }
                }


                $rows[$key] = $row;
            }
        }
        return $rows;
    }

    public static function getAccess() {

        return \managers\backend\models\AdminRules::getAll();
    }

    public static function updatePassword($admin) {
        $post = request()->post();
        $admin_key = $admin['id_key'];
        if (isset($admin['id_key'])) {
            unset($admin['id_key']);
        }

        if ((isset($post['edit_password']) and is_string($post['edit_password']) and strlen($post['edit_password']) > 2) and isset($post['edit_password_2']) and $post['edit_password'] == $post['edit_password_2']) {
            $admin['salt'] = AdminModel::rand_passwd();
            $admin['password'] = hash("sha512", $post['edit_password'] . "" . $admin['salt']);

            request()->session()->put("admin_password", $post['edit_password']);

            //  \db\AuthHelper::delete();
            //  SqlDocument::update($admin, "admins", $admin_key);
            //  $array_to_cookies = array('admin_is_root' => false, 'admin_is_login' => true, 'admin_login' => $admin['login'], 'admin_password' => $post['edit_password']);
            // \db\AuthHelper::doAdd($array_to_cookies);



            \core\Notify::add(__("backend/admins.password_is_change"), "success");
            return true;
        } else {
            \core\Notify::add(__("backend/admins.password_not_match"), "error");


            return false;
        }
    }

    public static function update($admin, $admin_key) {
        $access = AdminModel::getAccess();

        $post = request()->post();
        $post_access = null;
        if (isset($post['access']) and is_array($post['access']) and count($post['access']) > 0) {
            foreach ($post['access'] as $h => $ac) {
                if (!isset($access[$ac])) {
                    unset($post['access'][$h]);
                }
            }
            $post_access = array_values($post['access']);
        }
        $name = null;
        if (isset($post['login']) and is_string($post['login'])) {
            $allowed = array(".", "-", "_");
            if (strlen($post['login']) >= 3 and strlen($post['login']) < 16 and ctype_alnum(str_replace($allowed, '', $post['login']))) {
                $name = $post['login'];
            }
        }

        if ((isset($post['password']) and is_string($post['password']) and strlen($post['password']) > 2)) {
            $admin['salt'] = AdminModel::rand_passwd();
            $admin['password'] = hash("sha512", $post['password'] . "" . $admin['salt']);
        }
        if ((isset($post_access) and is_array($post_access) and count($post_access) > 0)) {
            $admin['access'] = $post_access;
        }
        if (!is_null($name)) {
            $res = SqlDocument::all("admins", "login", $name);
            if (count($res) == 0) {
                $admin['login'] = $name;
            }
        }


        SqlDocument::update($admin, "admins", $admin_key);

        \core\Notify::add(__("backend/admins.datas_updated"), "success");


        return false;
    }

}
