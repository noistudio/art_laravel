<?php

namespace mg\models;

class ArrowModel {

    public static function up($nametable, $id) {
        $post = request()->post();
        $get = request()->query->all();

        $result = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));

        if (is_array($result)) {
            $model = \mg\core\DynamicCollection::find($nametable, "null");
            $table = $model->getCollection();
            $json_fields = json_decode($table->fields, true);
            $typefield = array();
            foreach ($json_fields as $key => $val) {

                $typefield[$key] = $val;
            }
            $condition = array('$and' => array());
            if (isset($get['conditions']) and is_array($get['conditions']) and count($get['conditions'])) {
                foreach ($get['conditions'] as $namefield) {
                    if ($namefield == "enable") {

                        if (isset($get['enable']) and (string) $get['enable'] == "on") {
                            $condition['$and'][] = array(".enable" => 1);
                        } else if (isset($get['enable']) and (string) $get['enable'] == "off") {
                            $condition['$and'][] = array(".enable" => 0);
                        }
                    } else if (isset($get[$namefield]) and isset($get['type_' . $namefield])) {

                        $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                        if (isset($get['type_' . $namefield]) and is_string($get['type_' . $namefield]) and in_array($get['type_' . $namefield], $types_array)) {

                            $class = "\\mg\\fields\\" . $typefield[$namefield]['type'];

                            $obj = new $class($get[$namefield], $namefield, $typefield[$namefield]['options']);
                            $_POST[$namefield] = $get[$namefield];


                            $curval = $obj->value();

                            $dbfield = $obj->dbfield();


                            if (is_null($curval)) {
                                
                            } else {
                                if ($get['type_' . $namefield] == "=") {
                                    $condition['$and'][] = array($dbfield => $curval);
                                } else if ($get['type_' . $namefield] == "!=") {
                                    $condition['$and'][] = array($dbfield => array('$ne' => $curval));
                                } else if ($get['type_' . $namefield] == ">") {
                                    $condition['$and'][] = array($dbfield => array('$gt' => $curval));
                                } else if ($get['type_' . $namefield] == ">=") {
                                    $condition['$and'][] = array($dbfield => array('$gte' => $curval));
                                } else if ($get['type_' . $namefield] == "<") {
                                    $condition['$and'][] = array($dbfield => array('$lt' => $curval));
                                } else if ($get['type_' . $namefield] == "<=") {
                                    $condition['$and'][] = array($dbfield => array('$lte' => $curval));
                                } else if ($get['type_' . $namefield] == "LIKE") {
                                    $condition['$and'][] = array($dbfield => array('$options' => 'i', '$regex' => $curval));
                                }
                            }
                        } else if (!(isset($get['type_' . $namefield]) )) {
                            
                        } else {
                            
                        }
                    }
                }
            }

            if (isset($get['type_banner']) and $get['type_banner'] == "active") {
                $condition['enable'] = 1;

                $condition['$or'][] = array("limit" => 'views', 'views' => array('$gte' => 0));
                $condition['$or'][] = array("limit" => 'date', 'date' => array('$gte' => \mg\MongoHelper::date()));
            } else if (isset($get['type_banner']) and $get['type_banner'] == "notactive") {
                $condition['$or'] = array();

                $condition['$or'][] = array("enable" => 0, "limit" => 'views', 'views' => array('$lte' => 0));
                $condition['$or'][] = array("limit" => 'date', 'date' => array('$lte' => \mg\MongoHelper::date()));
            }






            if (count($condition['$and']) > 0) {
                
            } else {
                if (!(count($condition['$and']) > 0)) {
                    unset($condition['$and']);
                }
            }


            $condition['order_last_id'] = array('$lt' => $result['order_last_id']);



            $next = \mg\MongoQuery::get($nametable, $condition, array('order_last_id' => -1));




            if (is_array($next)) {
                $update = array();
                $update['order_last_id'] = $result['order_last_id'];

                \mg\MongoQuery::update($update, $nametable, array('last_id' => $next['last_id']));
                $update = array();
                $update['order_last_id'] = $next['order_last_id'];

                \mg\MongoQuery::update($update, $nametable, array('last_id' => $result['last_id']));
            }
        }
    }

    public static function down($nametable, $id) {
        $post = request()->post();
        $get = request()->query->all();


        $result = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));

        if (is_array($result)) {
            $model = \mg\core\DynamicCollection::find($nametable, "null");
            $table = $model->getCollection();
            $json_fields = json_decode($table->fields, true);
            $typefield = array();
            foreach ($json_fields as $key => $val) {

                $typefield[$key] = $val;
            }
            $condition = array('$and' => array());
            if (isset($get['conditions']) and is_array($get['conditions']) and count($get['conditions'])) {
                foreach ($get['conditions'] as $namefield) {
                    if ($namefield == "enable") {

                        if (isset($get['enable']) and (string) $get['enable'] == "on") {
                            $condition['$and'][] = array(".enable" => 1);
                        } else if (isset($get['enable']) and (string) $get['enable'] == "off") {
                            $condition['$and'][] = array(".enable" => 0);
                        }
                    } else if (isset($get[$namefield]) and isset($get['type_' . $namefield])) {

                        $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                        if (isset($get['type_' . $namefield]) and is_string($get['type_' . $namefield]) and in_array($get['type_' . $namefield], $types_array)) {

                            $class = "\\mg\\fields\\" . $typefield[$namefield]['type'];

                            $obj = new $class($get[$namefield], $namefield, $typefield[$namefield]['options']);
                            $_POST[$namefield] = $get[$namefield];


                            $curval = $obj->value();

                            $dbfield = $obj->dbfield();


                            if (is_null($curval)) {
                                
                            } else {
                                if ($get['type_' . $namefield] == "=") {
                                    $condition['$and'][] = array($dbfield => $curval);
                                } else if ($get['type_' . $namefield] == "!=") {
                                    $condition['$and'][] = array($dbfield => array('$ne' => $curval));
                                } else if ($get['type_' . $namefield] == ">") {
                                    $condition['$and'][] = array($dbfield => array('$gt' => $curval));
                                } else if ($get['type_' . $namefield] == ">=") {
                                    $condition['$and'][] = array($dbfield => array('$gte' => $curval));
                                } else if ($get['type_' . $namefield] == "<") {
                                    $condition['$and'][] = array($dbfield => array('$lt' => $curval));
                                } else if ($get['type_' . $namefield] == "<=") {
                                    $condition['$and'][] = array($dbfield => array('$lte' => $curval));
                                } else if ($get['type_' . $namefield] == "LIKE") {
                                    $condition['$and'][] = array($dbfield => array('$options' => 'i', '$regex' => $curval));
                                }
                            }
                        } else if (!(isset($get['type_' . $namefield]) )) {
                            
                        } else {
                            
                        }
                    }
                }
            }

            if (isset($get['type_banner']) and $get['type_banner'] == "active") {
                $condition['enable'] = 1;

                $condition['$or'][] = array("limit" => 'views', 'views' => array('$gte' => 0));
                $condition['$or'][] = array("limit" => 'date', 'date' => array('$gte' => \mg\MongoHelper::date()));
            } else if (isset($get['type_banner']) and $get['type_banner'] == "notactive") {
                $condition['$or'] = array();

                $condition['$or'][] = array("enable" => 0, "limit" => 'views', 'views' => array('$lte' => 0));
                $condition['$or'][] = array("limit" => 'date', 'date' => array('$lte' => \mg\MongoHelper::date()));
            }






            if (count($condition['$and']) > 0) {
                
            } else {
                if (!(count($condition['$and']) > 0)) {
                    unset($condition['$and']);
                }
            }


            $condition['order_last_id'] = array('$gt' => $result['order_last_id']);

            $down = \mg\MongoQuery::get($nametable, $condition, array('order_last_id' => 1));


            if (is_array($down)) {
                $update = array();
                $update['order_last_id'] = $result['order_last_id'];
                \mg\MongoQuery::update($update, $nametable, array('last_id' => $down['last_id']));

                $update2 = array();
                $update2['order_last_id'] = $down['order_last_id'];
                \mg\MongoQuery::update($update2, $nametable, array('last_id' => $result['last_id']));
            }
        }
    }

}
