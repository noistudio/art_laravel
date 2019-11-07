<?php

namespace builder\models;

use Lazer\Classes\Database as Lazer;
use yii\base\ExitException;
use yii\base\ErrorException;
use Exception;

class BuilderConf {

    static function all() {
        $rows = \db\JsonQuery:: all("builders");

        return $rows;
    }

    static function get($last_id, $isarray = true) {
        $row = \db\JsonQuery::get((int) $last_id, "builders");
        if (is_object($row)) {
            if ($isarray) {
                $result = array();
                $result['id'] = $row->id;
                $result['name'] = $row->name;
                $result['html'] = $row->html;
                $result['json'] = json_decode($row->json, true);
                if (!is_array($result['json'])) {
                    $result['json'] = array();
                }
                return $result;
            } else {
                return $row;
            }
        } else {
            return false;
        }
    }

    static function updateTitle($page) {
        $post = \yii::$app->request->post();

        if (isset($post['name']) and is_string($post['name']) and strlen($post['name']) > 1) {
            $page->name = strip_tags($post['name']);
            $page->save();
        }
    }

    static function add() {

        $post = request()->post();
        $isnew = false;
        $id = null;
        if (isset($post['fileName'])) {
            $exp = explode("builder/tmp/", $post['fileName']);
            if (isset($exp[1]) and $exp[1] == "new") {
                $isnew = true;
            } else if (is_numeric($exp[1])) {
                $isnew = false;
                $id = $exp[1];
            }
        }
        $table = null;
        if ($isnew == true) {
            $table = \db\JsonQuery::insert("builders");
        }
        if (!$isnew and ! is_null($id)) {
            $table = \db\JsonQuery::get((int) $id, "builders");
        }
        if (is_null($table)) {
            return false;
        }
        $html = "";








        if (isset($post['html'])) {
            $table->html = $post['html'];
        }
        if ($isnew) {
            $name = "Новая страница";
            $table->name = $name;
        }

        $table->json = "[]";
        $table->save();

        return $table->id;
    }

    static function update($table, $localstorage) {
        $post = request()->post();
        $html = "";

        if (isset($post['pages']) and count($post['pages'])) {
            foreach ($post['pages'] as $name => $content) {

                $html = $content;

                break;
            }
        }
        $obj = json_decode($localstorage, true);

        if (isset($post['name'])) {
            $table->name = strip_tags($post['name']);
        }


        $table->html = $html;
        $table->json = $localstorage;
        $table->save();
    }

    static function init() {
        try {
            \Lazer\Classes\Helpers\Validate::table('builders')->exists();
        } catch (Exception $ex) {
            $result = Lazer::create('builders', array(
                        'id' => 'integer',
                        'name' => 'string',
                        'html' => 'string',
                        'json' => 'string'
            ));
            //Database doesn't exist
        }
    }

}
