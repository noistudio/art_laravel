<?php

namespace mg\fields;

use mg\core\AbstractField;
use content\models\SqlModel;
use yii\db\Query;

class Categoryfield extends AbstractField {

    public function set() {
        $value = $this->value;
        $result = $this->isExist();
        if (is_array($result)) {
            $value = $result;
        } else {
            if ($value == "main") {
                return $value;
            }
            $value = null;
        }
        return $value;
    }

    public function value() {
        $result = $this->set();

        if (is_array($result) and isset($result['last_id'])) {
            return $result['last_id'];
        } else {
            if ($result == "main") {
                return $result;
            }
            return (int) $this->value;
        }
    }

    public function getFieldTitle() {
        return __("backend/mg.f_categoryfield");
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
        if (isset($this->value) and $this->value == "main") {
            return $this->name;
        } else {
            return $this->name . ".last_id";
        }
    }

    private function isExist() {
        $value = $this->value;


        if (is_numeric($value)) {
            $query = new Query;
// compose the query


            $result = \mg\MongoQuery::get("shop_categorys", array('last_id' => (int) $value));
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


        $rows = \mg\MongoQuery::all("shop_categorys");

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
        } else if (isset($this->value) and $this->value == "main") {
            return "Главная категория";
        } else {
            return "";
        }
    }

}
