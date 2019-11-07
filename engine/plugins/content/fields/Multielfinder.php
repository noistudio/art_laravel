<?php

namespace content\fields;

use content\models\SqlModel;
use content\models\AbstractField;
use yii\db\Query;

class Multielfinder extends AbstractField {

    protected $type_run = "on_end";

    public function set() {




        $results = array();

        $isimage = $this->option('isimage');
        $resize_width = $this->option('resize_width');
        $thumbnail_width = $this->option('thumbnail_width');
        $thumbnail_height = $this->option('thumbnail_height');
        if (isset($this->value) and is_array($this->value) and count($this->value)) {
            foreach ($this->value as $val) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $val) and strlen($val) > 1) {
                    $full_img = $_SERVER['DOCUMENT_ROOT'] . $val;
                    $canadd = true;
                    if ($isimage) {
                        if (@is_array(getimagesize($full_img))) {
                            if (!is_null($resize_width)) {
                                $image_result = getimagesize($full_img);
                                if (isset($image_result[0]) and (int) $image_result[0] > (int) $resize_width) {
                                    $val = $this->resize($full_img, "width", $resize_width);
                                }
                            }
                        } else {
                            $canadd = false;
                        }
                    }
                    if ($canadd) {
                        $results[] = $val;
                    }
                }
            }
        }


        $type = $this->getType();

        if (!is_null($type)) {
            \db\SqlQuery::delete("elfinder_files", \db\SqlQuery::array_to_raw(["type" => $type], false, false));

            if (count($results)) {
                foreach ($results as $res) {
                    $tmp = array();
                    $tmp['type'] = $type;
                    $tmp['file'] = $res;
                    if ($isimage) {
                        if (!is_null($thumbnail_width)) {
                            $dest = $res;
                            $pathinfo = pathinfo($dest);
                            $dest = str_replace($pathinfo['basename'], $thumbnail_width . "_thumbnail_" . $pathinfo['basename'], $dest);

                            $this->make_thumb_width($_SERVER['DOCUMENT_ROOT'] . $res, $_SERVER['DOCUMENT_ROOT'] . $dest, $thumbnail_width);
                            $tmp['min_image'] = $dest;
                        } else if (!is_null($thumbnail_height)) {
                            $dest = $res;
                            $pathinfo = pathinfo($dest);
                            $dest = str_replace($pathinfo['basename'], $thumbnail_width . "_thumbnail_" . $pathinfo['basename'], $dest);

                            $this->make_thumb_height($_SERVER['DOCUMENT_ROOT'] . $res, $_SERVER['DOCUMENT_ROOT'] . $dest, $thumbnail_height);


                            $tmp['min_image'] = $dest;
                        }
                    }

                    \db\SqlQuery::insert($tmp, "elfinder_files");
                }
            }
        }

        if (count($results)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getType() {
        $result = null;

//        if (isset($this->option['primarykey']) and isset($this->option['row'][$this->option['primarykey']])
//                and isset($this->option['table'])) {
//            $result = $this->option['table'] . "_" . $this->option['row'][$this->option['primarykey']];
//            if (isset($this->option['postfix'])) {
//                $result = $result . "_" . $this->option['postfix'];
//            }
//        }


        if (isset($this->option['row']["last_id"])) {
            $result = $this->table;
            $result .= "_" . $this->option['row']["last_id"];
        }
        return $result;
    }

    public function parse($rows) {
        $nametable = $this->table;




        $ids = array();

        $result_images = array();
        $condition = array('or');
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $condition[] = array('type' => $nametable . "_" . $row['last_id']);
            }



            $tmp_res = \db\SqlQuery::all(\db\SqlQuery::array_to_raw($condition), "elfinder_files", array('id_file', "asc"));

            if (count($tmp_res)) {
                foreach ($tmp_res as $res) {
                    if (!isset($result_images[$res['type']])) {
                        $result_images[$res['type']] = array();
                    }
                    $result_images[$res['type']][] = $res['file'];
                }
                foreach ($rows as $k => $row) {
                    if (isset($result_images[$nametable . '_' . $row['last_id']])) {

                        $row[$this->name] = $result_images[$nametable . '_' . $row['last_id']];
                        $row[$this->name . "_val"] = $result_images[$nametable . '_' . $row['last_id']];
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
                $path = pathinfo($val);

                $result .= "<a target='_blank' href='" . $val . "'>" . $path['basename'] . "</a>,";
            }
        }
        return $result;
    }

    public function make_thumb_height($src, $dest, $desired_height) {

        /* read the source image */
        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            $source_image = imagecreatefromgif($src);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            $source_image = imagecreatefromjpeg($src);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            $source_image = imagecreatefrompng($src);
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_width = floor($width * ($desired_height / $height));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            imagegif($virtual_image, $dest);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            imagejpeg($virtual_image, $dest);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            imagepng($virtual_image, $dest);
        }
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` INT NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->integer($this->name);
    }

    public function make_thumb_width($src, $dest, $desired_width) {

        /* read the source image */
        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            $source_image = imagecreatefromgif($src);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            $source_image = imagecreatefromjpeg($src);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            $source_image = imagecreatefrompng($src);
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            imagegif($virtual_image, $dest);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            imagejpeg($virtual_image, $dest);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            imagepng($virtual_image, $dest);
        }
    }

    public function resize($src, $type = "width", $size) {
        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            $source_image = imagecreatefromgif($src);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            $source_image = imagecreatefromjpeg($src);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            $source_image = imagecreatefrompng($src);
        }
        $pathinfo = pathinfo($src);
        $newsrc = $src;
        $newsrc = str_replace($pathinfo['basename'], $type . "_" . $size . "_" . $pathinfo['basename'], $newsrc);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        if ($type == "width") {
            $desired_width = $size;
            $desired_height = floor($height * ($size / $width));
        } else {
            $desired_height = $size;
            $desired_width = floor($width * ($size / $height));
        }
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            imagegif($virtual_image, $newsrc);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            imagejpeg($virtual_image, $newsrc);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            imagepng($virtual_image, $newsrc);
        }
        $newsrc = str_replace($_SERVER['DOCUMENT_ROOT'], "", $newsrc);
        return $newsrc;
    }

    public function all() {
        $type = $this->getType();
        if (!is_null($type)) {



            $rows = \db\SqlQuery::all(\db\SqlQuery::array_to_raw(array('type' => $type), false, false), "elfinder_files", array("id_file", "asc"));

            if (count($rows)) {
                foreach ($rows as $key => $row) {
                    $pathinfo = pathinfo($_SERVER['DOCUMENT_ROOT'] . "" . $row['file']);
                    $row['namefile'] = $pathinfo['basename'];
                    $rows[$key] = $row;
                }
            }
        } else {
            $rows = array();
        }
        return $rows;
    }

    public function get() {
        $type = $this->getType();


        $this->option['all'] = $this->all();
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/content.field_multielfinder");
    }

}
