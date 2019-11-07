<?php

namespace mg\fields;

use mg\core\AbstractField;
use content\models\SqlModel;

class Tags extends AbstractField {

    public function set() {
        $table_option = $this->option("table");
        $tag_option = $this->option("tag");
        if (!isset($table_option) and ! isset($tag_option)) {
            return null;
        }

        $value = strtolower(strip_tags($this->value));
        $tags = mb_split(",", $value);
        $result = array();
        foreach ($tags as $tag) {
            $tag = strtolower($tag);

            if (strlen($tag) > 1) {
                $count = \mg\MongoQuery::count($this->option("table"), array($this->option("tag") => $tag));

                if ($count == 0) {
                    $array = array();
                    $array['enable'] = 1;
                    $array['tag'] = $tag;
                    // $array['count'] = 1;

                    \mg\MongoQuery::insert($array, $this->option("table"));
                } else {
//                    $count = $query->from("blog_posts")->where(['LIKE', 'blog_posts.tags', $tag])->count();
//                    Yii::$app->db->createCommand()->update('tags', ['count' => $count], 'tag="' . $tag . '"')->execute();
                }
                $result[] = $tag;
            }
        }
        return $result;
    }

    public function getConfigOptions() {

        return array('table' => array('type' => 'text', 'title' => __("backend/mg.f_select_collection")), 'tag' => array('type' => 'text', 'title' => __("backend/mg.f_tags_tag")),);
    }

    public function getFieldTitle() {
        return __("backend/mg.f_tags");
    }

    public function get() {
        if (is_array($this->value)) {
            $this->value = implode(",", $this->value);
        }
        return $this->render();
    }

}
