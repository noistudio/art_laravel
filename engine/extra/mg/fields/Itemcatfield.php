<?php

namespace mg\fields;

use mg\core\AbstractField;
use content\models\SqlModel;
use yii\db\Query;

class Itemcatfield extends AbstractField {

    public function set() {
        $value = $this->value;
        $result = $this->isExist();
        if (is_array($result)) {
            $value = $result;
        } else {

            $value = null;
        }
        return $value;
    }

    public function value() {
        $result = $this->set();
        if (is_array($result['last_id'])) {
            return $result['last_id'];
        } else {
            return (int) $this->value;
        }
    }

    public function getFieldTitle() {

        return __("backend/mg.f_itemcatfield");
    }

    public function setup() {


//        $connection = array('collection' => $this->collection, "field" => $this->name);
//        $collection = \db\JsonQuery::get($this->option("collection"), "collections", "name");
//        $connections = array();
//        if (is_object($collection)) {
//            if (isset($collection->connections)) {
//                $json = json_decode($collection->connections, true);
//                if (is_array($json)) {
//                    $connections = $json;
//                }
//            }
//            $can = true;
//            if (count($connections)) {
//                foreach ($connections as $con) {
//                    if ($con['collection'] == $this->collection and $con['field'] == $this->name) {
//                        $can = false;
//                        break;
//                    }
//                }
//            }
//
//            if ($can) {
//                $connections[] = $connection;
//                $collection->connections = json_encode($connections);
//                $collection->save();
//            }
//        }
    }

    public function dbfield() {
        return $this->name . ".last_id";
    }

    private function isExist() {
        $value = $this->value;


        if (is_numeric($value)) {
            $query = new Query;
// compose the query


            $result = \mg\MongoQuery::get("shop_categorys", array("category" => "main", 'last_id' => (int) $value));
            if (is_array($result)) {
                return $result;
            } else {
                return false;
            }
        }
    }

    private function getData() {
        $result = array();



        //$query->where(array("enable" => 1));


        $rows = \mg\MongoQuery::all("shop_categorys", array("category" => "main"));

        if (count($rows)) {
            foreach ($rows as $key => $data) {
                $arr = array('value' => $data["last_id"], 'title' => $data["title"]);
                $result[] = $arr;
            }
        }



        $this->option['rows'] = $result;
    }

    public function get() {
        $this->getData();

        $html = $this->render();
        return $html;
    }

    public function display() {
        if (is_array($this->value) and isset($this->value["title"])) {
            return $this->value["title"];
        } else {
            return "";
        }
    }

}
