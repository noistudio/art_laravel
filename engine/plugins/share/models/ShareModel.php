<?php

namespace share\models;

use \plugsystem\GlobalParams;

class ShareModel {

    static function getAll() {
        $rows = \db\SqlDocument::all("share_params");

        return $rows;
    }

    static function delete($id) {
        \db\SqlDocument::delete("share_params", (int) $id);
    }

    static function get($id) {
        $row = \db\SqlDocument::get("share_params", (int) $id);
        if (isset($row) and is_array($row)) {
            return $row;
        } else {
            return null;
        }
    }

    static function find_between($string = "", $start = "", $end = "", $greedy = false) {
        if (is_null($string)) {
            $string = "";
        }
        $start = preg_quote($start);
        $end = preg_quote($end);

        $format = '/(%s)(.*';
        if (!$greedy)
            $format .= '?';
        $format .= ')(%s)/';

        $pattern = sprintf($format, $start, $end);
        preg_match_all($pattern, $string, $matches);

        return $matches[2];
    }

    static function startDocumentPublish($link, $row, $shares) {
        try {
            $works = ShareModel::allWorked();

            if (count($works) and count($shares)) {
                foreach ($shares as $val) {
                    $val = (int) $val;
                    if (isset($works[$val])) {
                        $share = $works[$val];
                        $photos_field = explode(",", $share['photos_field']);

                        $images = array();
                        $text = $share['text_field'];

                        foreach ($row as $key => $value) {

                            if (!is_array($value)) {
                                if ($key == "content") {
                                    var_dump($value);
                                    exit;
                                }
                                $text = str_replace("[" . $key . "]", $value, $text);
                            } else if (is_array($value) and count($value) > 0) {
                                foreach ($value as $vkey => $vval) {

                                    if (!is_array($vval)) {
                                        $text = str_replace("[" . $key . "." . $vkey . "]", $vval, $text);
                                    }
                                }
                            }
                            if (in_array($key, $photos_field) and is_string($value) and strlen($value) > 0) {
                                $check_file = public_path($value);
                                if (file_exists($check_file)) {
                                    $image_link = url()->to($value);

                                    $images[] = $image_link;
                                }
                            }
                        }
                        $findstags = ShareModel::find_between($text, "[", "]");
                        foreach ($findstags as $con) {
                            $text = str_replace("[" . $con . "]", "", $text);
                        }

                        if ($share['type_publish'] == "link") {
                            $text = $link;
                        }
                        if ($share['type_publish'] == "textlink") {
                            $text .= "\n\n" . $link;
                        }

                        call_user_func("\\share\\templates\\" . $share['type'] . "ShareModel" . '::publish', $share, $text, $images, $link);
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    static function startPublish($type, $table, $id, $shares) {
        ob_implicit_flush(1);
        ignore_user_abort(true);
        $data = array();
        set_time_limit(0);
        ini_set('memory_limit', '1280M');
        $havelink = false;
        $row = false;

        //  try {
        if ($type == "content") {
            $row = \db\SqlQuery::get(array('last_id' => (int) $id), $table);
            $path = GlobalParams::getDocumentRoot() . "/themefrontend/plugin/content/" . $table . "_one.php";
            if (file_exists($path)) {
                $havelink = true;
            }
            $link = "http://" . $_SERVER['HTTP_HOST'] . "/content/" . $table . "/" . $id;
        } else if ($type == "mg") {
            $row = \mg\MongoQuery::get($table, array('last_id' => (int) $id));

            $havelink = true;
            $link = route('frontend/mg/' . $table . "/one", $id);
        }

        if ($havelink == true and is_array($row)) {
            ShareModel::startDocumentPublish($link, $row, $shares);
        }
//        } catch (\Exception $e) {
//            echo $e->getMessage();
//            exit;
//        }
    }

    static function call($type, $table, $id, $shares) {

        $query = http_build_query(array('shares' => $shares));

        //$url = 'http://' . $_SERVER['HTTP_HOST'] . $params['access'] . "share/publish/" . $type . "/" . $table . "/" . $id . "?" . $query;
        ShareModel::startPublish($type, $table, $id, $shares);
        // ShareModel::fast_request($url);
    }

    static function fast_request($url) {
        $setting = stream_context_create(array('http' =>
            array(
                'timeout' => 1, //секунда
            )
        ));

        $result = file_get_contents($url, false, $setting);
    }

    static function allWorked() {
        $all = ShareModel::getAll();
        $result = array();
        if (count($all)) {
            foreach ($all as $key => $row) {

                $isenable = call_user_func("\\share\\templates\\" . $row['type'] . "ShareModel" . '::isEnable', $row, $key);
                if (is_bool($isenable) and $isenable == true) {
                    $row['id'] = $key;
                    $result[(int) $key] = $row;
                }
            }
        }
        return $result;
    }

    static function fastSave($row, $id) {

        $result = call_user_func("\\share\\templates\\" . $row['type'] . "ShareModel" . '::update', $row, $id);
        if (is_array($result) and count($result)) {
            foreach ($result as $key => $val) {
                $row['params'][$key] = $val;
            }
            \db\SqlDocument::update($row, "share_params", $id);
        }
    }

    static function update($row, $id) {
        $post = request()->post();

        if ((isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            $row['title'] = strip_tags($post['title']);
        }

        if ((isset($post['type_publish']) and is_string($post['type_publish']) and in_array($post['type_publish'], array('link', 'textlink', 'text')))) {
            $row['type_publish'] = $post['type_publish'];
        }
        if ((isset($post['photos_field']) and is_string($post['photos_field']) and strlen($post['photos_field']) > 0)) {
            $row['photos_field'] = $post['photos_field'];
        }
        if ((isset($post['text_field']) and is_string($post['text_field']) and strlen($post['text_field']) > 0)) {
            $row['text_field'] = $post['text_field'];
        }
        if (isset($post['params']) and is_array($post['params'])) {
            $row['params'] = $post['params'];
        }
        \db\SqlDocument::update($row, "share_params", $id);
    }

    static function add() {
        $post = request()->post();
        $rows = ShareModel::getAll();


        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \plugsystem\models\NotifyModel::add(__("backend/share.err1"));
            return false;
        }
        $types = ShareModel::types();
        if (!(isset($post['type']) and is_string($post['type']) and in_array($post['type'], $types))) {
            \plugsystem\models\NotifyModel::add(__("backend/share.err2"));
            return false;
        }
        if (!(isset($post['type_publish']) and is_string($post['type_publish']) and in_array($post['type_publish'], array('link', 'textlink', 'text')))) {
            \plugsystem\models\NotifyModel::add(__("backend/share.err3"));
            return false;
        }
        if (!(isset($post['photos_field']) and is_string($post['photos_field']) and strlen($post['photos_field']) > 0)) {
            $post['photos_field'] = "";
            return false;
        }
        if (!(isset($post['text_field']) and is_string($post['text_field']) and strlen($post['text_field']) > 0)) {
            \plugsystem\models\NotifyModel::add(__("backend/share.err4"));
            return false;
        }


        $row = array();
        $row['title'] = strip_tags($post['title']);
        $row['type'] = $post['type'];
        $row['type_publish'] = $post['type_publish'];
        $row['photos_field'] = $post['photos_field'];
        $row['text_field'] = $post['text_field'];
        $row['params'] = array();

        return \db\SqlDocument::insert($row, "share_params");
    }

    static function types() {
        $files = scandir(\core\ManagerConf::plugins_path() . "share/templates/");

        $arrays = array();
        if (count($files)) {
            foreach ($files as $file) {
                $newfile = str_replace(array(".php", "ShareModel"), "", $file);
                if ($file != $newfile) {
                    $arrays[] = $newfile;
                }
            }
        }
//        $arrays = array(
//            'vk'
//        );
        return $arrays;
    }

}
