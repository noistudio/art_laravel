<?php

namespace admins\models;

use db\SqlDocument;

class AdminAuth {

    public static function logout() {

        request()->session()->forget("admin_is_login");
        request()->session()->forget("admin_login");
        request()->session()->forget("admin_password");
        \Cookie::queue(\Cookie::forget('admin_auth'));
        // $cookies = Yii::$app->response->cookies;
        //$cookies->remove('cokie_backend');
    }

    static function getMy() {

        $session = request()->cookie('admin_auth');
        $session = json_decode($session, true);


        if (isset($session) and isset($session['admin_login'])) {
            $admin_login = $session['admin_login'];
            $admins_data = SqlDocument::one("admins", "login", $admin_login, true);
            return $admins_data;
        }
        return null;
    }

    public static function isLogin() {

        $session = request()->cookie('admin_auth');
        $session = json_decode($session, true);




        $status = null;
        if (isset($session['admin_is_login'])) {
            $status = $session['admin_is_login'];
        }


        $admin_login = null;
        if (isset($session['admin_login'])) {
            $admin_login = $session['admin_login'];
        }

        $admin_password = null;
        if (isset($session['admin_password'])) {
            $admin_password = $session['admin_password'];
        }
        $option = array();
        $option['admin_login'] = \core\ManagerConf::get("admin_login", "backend");
        $option['admin_password'] = \core\ManagerConf::get("admin_password", "backend");








        if (isset($option['admin_password']) and isset($option['admin_login'])
                and isset($admin_login) and isset($admin_password) and $option['admin_password'] == $admin_password and $option['admin_login'] == $admin_login) {
            return true;
        } else {
            if (isset($admin_login) and isset($admin_password)) {

                $admins_data = SqlDocument::one("admins", "login", $admin_login);


                if (isset($admins_data) and is_array($admins_data) and isset($admins_data['password'])) {

                    $hash_password = hash("sha512", $admin_password . $admins_data['salt']);

                    if ($admins_data['login'] == $admin_login and $admins_data['password'] == $hash_password) {
                        return true;
                    }
                }
            }
        }
        AdminAuth::logout();
        return false;
    }

    public static function have($name_access) {

        $option = array();
        $option['admin_login'] = \core\ManagerConf::get("admin_login", "backend");
        $option['admin_password'] = \core\ManagerConf::get("admin_password", "backend");
        $session = request()->cookie('admin_auth');
        $session = json_decode($session, true);
        $status = null;
        if (isset($session['admin_is_login'])) {
            $status = $session['admin_is_login'];
        }

        $admin_login = null;
        if (isset($session['admin_login'])) {
            $admin_login = $session['admin_login'];
        }

        $admin_password = null;
        if (isset($session['admin_password'])) {
            $admin_password = $session['admin_password'];
        }

        if (isset($option['admin_password']) and isset($option['admin_login'])
                and isset($admin_login) and isset($admin_password) and $option['admin_password'] == $admin_password and $option['admin_login'] == $admin_login) {
            return true;
        } else {
            if (isset($admin_login) and isset($admin_password)) {
                $admins_data = SqlDocument::one("admins", "login", $admin_login);
                if (isset($admins_data) and is_array($admins_data)) {
                    $hash_password = hash("sha512", $admin_password . $admins_data['salt']);

                    if ($admins_data['login'] == $admin_login and $admins_data['password'] == $hash_password) {
                        if (in_array($name_access, $admins_data['access'])) {
                            return true;
                        } elseif (in_array("all", $admins_data['access'])) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    static function isRoot() {
        $session = request()->cookie('admin_auth');
        $session = json_decode($session, true);
        $is_root = null;
        if (isset($session['admin_is_root'])) {
            $is_root = $session['admin_is_root'];
        }


        if (is_bool($is_root)) {
            return $is_root;
        } else {
            return false;
        }
    }

    public static function check() {
        $post = request()->post();


        $option = array();
        $option['admin_login'] = \core\ManagerConf::get("admin_login", "backend");

        $option['admin_password'] = \core\ManagerConf::get("admin_password", "backend");
        $result = false;
        if (isset($post['login']) and isset($post['password'])) {
            if (isset($option['admin_password']) and isset($option['admin_login']) and isset($post['login']) and $post['login'] == $option['admin_login'] and isset($post['password']) and $post['password'] == $option['admin_password']) {


                $admin_auth_data = array();
                $admin_auth_data['admin_is_login'] = true;
                $admin_auth_data['admin_login'] = $post['login'];
                $admin_auth_data['admin_password'] = $post['password'];
                $admin_auth_data['admin_is_root'] = true;
                $admin_auth_data = json_encode($admin_auth_data);
                $minutes = (60 * 24) * 365;

                \Cookie::queue(\Cookie::make('admin_auth', $admin_auth_data, $minutes));


                //$array_to_cookies = array('admin_is_root' => true, 'admin_is_login' => true, 'admin_login' => $post['login'], 'admin_password' => $post['password']);
                // AuthHelper::doAdd($array_to_cookies);
                $result = true;
            } else {
                $admins_data = SqlDocument::one("admins", "login", $post['login']);

                if (isset($admins_data) and is_array($admins_data) and isset($admins_data['login'])) {



                    if ($admins_data['login'] == $post['login']) {
                        $hash_password = hash("sha512", $post['password'] . "" . $admins_data['salt']);

                        if ($admins_data['password'] == $hash_password) {

                            $admin_auth_data = array();
                            $admin_auth_data['admin_is_login'] = true;
                            $admin_auth_data['admin_login'] = $post['login'];
                            $admin_auth_data['admin_password'] = $post['password'];


                            $admin_auth_data = json_encode($admin_auth_data);

                            $minutes = (60 * 24) * 365;

                            \Cookie::queue(\Cookie::make('admin_auth', $admin_auth_data, $minutes));


                            //     $session->set("admin_is_root", false);
                            // $array_to_cookies = array('admin_is_root' => false, 'admin_is_login' => true, 'admin_login' => $post['login'], 'admin_password' => $post['password']);
                            // AuthHelper::doAdd($array_to_cookies);
                            $result = true;
                        }
                    }
                }
            }
        }



        return $result;
    }

}
