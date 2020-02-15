<?php

namespace content\fields;

use content\models\SqlModel;
use content\models\AbstractField;
use yii\db\Query;

class Multiselect extends AbstractField {

    protected $type_run = "on_end";

    public function set() {
        if (!isset($this->option['row']["last_id"])) {
            return null;
        }

        $results = array();

        $values = $this->value;

        $condition = array('and');
        $condition[] = array('from_table' => $this->table);
        $condition[] = array("data_table" => $this->option('table'));
        $condition[] = array("row_id" => $this->option['row']["last_id"]);
       


        if (isset($values) and is_array($values) and count($values)) {
            
           \DB::table('multiselect')
           
            ->where(function ($query) {
                $query->where('from_table', '=', $this->table);
                 $query->where('data_table', '=', $this->option('table'));
                         $query->where('from_table', '=', $this->option['row']["last_id"]);
            })
            ->delete(); 
            
          // \db\SqlQuery::delete("multiselect", \db\SqlQuery::array_to_raw($condition));
            foreach ($values as $val) {
                $result = $this->isExist($val);

                if ($result) {

                    $new_array = array();
                    $new_array['from_table'] = $this->table;
                    $new_array['data_table'] = $this->option('table');
                    $new_array['row_id'] = $this->option['row']["last_id"];
                    $new_array['value'] = $val;

                    $new_array['last_id'] = \db\SqlQuery::insert($new_array, "multiselect");
                }
            }
        }

        if (count($results)) {
            return count($results);
        } else {
            return 0;
        }
    }

    private function isExist($value) {



        if (is_numeric($value)) {
            


          //  $result = $query->select("*")->from($this->option('table'))->where(array($this->option('pk') => (int) $value))->one();
 $count=\DB::table($this->option('table'))         
            ->where($this->option('pk'),"=",$value)
            ->count(); 
            if ($count==1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getConfigOptions() {

        return array('table' => array('type' => 'text', 'title' => __("backend/content.field_table_name")), 'pk' => array('type' => 'text', 'title' => __("backend/content.field_table_pk")), 'title' => array('type' => 'text', 'title' => __("backend/content.field_table_title")));
    }

    public function parse($rows) {
        $nametable = $this->table;
        $condition = array('and');
        $condition[] = array('from_table' => $this->table);
        $condition[] = array("data_table" => $this->option('table'));





        $ids = array();

        $result_images = array();

        if (count($rows) > 0) {


            $tmp_res = \db\SqlQuery::all(\db\SqlQuery::array_to_raw($condition), 'multiselect', null);

            if (count($tmp_res)) {

                $condition_ids = array();
                $condition_titles = array('or');
                foreach ($tmp_res as $key => $res) {
                    if (!isset($condition_ids['id_' . $res['value']])) {
                        $condition_titles[] = array($this->option('pk') => $res['value']);
                        $condition['id_' . $res['value']] = 1;
                    }
                }
                if (count($condition_titles) > 0) {


                    $tmp_rows = \db\SqlQuery::all(\db\SqlQuery::array_to_raw($condition_titles), $this->option("table"), array($this->option('pk'), "asc"));
                    if (count($tmp_rows)) {
                        foreach ($tmp_rows as $row) {
                            foreach ($tmp_res as $key => $res) {

                                if ((string) $res['value'] == (string) $row[$this->option('pk')]) {
                                    $result = array();
                                    $result['value'] = $row[$this->option('pk')];
                                    $result['title'] = $row[$this->option('title')];
                                    $tmp_res[$key]['result'] = $result;
                                }
                            }
                        }
                    }
                }



                foreach ($tmp_res as $res) {
                    if (isset($res['result'])) {
                        if (!isset($result_images['id_' . $res['row_id']])) {
                            $result_images['id_' . $res['row_id']] = array();
                        }
                        $result_images['id_' . $res['row_id']][] = $res['result'];
                    }
                }
                $condition = array('or');



                foreach ($rows as $k => $row) {

                    if (isset($result_images['id_' . $row['last_id']])) {

                        $row[$this->name] = $result_images['id_' . $row['last_id']];
                        $row[$this->name . "_val"] = $result_images['id_' . $row['last_id']];
                    }
                    $rows[$k] = $row;
                }
            }
        }
        return $rows;
    }

    public function renderValue() {
        $value = $this->value;
        $result = "";

        if (is_array($value) and count($value)) {
            foreach ($value as $val) {


                $result .= $val['title'] . ",";
            }
        }
        return $result;
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` INT NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->integer($this->name);
    }

    private function getData() {
        $this->option['rows'] = array();
        if (is_null($this->option("table")) or is_null($this->option("pk"))) {
            return array();
        }

        $result = array();




        //$query->where(array("enable" => 1));

        $rows = \db\SqlQuery::all(null, $this->option("table"), array($this->option("pk"), "asc"));
        if (count($rows)) {

            foreach ($rows as $key => $data) {

                $arr = array('value' => $data[$this->option("pk")], 'title' => $data[$this->option("title")]);
                $result[] = $arr;
            }
        }

        $this->option['rows'] = $result;
    }

    public function get() {
        $this->getData();


        $values = array();
        if (isset($this->option['row']["last_id"])) {
            $condition = array('and');
            $condition[] = array('from_table' => $this->table);
            $condition[] = array("data_table" => $this->option('table'));
            $condition[] = array("row_id" => $this->option['row']["last_id"]);






            $all = \db\SqlQuery::all(\db\SqlQuery::array_to_raw($condition), "multiselect", array("last_id", "asc"));

            if (count($all)) {
                foreach ($all as $row) {
                    $values['id_' . $row['value']] = 1;
                }
            }
        }
        $this->option['values'] = $values;




        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/content.field_multiselect");
    }

}
