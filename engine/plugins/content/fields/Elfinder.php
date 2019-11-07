<?php

namespace content\fields;

use content\models\AbstractField;
use plugsystem\models\NotifyModel;
use plugcomponents\Notify;

class Elfinder extends AbstractField {

    public function getConfigOptions() {

        return array('isimage' => array('type' => 'bool', 'title' => __("backend/content.field_elfinder_isimage")), 'type' => array('type' => 'select', 'options' => array(array('value' => 'none', 'title' => __("backend/content.field_elfinder_type_none")), array('value' => 'thumbnail', 'title' => __("backend/content.field_elfinder_type_thumbnail")), array('value' => 'fixsize', 'title' => __("backend/content.field_elfinder_type_fixsize")), array('value' => 'minsize', 'title' => __("backend/content.field_elfinder_type_minsize")), array('value' => 'resize', 'title' => __("backend/content.field_elfinder_type_resize"))), 'title' => __("backend/content.field_elfinder_type")), 'width' => array('type' => 'int', 'title' => __("backend/content.field_elfinder_width")), 'height' => array('type' => 'int', 'title' => __("backend/content.field_elfinder_height")));
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` VARCHAR(200) NULL';
        return $result;
    }

    public function set() {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $this->value) and strlen($this->value) > 1) {
            $isimage = $this->option("isimage");
            $type = $this->option("type");

            $width = $this->option("width");
            $height = $this->option("height");
            $thumbnail = null;
            $thumbnail_width = null;
            $width = null;
            $height = null;
            $maxheight = null;
            $maxwidth = null;
            $minheight = null;
            $minwidth = null;
            $isresize = null;
            if ($type == "thumbnail") {
                $thumbnail = true;
                $thumbnail_width = $this->option("width");
            } else if ($type == "fixsize") {
                $width = $this->option("width");
                $height = $this->option("height");
            } else if ($type == "minsize") {
                $minheight = $this->option("height");
                $minwidth = $this->option("width");
            } else if ($type == "resize") {
                $maxheight = $this->option("height");
                $maxwidth = $this->option("width");
                $isresize = true;
            }

            if (!is_null($isimage)) {

                if (!is_null($isimage) and ! is_null($minwidth) and ! is_null($minheight)) {
                    if (@is_array(getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value))) {
                        $image_result = getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value);

                        if (isset($image_result[0]) and (int) $image_result[0] < (int) $minwidth) {

                            Notify::add(__("backend/content.field_elfinder_width_err1", array("min" => $minwidth)));
                            return null;
                        }
                        if (isset($image_result[0]) and (int) $image_result[1] < (int) $minheight) {

                            Notify::add(__("backend/content.field_elfinder_height_err1", array("min" => $minheight)));
                            return null;
                        }
                    }
                }
                if (!is_null($isimage) and ! is_null($maxwidth) and ! is_null($maxheight)) {
                    if (@is_array(getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value))) {
                        $image_result = getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value);


                        if (isset($image_result[0]) and (int) $image_result[0] <= (int) $maxwidth
                                and isset($image_result[1]) and (int) $image_result[1] <= (int) $maxheight) {
                            
                        } else if (!(isset($image_result[0]) and (int) $image_result[0] <= (int) $maxwidth)
                                and isset($image_result[1]) and (int) $image_result[1] <= (int) $maxheight) {
                            $this->resize($_SERVER['DOCUMENT_ROOT'] . $this->value, "width", $maxwidth);
                        } else if ((isset($image_result[0]) and (int) $image_result[0] <= (int) $maxwidth)
                                and ! (isset($image_result[1]) and (int) $image_result[1] <= (int) $maxheight)) {
                            $this->resize($_SERVER['DOCUMENT_ROOT'] . $this->value, "height", $maxheight);
                        } else {
                            $this->resize($_SERVER['DOCUMENT_ROOT'] . $this->value, "width", $maxwidth);
                        }
                    } else {
                        $this->resize($_SERVER['DOCUMENT_ROOT'] . $this->value, "width", $maxwidth);
                    }
                } else if (!is_null($isimage) and ! is_null($width) and (int) $width > 0 and is_null($height) and (int) $height > 0) {
                    if (@is_array(getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value))) {
                        $image_result = getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value);
                        if (isset($image_result[0]) and (int) $image_result[0] == (int) $width) {
                            
                        } else {
                            Notify::add(__("backend/content.field_elfinder_width_err2", array("width" => $width)));


                            return null;
                        }
                    } else {
                        Notify::add(__("backend/content.field_elfinder_width_err2", array("width" => $width)));


                        return null;
                    }
                } elseif (!is_null($isimage) and $type == "fixsize" and ! is_null($width) and ! is_null($height)) {
                    if (@is_array(getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value))) {
                        $image_result = getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->value);
                        if (isset($image_result[0]) and (int) $image_result[0] == (int) $width
                                and isset($image_result[1]) and (int) $image_result[1] == (int) $height
                        ) {
                            
                        } else {
                            Notify::add(__("backend/content.field_elfinder_err", array("width" => $width, 'height' => $height)));

                            return null;
                        }
                    } else {
                        Notify::add(__("backend/content.field_elfinder_width_err2", array("width" => $width)));


                        return null;
                    }
                }
                if (!is_null($thumbnail) and ! is_null($thumbnail_width)) {
                    $src = $_SERVER['DOCUMENT_ROOT'] . $this->value;
                    $pathinfo = pathinfo($src);
                    $dest = $src;
                    $dest = str_replace($pathinfo['basename'], "thumbnail_" . $pathinfo['basename'], $src);
                    $this->make_thumb_width($src, $dest, $thumbnail_width);
                    $dest = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dest);
                    $this->setOtherField($dest, $thumbnail);
                }
            }
            $result = $this->value;
        } else {
            $result = null;
        }

        return $result;
    }

    public function resize($src, $type = "width", $size) {
        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            $source_image = imagecreatefromgif($src);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            $source_image = imagecreatefromjpeg($src);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            $source_image = imagecreatefrompng($src);
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        if ($type == "width") {
            $desired_width = $size;
            $desired_height = floor($height * ($size / $width));
        } else {
            $type = "height";
            $desired_height = $size;
            $desired_width = floor($width * ($size / $height));
        }
        $pathinfo = pathinfo($src);
        $newsrc = $src;
        $newsrc = str_replace($pathinfo['basename'], $type . "_" . $size . "_" . $pathinfo['basename'], $newsrc);
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
        $this->value = $newsrc;
        return $newsrc;
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

    public function get() {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $this->value) and strlen($this->value) > 1) {
            $pathinfo = pathinfo($_SERVER['DOCUMENT_ROOT'] . "" . $this->value);
            $this->option['result'] = array('url' => $this->value, 'namefile' => $pathinfo['basename']);
        } else {
            
        }
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/content.field_elfinder");
        ;
    }

}
