<?php

namespace content\fields;

use content\models\SqlModel;
use content\models\AbstractField;
use yii\db\Query;
use Yii;

class Tags extends AbstractField {

    public function set() {
        if (is_null($this->option("table")) or is_null($this->option("tag"))) {
            return null;
        }

        $value = strtolower(strip_tags($this->value));
        $tags = mb_split(",", $value);
        foreach ($tags as $tag) {
            $query = new Query();
            if (strlen($tag) > 1) {
                $condition = array($this->option("tag") => $tag);


                $count = \db\SqlQuery::count(\db\SqlQuery::array_to_raw($condition), $this->option("table"));
                if ($count == 0) {
                    $array = array();
                    $array['enable'] = 1;
                    $array['tag'] = $tag;
                    // $array['count'] = 1;
                    \db\SqlQuery::insert($array, $this->option("table"));
                } else {
//                    $count = $query->from("blog_posts")->where(['LIKE', 'blog_posts.tags', $tag])->count();
//                    Yii::$app->db->createCommand()->update('tags', ['count' => $count], 'tag="' . $tag . '"')->execute();
                }
            }
        }
        return $value;
    }

    public function getConfigOptions() {

        return array('table' => array('type' => 'text', 'title' => __("backend/content.field_table_name")), 'tag' => array('type' => 'text', 'title' => __("backend/content.field_table_tag")),);
    }

    public function getFieldTitle() {

        return __("backend/content.field_tags");
    }

    public function get() {
        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->value . '` VARCHAR(200) NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->string($this->name, 200);
    }

}
