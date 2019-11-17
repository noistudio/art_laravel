<?php

namespace managers\frontend\models;

use mg\MongoQuery;
use mg\MongoHelper;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;

class CommentModel {

    public static function logout() {
        $session = request()->session();

        $session->forget("user_auth");
    }

    public static function auth() {
        $post = request()->post();
        if (isset($post['token'])) {
            $s = file_get_contents('http://ulogin.ru/token.php?token=' . $post['token'] . '&host=' . request()->server('HTTP_HOST'));
            $user = json_decode($s, true);

            if (is_array($user)) {

                request()->session()->put("user_auth", $user);
            }
        }
    }

    public static function add($post_row) {
        $user = CommentModel::getMy();
        $post = request()->post();

        if (!(isset($post['name']) or ( isset($post['name']) and ! is_string($post['name'])))) {
            $post['name'] = $user['first_name'];
        }
        if (strlen($post['name']) < 1) {
            $post['name'] = $user['first_name'];
        }
        if (!(isset($post['surname']) or ( isset($post['surname']) and ! is_string($post['surname'])))) {
            $post['surname'] = $user['last_name'];
        }
        if (strlen($post['surname']) < 1) {
            $post['surname'] = $user['last_name'];
        }
        $post['name'] = strip_tags($post['name']);
        $post['surname'] = strip_tags($post['surname']);
        if (!isset($post['comment'])) {
            \core\Notify::add("Вы не ввели текст комментария!", "error");

            return false;
        }
        if (isset($post['comment']) and ! is_string($post['comment'])) {
            \core\Notify::add("Вы не ввели текст комментария!", "error");
            return false;
        }
        $photo = $user['photo'];
        if (isset($post['type']) and $post['type'] == "nophoto") {
            $photo = false;
        }
        $_POST['comment'] = strip_tags($post['comment']);
        $_POST['comment'] = nl2br($post['comment']);
        $insert = array();
        $insert['user'] = $user;
        $insert['post'] = $post_row;
        $insert['photo'] = $photo;
        $insert['name'] = $post['name'];
        $insert['surname'] = $post['surname'];
        $insert['date'] = MongoHelper::date();
        $insert['comment'] = $post['comment'];
        $insert['enable'] = 0;
        MongoQuery::insert($insert, "comments");

        \core\Notify::add("Ваш комментарий успешно отправил,ожидайте когда он пройдет модерацию", "success");
    }

    public static function getMy() {
        $session = request()->session();
        $user_auth = session("user_auth");
        if (is_array($user_auth)) {
            return $user_auth;
        } else {
            return null;
        }
    }

    public static function isLogin() {

        $user_auth = session("user_auth");
        if (is_array($user_auth)) {
            return true;
        } else {
            return false;
        }
    }

}
