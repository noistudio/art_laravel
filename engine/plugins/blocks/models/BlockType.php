<?php

namespace blocks\models;

use routes\models\RoutesModel;
use yii\db\Connection;
use Yii;
use yii\db\Query;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;

class BlockType {

    static function render() {
        BlockType::runOther();
    }

    static function runOther() {
        \setup\models\SampleModel::check();
    }

    static function getById($id) {

        $result = null;
        $array = \content\models\TableConfig::eventTypes();

        if (isset($array) and is_array($array) and count($array)) {
            foreach ($array as $item) {
                if ($item['id'] == $id) {
                    $result = $item;
                    break;
                }
            }
        }
        return $result;
    }

    static function validate($id, $params, $old_params = array()) {
        $type = BlockType::getById($id);

        $result = array();
        $block = BlocksModel::get($id);
        if (is_array($type)) {
            $class = $type['class'];
            $op = $type['op'];
            $value = $type['value'];


            $obj = new $class($op, $value, $params, $block);
            $obj->setOldParams($old_params);
            $result = $obj->validate();

            if (is_null($result)) {

                \core\Notify::add($obj->getError(), "error");
                $result = null;
            }
        }

        return $result;
    }

    static function showAdd($id, $block = array()) {
        if (is_array($id)) {
            $type = $id;
            $id = $type['id'];
        } else {
            $type = BlockType::getById($id);
        }



        $result = "";
        if (is_array($type)) {
            $class = $type['class'];
            $op = $type['op'];
            $value = $type['value'];

            $obj = new $class($op, $value, array(), $block);
            $result = $obj->show('add');
        }
        return $result;
    }

    static function showEdit($id, $params = array(), $block = array()) {
        if (is_array($id)) {
            $type = $id;
            $id = $type['id'];
        } else {
            $type = BlockType::getById($id);
        }


        $result = "";


        if (is_array($type)) {
            if ($type['id'] != "html") {
                $class = $type['class'];
                $op = $type['op'];
                $value = $type['value'];

                $obj = new $class($op, $value, $params, $block);
                $result = $obj->show('edit');
            }
        }
        return $result;
    }

    static function run($block, $user_params = array()) {
        $result = "";
        if (is_array($block['type_arr'])
                and isset($block['type_arr']['class'])
                and isset($block['type_arr']['op'])
                and isset($block['type_arr']['value']) and class_exists($block['type_arr']['class'])) {
            $class = $block['type_arr']['class'];
            $op = $block['type_arr']['op'];
            $value = $block['type_arr']['value'];
            if (is_array($user_params) and count($user_params)) {
                $block['params'] = array_merge($block['params'], $user_params);
            }
            $obj = new $class($op, $value, $block['params'], $block);
            $result = $obj->run();
        }

        return $result;
    }

}
