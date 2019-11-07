<?php

namespace mg\fields;

use mg\core\AbstractField;
use content\models\SqlModel;
use yii\db\Query;

class Select extends AbstractField {

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

        return __("backend/mg.f_select");
    }

    public function setup() {


        $connection = array('collection' => $this->collection, "field" => $this->name);
        $collection = \db\JsonQuery::get($this->option("collection"), "collections", "name");
        $connections = array();
        if (is_object($collection)) {
            if (isset($collection->connections)) {
                $json = json_decode($collection->connections, true);
                if (is_array($json)) {
                    $connections = $json;
                }
            }
            $can = true;
            if (count($connections)) {
                foreach ($connections as $con) {
                    if ($con['collection'] == $this->collection and $con['field'] == $this->name) {
                        $can = false;
                        break;
                    }
                }
            }

            if ($can) {
                $connections[] = $connection;
                $collection->connections = json_encode($connections);
                $collection->save();
            }
        }
    }

    public function dbfield() {
        return $this->name . ".last_id";
    }

    public function getConfigOptions() {

        return array('collection' => array('type' => 'text', 'title' => __("backend/mg.f_select_collection")), 'title' => array('type' => 'text', 'title' => __("backend/mg.f_select_title")));
    }

    private function isExist() {
        $value = $this->value;


        if (is_numeric($value)) {
            $query = new Query;
// compose the query


            $result = \mg\MongoQuery::get($this->option('collection'), array('last_id' => (int) $value));
            if (is_array($result)) {
                return $result;
            } else {
                return false;
            }
        }
    }

    private function getData() {
        $option_collection = $this->option("collection");
        $option_title = $this->option("title");
        if (!isset($option_collection) and ! isset($option_title)) {
            return null;
        }

        $result = array();



        //$query->where(array("enable" => 1));


        $rows = \mg\MongoQuery::all($this->option("collection"));

        if (count($rows)) {
            foreach ($rows as $key => $data) {
                $arr = array('value' => $data["last_id"], 'title' => $data[$this->option("title")]);
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
        if (is_array($this->value) and isset($this->value[$this->option("title")])) {
            return $this->value[$this->option("title")];
        } else {
            return "";
        }
    }

}
