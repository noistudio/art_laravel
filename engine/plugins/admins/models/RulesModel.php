<?php

namespace admins\models;

use db\SqlDocument;
use plugsystem\models\NotifyModel;

class RulesModel {

    public static function add() {
        $post = request()->post();
        $name = null;
        if (isset($post['name']) and is_string($post['name'])) {
            $allowed = array(".", "-", "_");
            if (strlen($post['name']) >= 3 and strlen($post['name']) < 16 and ctype_alnum(str_replace($allowed, '', $post['name']))) {
                $name = $post['name'];
            }
        }
        if (is_null($name)) {
            \core\Notify::add(__("backend/admins.rul_not_fil_name"), "error");
            return false;
        }
        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {

            \core\Notify::add(__("backend/admins.rul_not_fil_title"), "error");
            return false;
        }

        $links = array();

        if (isset($post['links']) and is_string($post['links']) and strlen($post['links']) > 0) {
            $links = explode(",", $post['links']);
        }

        $res = SqlDocument::all("admin_access", "name", $name);
        $rules = \managers\backend\models\AdminRules::getAll();
        if (isset($rules[strtolower($name)])) {
            \core\Notify::add(__("backend/admins.rule_exists"), "error");

            return false;
        }

        if (!(isset($links) and is_array($links) and count($links) > 0)) {
            \core\Notify::add(__("backend/admins.rul_not_fil_links"), "error");

            return false;
        }



        $array = array();
        $array['title'] = strip_tags($post['title']);
        $array['name'] = strtolower($name);
        $array['links'] = $links;
        SqlDocument::insert($array, "admin_access");
        \core\Notify::add(__("backend/admins.op_success"), "error");
        return true;
    }

}
