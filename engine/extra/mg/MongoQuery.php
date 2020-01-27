<?php

namespace mg;

use plugsystem\models\EventModel;
use core\Helper;

class MongoQuery {

    public static function delete($collection, $criteria) {
        if (isset($collection) and is_array($criteria)) {



            //    EventModel::run($namecollection . "_delete", array('collection' => $namecollection, 'condition' => $criteria));


            $result = \DB::connection('mongodb')->collection($collection)->whereRaw($criteria)->delete();

            return $result;
        }
    }

    public static function insert($array, $namecollection) {



        if (!isset($array['last_id'])) {

            $array['last_id'] = MongoQuery::getLastid($namecollection);

            $array['order_last_id'] = $array['last_id'];
        }

        $class = "\\mg\\collections\\" . ucfirst($namecollection);
        if (class_exists($class)) {
            $obj = new $class();
            $obj->_insert($array);
        } else {
            $obj = new \mg\collections\_DefaultCollection($namecollection);
            $obj->_insert($array);
        }

        //  EventModel::run($namecollection . "_insert", array('array' => $array));
        //  EventModel::run("insert", array('collection' => $namecollection, 'array' => $array));

        return $array;
    }

    public static function count($collection, $condition) {

        $query = \DB::connection('mongodb')->collection($collection);
        $query->whereRaw($condition);

        return $query->count();
    }

    public static function get($collection, $condition, $sort = array('_id' => -1)) {
        if (is_numeric($condition)) {
            $last_id = (int) $condition;
            $condition = array('last_id' => $last_id);
        }
        $result = MongoQuery::execute_one($collection, $condition, $sort, 10, 0);
        if (isset($result) and is_array($result)) {
            $result = \languages\models\LanguageParse::start_one($result, $collection);
        }

        return $result;
    }

    public static function execute($collection, $condition = array(), $sort = array('_id' => -1), $limit = 25, $offset = 0) {
        $criteria = $condition;

        $query = \DB::connection('mongodb')->collection($collection);

        $query->whereRaw($condition)->offset($offset)->limit($limit);
        if (count($sort)) {
            foreach ($sort as $skey => $s) {
                if ($s == -1) {
                    $s = 'desc';
                } else {
                    $s = 'asc';
                }
                $query->orderBy($skey, $s);
            }
        }

        $models = $query->get();


        $result = Helper::toArray($models);
        if ($collection != "object") {

            $result = \languages\models\LanguageParse::start_list($result);
        }

        return $result;
    }

    public static function execute_one($collection, $condition = array(), $sort = array('_id' => -1), $limit = 25, $offset = 0) {
        $criteria = $condition;

        $query = \DB::connection('mongodb')->collection($collection);

        $query->whereRaw($condition);
        $query->limit($limit);
        $query->offset($offset);
        if (count($sort)) {
            foreach ($sort as $skey => $s) {
                if ($s == -1) {
                    $s = "desc";
                } else {
                    $s = "asc";
                }
                $query->orderBy($skey, $s);
            }
        }

        $result = $query->first();


        $result = Helper::toArray($result);



//        if (isset($models) and is_array($models) and $collection != "object") {
//            $models = \languages\models\LanguageParse::start_list($models, $collection);
//        }

        return $result;
    }

    public static function all($collection, $condition = array(), $sort = array('_id' => -1)) {
        return MongoQuery::execute2($collection, $condition, $sort);
    }

    public static function execute2($collection, $condition = array(), $sort = array('_id' => -1)) {
        $criteria = $condition;

        $query = \DB::connection('mongodb')->collection($collection);

        $query->whereRaw($condition);
        if (count($sort)) {
            foreach ($sort as $skey => $s) {
                if ($s == -1) {
                    $s = "desc";
                } else {
                    $s = "asc";
                }
                // $sort[$skey] = $s;
                $query->orderBy($skey, $s);
            }
        }
        // $query->orderBy($sort);
        $models = $query->get();
        $models = Helper::toArray($models);
        if ($collection != "object") {
            $models = \languages\models\LanguageParse::start_list($models);
        }
        return $models;
    }

    public static function update($array, $collection, $condition, $multiple = false, $modifier = '$set') {
        if (isset($array) and isset($collection) and isset($condition)) {


            // $collection=new EDMSQuery($collection);
            $namecollection = $collection;

            $action = is_array($modifier) ? $modifier : array($modifier => $array);
            $options = array();
            if ($multiple == true) {
                $options['multiple'] = true;
            }

            if ($modifier == '$setOnInsert') {
                $options['upsert'] = true;
            }

            $old_data = null;
            if ($namecollection == "goats") {
                $res = MongoQuery::all("goats", $condition);

                if (count($res) == 1) {
                    $old_data = $res[0];
                }
            }


            $class = "\\mg\\collections\\" . ucfirst($namecollection);
            if (class_exists($class)) {
                $obj = new $class();
                $result = $obj->_update($array, $condition, $options);
            } else {
                $obj = new \mg\collections\_DefaultCollection($namecollection);
                $result = $obj->_update($array, $condition, $options);
            }

            //  $result = $collection->update($condition, $action, $options);
            if (!is_null($old_data)) {
                //  EventModel::run($namecollection . "_update2", array('old' => $old_data, 'condition' => $condition, 'multiple' => $multiple, 'modifier' => '$set'));
            }
            //  EventModel::run($namecollection . "_update", array('array' => $array, 'condition' => $condition, 'multiple' => $multiple, 'modifier' => '$set'));

            return $result;
        }
    }

    public static function getLastId($name_collection) {

        if ($name_collection == "cms_users") {
            $last_id = rand(111111, 999999);
            $count = MongoQuery::count($name_collection, array('last_id' => $last_id));
            while ($count > 0) {
                $last_id = rand(111111, 999999);
                $count = MongoQuery::count($name_collection, array('last_id' => $last_id));
            }
            return $last_id;
        } else {
            $name = "userid";

//            $retval = \DB::getCollection("noicms_counters")->findAndModify(
//                    array('last_id' => $name_collection . "_" . $name), 
//                    array('$inc' => array("seq" => 1)), 
//                    array(
//                "new" => true,
//                    )
//            );

            $seq = \DB::connection('mongodb')->getCollection('noicms_counters')->findOneAndUpdate(
                    array('last_id' => $name_collection . "_" . $name),
                    array('$inc' => array('seq' => 1)),
                    array('new' => true)
            );


            if (!(isset($seq->seq))) {

                $result = MongoQuery::execute($name_collection, array(), array('_id' => -1), 1);

                if (isset($result[0]['last_id'])) {
                    $array_insert = array();
                    $array_insert['last_id'] = $name_collection . "_" . $name;
                    $array_insert['seq'] = $result[0]['last_id'];
                } else {
                    $array_insert = array();
                    $array_insert['last_id'] = $name_collection . "_" . $name;
                    $array_insert['seq'] = 1;
                }
                MongoQuery::insert($array_insert, "noicms_counters");
                return MongoQuery::getLastId($name_collection);
            } else {

                return $seq->seq;
            }
        }
    }

}
