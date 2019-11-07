<?php

namespace content\models;

use db\SqlQuery;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;
use yii\db\Connection;
use Yii;
use yii\db\Query;

class ArrowModel {

    public static function move($nametable, $id, $newpos) {
        $row = SqlQuery::get(array('last_id' => $id), $nametable);
        if (!(isset($row) and is_array($row))) {
            return false;
        }
        if ((int) $row['sort'] == (int) $newpos) {
            return false;
        }




        $raw_condition = SqlQuery::array_to_raw(array("and", array(">=", "sort", $newpos), array("!=", "last_id", $id)));


        \DB::table($nametable)->whereRaw($raw_condition['raw'], $raw_condition['vars'])->increment('sort', 1);


        $update['sort'] = $newpos;
        SqlQuery::update($nametable, $update, SqlQuery::array_to_raw(array("last_id" => $id), false, false));
    }

    public static function up($nametable, $id) {
        $get_vars = request()->query->all();
        $primarykey = "last_id";

        $model = \content\models\MasterTable::find($nametable);
        $table = $model->getTable();
        $json_fields = json_decode($table->fields, true);
        $typefield = array();
        foreach ($json_fields as $key => $val) {

            $typefield[$key] = $val;
        }

        $forarray = array();
        foreach ($json_fields as $key => $val) {
            if (isset($get_vars[$key])) {
                $forarray[$key] = $get_vars[$key];
            }
        }
        $condition = array('and');
        $condition[] = array("=", $primarykey, $id);
        $fields_search = \content\models\RowModel::editFields($nametable, $forarray, false);
        if (count($fields_search) > 0) {
            foreach ($fields_search as $search_field) {
                $namefield = $search_field['name'];
                $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                if (isset($get_vars['type_' . $namefield]) and is_string($get_vars['type_' . $namefield]) and in_array($get_vars['type_' . $namefield], $types_array)) {

                    $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                    $obj = new $class($get_vars[$namefield], $namefield, $typefield[$namefield]['options']);
                    $curval = $obj->set();

                    if (is_null($curval) or strlen($curval) == 0) {
                        
                    } else {

                        $condition[] = array($get_vars['type_' . $namefield], $nametable . "." . $namefield, $curval);
                    }
                } else if (!(isset($get_vars['type_' . $namefield]) )) {
                    
                } else {
                    
                }
            }
        }


        $result = SqlQuery::get(SqlQuery::array_to_raw($condition), $nametable);




        if (is_array($result)) {


            $condition = array('and');
            $condition[] = array("<", "sort", $result['sort']);
            $fields_search = \content\models\RowModel::editFields($nametable, $forarray, false);
            if (count($fields_search) > 0) {
                foreach ($fields_search as $search_field) {
                    $namefield = $search_field['name'];
                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($get_vars['type_' . $namefield]) and is_string($get_vars['type_' . $namefield]) and in_array($get_vars['type_' . $namefield], $types_array)) {

                        $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                        $obj = new $class($get_vars[$namefield], $namefield, $typefield[$namefield]['options']);
                        $curval = $obj->set();

                        if (is_null($curval) or strlen($curval) == 0) {
                            
                        } else {

                            $condition[] = array($get_vars['type_' . $namefield], $nametable . "." . $namefield, $curval);
                        }
                    } else if (!(isset($get_vars['type_' . $namefield]) )) {
                        
                    } else {
                        
                    }
                }
            }

            $next = SqlQuery::get(SqlQuery::array_to_raw($condition), $nametable);


            if (is_array($next)) {
                $update = array();
                $update['sort'] = $result['sort'];
                SqlQuery::update($nametable, $update, $primarykey . "=" . $next[$primarykey]);
                $update2 = array();
                $update2['sort'] = $next['sort'];
                SqlQuery::update($nametable, $update2, $primarykey . "=" . $result[$primarykey]);
            }
        }
    }

    public static function down($nametable, $id) {
        $primarykey = "last_id";

        $model = \content\models\MasterTable::find($nametable);
        $table = $model->getTable();
        $json_fields = json_decode($table->fields, true);
        $typefield = array();
        foreach ($json_fields as $key => $val) {

            $typefield[$key] = $val;
        }

        $forarray = array();
        foreach ($json_fields as $key => $val) {
            if (isset($get_vars[$key])) {
                $forarray[$key] = $get_vars[$key];
            }
        }
        $condition = array('and');
        $condition[] = array("=", $primarykey, $id);
        $fields_search = \content\models\RowModel::editFields($nametable, $forarray, false);
        $get_vars = request()->query->all();


        if (count($fields_search) > 0) {
            foreach ($fields_search as $search_field) {
                $namefield = $search_field['name'];
                $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                if (isset($get_vars['type_' . $namefield]) and is_string($get_vars['type_' . $namefield]) and in_array($get_vars['type_' . $namefield], $types_array)) {

                    $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                    $obj = new $class($get_vars[$namefield], $namefield, $typefield[$namefield]['options']);
                    $curval = $obj->set();

                    if (is_null($curval) or strlen($curval) == 0) {
                        
                    } else {

                        $condition[] = array($get_vars['type_' . $namefield], $nametable . "." . $namefield, $curval);
                    }
                } else if (!(isset($get_vars['type_' . $namefield]) )) {
                    
                } else {
                    
                }
            }
        }


        $result = SqlQuery::get(SqlQuery::array_to_raw($condition), $nametable);

        if (is_array($result)) {

            $condition = array('and');
            $condition[] = array(">", "sort", $result['sort']);
            $fields_search = \content\models\RowModel::editFields($nametable, $forarray, false);
            if (count($fields_search) > 0) {
                foreach ($fields_search as $search_field) {
                    $namefield = $search_field['name'];
                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($get_vars['type_' . $namefield]) and is_string($get_vars['type_' . $namefield]) and in_array($get_vars['type_' . $namefield], $types_array)) {

                        $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                        $obj = new $class($get_vars[$namefield], $namefield, $typefield[$namefield]['options']);
                        $curval = $obj->set();

                        if (is_null($curval) or strlen($curval) == 0) {
                            
                        } else {

                            $condition[] = array($get_vars['type_' . $namefield], $nametable . "." . $namefield, $curval);
                        }
                    } else if (!(isset($get_vars['type_' . $namefield]) )) {
                        
                    } else {
                        
                    }
                }
            }

            $down = SqlQuery::get(SqlQuery::array_to_raw($condition), $nametable);

            if (is_array($down)) {
                $update = array();
                $update['sort'] = $result['sort'];
                SqlQuery::update($nametable, $update, $primarykey . "=" . $down[$primarykey]);
                $update2 = array();
                $update2['sort'] = $down['sort'];
                SqlQuery::update($nametable, $update2, $primarykey . "=" . $result[$primarykey]);
            }
        }
    }

}
