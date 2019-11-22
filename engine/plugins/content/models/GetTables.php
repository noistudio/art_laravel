<?php

namespace content\models;

use Yii;
use yii\db\Query;
use plugcomponents\Notify;
use db\SqlQuery;
use plugsystem\GlobalParams;

class GetTables {

    static function one($nametable, $id) {
        $table = \db\JsonQuery::get($nametable, "tables", "name");

        $paginator = new \core\Paginator;

        $result_rows = array();
        $query = \DB::table($table->name)->select($table->name . ".*");
        // compose the query
        $raw_query = SqlQuery::array_to_raw(array(
                    "and",
                    array($table->name . ".enable" => 1),
                    array($table->name . ".last_id" => $id)
                        ), true);


        $query->whereRaw($raw_query['raw'], $raw_query['vars']);





        $offset = $paginator->get();


        $query->orderByRaw(GetTables::orderby($table));
        $query = GetTables::parse_query_list($query, $table);
// build and execute the query
//        echo $query->createCommand()->rawSql;
//        exit;



        $result = $query->first();
        $result = \core\Helper::toArray($result);
        if (is_array($result)) {
            $array = RowModel::run_parse(array($result), $nametable);
            $result = $array[0];
        }
        return $result;
    }

    static function block($nametable, $condition = null, $limit = null, $orderby = null) {
        $table = \db\JsonQuery::get($nametable, "tables", "name");

        $paginator = new \core\Paginator();

        $result_rows = array();
        $query = \DB::table($nametable);
        // compose the query
        $query->select(array($table->name . ".*"));

        if (isset($condition) and is_array($condition) and count($condition) > 0) {
            $raw_condition = SqlQuery::array_to_raw($condition);
            $query->whereRaw($raw_condition['raw'], $raw_condition['vars']);
        } else {
            $raw_condition = SqlQuery::array_to_raw(array($table->name . ".enable" => 1));
            $query->whereRaw($raw_condition['raw'], $raw_condition['vars']);
        }
        $count = $query->count();
        $on_page = $table->count;
        $offset = $paginator->get();
        if (!is_null($limit) and is_numeric($limit) and (int) $limit > 0) {
            $query->limit((int) $limit);
            $on_page = $limit;
            //   $query->offset($offset);
        }





        if (isset($orderby) and is_array($orderby) and count($orderby) > 0) {

            $query->orderByRaw(SqlQuery::order_array_to_raw($orderby));
        } else {
            $query->orderByRaw(GetTables::orderby($table));
        }

        $query = GetTables::parse_query_list($query, $table);
// build and execute the query
//        echo $query->createCommand()->rawSql;
//        exit;
        $rows = $query->get();

        $rows = \core\Helper::toArray($rows);

        $rows = RowModel::run_parse($rows, $nametable);



        $result = array();
        $result['rows'] = $rows;
        $result['count'] = $count;
        $result['current'] = 0;

        $result['current'] = (int) $on_page + $offset;

        $result['pages'] = $paginator->show($result['count'], $offset, (int) $on_page);
        return $result;
    }

    static function all($nametable) {
        $q = "";

        if (isset($_GET['q']) and is_string($_GET['q']) and strlen($_GET['q']) > 0) {
            $q = strip_tags($_GET['q']);
        }
        $table = \db\JsonQuery::get($nametable, "tables", "name");

        $paginator = new \core\Paginator();
        $result = array();
        $result_rows = array();
        $query = \DB::table($nametable);
        // compose the query
        $query->select(array($table->name . ".*"));

        $condition = array($table->name . ".enable" => 1);

        if (\languages\models\LanguageHelp::is("frontend")) {
            $lang = \languages\models\LanguageHelp::get();
            $condition = array('and');
            $condition[] = array($table->name . ".enable" => 1);
            $condition[] = array($table->name . "._lng" => $lang);
        }

        if (strlen($q) > 0) {
            $condition = array('and');
            $condition[] = array($table->name . ".enable" => 1);
            if (\languages\models\LanguageHelp::is("frontend")) {
                $lang = \languages\models\LanguageHelp::get();

                $condition[] = array($table->name . "._lng" => $lang);
            }

            $second = array("or");
            if (isset($table->fields)) {
                $fields = json_decode($table->fields, true);
                if (is_array($fields) and count($fields) > 0) {
                    if (!(isset($_GET['only']) and is_string($_GET['only']))) {

                        foreach ($fields as $name => $val) {

                            $second[] = array("LIKE", $table->name . "." . $name, $q);
                        }
                    } else {

                        if (isset($fields[$_GET['only']])) {
                            $only = strip_tags($_GET['only']);
                            $second[] = array("LIKE", $table->name . "." . $only, $q);
                            $result['q_' . $only] = $q;
                            $q = "";
                        }
                    }
                }

                if (count($second) > 1) {
                    $condition[] = $second;
                } else {
                    $q = "";
                }
            }
        }

        $raw_where = SqlQuery::array_to_raw($condition);
        $query->whereRaw($raw_where['raw'], $raw_where['vars']);
        $count = $query->count();
        //  $offset = $paginator->get();

        $limit = (int) $table->count;
        $query->limit((int) $table->count);

        $offset = $paginator->get();
        $query->offset($offset);



        $query->orderByRaw(GetTables::orderby($table));
        $query = GetTables::parse_query_list($query, $table);


        $cache_key = $table->name . "_" . json_encode($query->wheres) . "_" . $offset . "_" . $limit;

// build and execute the query
//        echo $query->createCommand()->rawSql;
//        exit;
        $cache_data = \cache\models\Model::get($cache_key);


        if (!is_null($cache_data)) {

            $rows = $cache_data;
        } else {
            $rows = $query->get();
            $rows = \core\Helper::toArray($rows);
            \cache\models\Model::set($cache_key, $rows, array('table_' . $table->name, 'table'));
        }



        $rows = RowModel::run_parse($rows, $nametable);



        $result['rows'] = $rows;
        $result['count'] = $count;
        $result['current'] = 0;


        $result['q'] = $q;

        $result['current'] = (int) $table->count + $offset;
        $result['limit'] = (int) $table->count;

        $result['pages'] = $paginator->show($result['count'], $offset, (int) $table->count);

        return $result;
    }

    static function parse_query_list($query, $table) {

        $fields = json_decode($table->fields, true);
        $results = array();
        foreach ($fields as $name => $field) {
            $fieldclass = '\\content\\fields\\' . ucfirst($field['type']);
            $obj = new $fieldclass($name, $name, $field['options']);
            $query = $obj->parse_query_list($query, $table->name);
        }
        return $query;
    }

    static function orderby($table) {

        $field = $table->sort_field;
        if ($table->sort_field == "arrow_sort") {
            $field = $table->name . ".sort";
        }




        return $field . " " . $table->sort_type;
    }

}
