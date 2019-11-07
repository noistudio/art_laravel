<?php

namespace mg\models;

use Yii;
use yii\db\Query;

class GetCollections {

    static function replace_action($document, $html) {

        if (is_null($html)) {
            return $html;
        }
        $json = json_decode($document['action'], true);
        $action_html = "";
        if (is_array($json)) {
            $action_html = call_user_func($json['namespace'] . '::' . $json['static_method'], $json, $document['uid'], $document);
            if (!is_string($action_html)) {
                $action_html = "";
            }
        }
        $html = str_replace("{action}", $action_html, $html);
        return $html;
    }

    static function one($nametable, $id) {


        $result = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id, 'enable' => 1));
        $table = \db\JsonQuery::get($nametable, "collections", "name");
        $sort = GetCollections::orderby($table);
        $left = null;
        $right = null;
        if (is_array($result) and isset($result[$table->sort_field])) {
            $left = \mg\MongoQuery::get($nametable, array($table->sort_field => array('$lt' => $result[$table->sort_field])), array($table->sort_field => -1));
        }
        if (is_array($result) and isset($result[$table->sort_field])) {
            $right = \mg\MongoQuery::get($nametable, array($table->sort_field => array('$gt' => $result[$table->sort_field])), array($table->sort_field => 1));
        }

        if (is_array($result)) {
            if (is_array($left)) {
                $result['left_document'] = $left;
            }
            if (is_array($right)) {
                $result['right_document'] = $right;
            }
        }
        return $result;
    }

    static function block($nametable, $condition = null, $limit = null, $orderby = null) {
        $table = \db\JsonQuery::get($nametable, "collections", "name");

        $paginator = new \core\Paginator;

        $result_rows = array();

        if (isset($condition) and is_array($condition) and count($condition) > 0) {
            
        } else {
            $condition = array('enable' => 1);
        }
        $count = \mg\MongoQuery::count($nametable, $condition);

        if (!is_null($limit) and is_numeric($limit) and (int) $limit > 0) {
            $limit = (int) $limit;
        }

        $offset = $paginator->get();

        if (isset($orderby) and is_array($orderby) and count($orderby) > 0) {
            
        } else {
            $orderby = GetCollections::orderby($table);
        }

        if (is_numeric($limit)) {
            $rows = \mg\MongoQuery::execute($nametable, $condition, $orderby, $limit, $offset);
        } else {
            $rows = \mg\MongoQuery::all($nametable, $condition, $orderby);
        }
// build and execute the query
//        echo $query->createCommand()->rawSql;
//        exit;





        $result = array();
        $result['rows'] = $rows;
        $result['count'] = $count;
        $result['current'] = 0;

        $result['current'] = (int) $table->count + $offset;

        $result['pages'] = $paginator->show($result['count'], $offset, (int) $table->count);
        return $result;
    }

    static function all($nametable) {
        $table = \db\JsonQuery::get($nametable, "collections", "name");

        $paginator = new \core\Paginator;

        $result_rows = array();
        $query = new Query;
        // compose the query

        $condition = array("enable" => 1);
        $count = \mg\MongoQuery::count($table->name, $condition);


        $limit = (int) $table->count;

        $offset = $paginator->get();


        $sort = GetCollections::orderby($table);

// build and execute the query
//        echo $query->createCommand()->rawSql;
//        exit;
        $rows = \mg\MongoQuery::execute($table->name, $condition, $sort, $limit, $offset);



        $result = array();
        $result['rows'] = $rows;
        $result['count'] = $count;
        $result['current'] = 0;

        $result['current'] = (int) $table->count + $offset;

        $result['pages'] = $paginator->show($result['count'], $offset, (int) $table->count);

        return $result;
    }

    static function orderby($table) {

        $field = $table->sort_field;
        if ($table->sort_field == "order_last_id") {
            $field = $table->sort_field;
        }


        $result = array($field => 1);
        if ($table->sort_type == "DESC") {
            $result[$field] = -1;
        }

        return $result;
    }

}
