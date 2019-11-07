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

        $query = new Query();

        \Yii::$app->db->createCommand()
                ->update($nametable, ['sort' => new \yii\db\Expression('sort + 1')], array("and", array(">=", "sort", $newpos), array("!=", "last_id", $id)))
                ->execute();

        $update['sort'] = $newpos;
        SqlQuery::update($nametable, $update, array("last_id" => $id));
    }

    public static function up($nametable, $id) {
        $get_vars = \yii::$app->request->get();
        $primarykey = "last_id";
        $query = new Query();
        $query->select("*")->from($nametable);
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


                if (isset($_GET['type_' . $namefield]) and is_string($_GET['type_' . $namefield]) and in_array($_GET['type_' . $namefield], $types_array)) {

                    $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                    $obj = new $class($_GET[$namefield], $namefield, $typefield[$namefield]['options']);
                    $curval = $obj->set();

                    if (is_null($curval) or strlen($curval) == 0) {
                        
                    } else {

                        $condition[] = array($_GET['type_' . $namefield], $nametable . "." . $namefield, $curval);
                    }
                } else if (!(isset($_GET['type_' . $namefield]) )) {
                    
                } else {
                    
                }
            }
        }
        $query->where($condition);
        $result = $query->one();



        if (is_array($result)) {
            $query2 = new Query();
            $query2->select("*")->from($nametable);

            $condition = array('and');
            $condition[] = array("<", "sort", $result['sort']);
            $fields_search = \content\models\RowModel::editFields($nametable, $forarray, false);
            if (count($fields_search) > 0) {
                foreach ($fields_search as $search_field) {
                    $namefield = $search_field['name'];
                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($_GET['type_' . $namefield]) and is_string($_GET['type_' . $namefield]) and in_array($_GET['type_' . $namefield], $types_array)) {

                        $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                        $obj = new $class($_GET[$namefield], $namefield, $typefield[$namefield]['options']);
                        $curval = $obj->set();

                        if (is_null($curval) or strlen($curval) == 0) {
                            
                        } else {

                            $condition[] = array($_GET['type_' . $namefield], $nametable . "." . $namefield, $curval);
                        }
                    } else if (!(isset($_GET['type_' . $namefield]) )) {
                        
                    } else {
                        
                    }
                }
            }
            $query2->where($condition);
            $query2->orderBy(array('sort' => SORT_DESC));
            $next = $query2->one();


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
        $query = new Query();
        $query->select("*")->from($nametable);
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


                if (isset($_GET['type_' . $namefield]) and is_string($_GET['type_' . $namefield]) and in_array($_GET['type_' . $namefield], $types_array)) {

                    $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                    $obj = new $class($_GET[$namefield], $namefield, $typefield[$namefield]['options']);
                    $curval = $obj->set();

                    if (is_null($curval) or strlen($curval) == 0) {
                        
                    } else {

                        $condition[] = array($_GET['type_' . $namefield], $nametable . "." . $namefield, $curval);
                    }
                } else if (!(isset($_GET['type_' . $namefield]) )) {
                    
                } else {
                    
                }
            }
        }
        $query->where($condition);

        $result = $query->one();

        if (is_array($result)) {
            $query2 = new Query();
            $query2->select("*")->from($nametable);
            $condition = array('and');
            $condition[] = array(">", "sort", $result['sort']);
            $fields_search = \content\models\RowModel::editFields($nametable, $forarray, false);
            if (count($fields_search) > 0) {
                foreach ($fields_search as $search_field) {
                    $namefield = $search_field['name'];
                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($_GET['type_' . $namefield]) and is_string($_GET['type_' . $namefield]) and in_array($_GET['type_' . $namefield], $types_array)) {

                        $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                        $obj = new $class($_GET[$namefield], $namefield, $typefield[$namefield]['options']);
                        $curval = $obj->set();

                        if (is_null($curval) or strlen($curval) == 0) {
                            
                        } else {

                            $condition[] = array($_GET['type_' . $namefield], $nametable . "." . $namefield, $curval);
                        }
                    } else if (!(isset($_GET['type_' . $namefield]) )) {
                        
                    } else {
                        
                    }
                }
            }
            $query2->where($condition);
            $query2->orderBy(array('sort' => SORT_ASC));
            $down = $query2->one();

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
