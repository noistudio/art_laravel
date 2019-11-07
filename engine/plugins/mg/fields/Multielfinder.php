<?php

namespace mg\fields;

use mg\core\AbstractField;

class Multielfinder extends AbstractField {

    public function getConfigOptions() {

        return array('isimage' => array('type' => 'bool', 'title' => __("backend/mg.f_melfinder_isimage")), 'type' => array('type' => 'select', 'options' => array(array('value' => 'none', 'title' => __("backend/mg.f_melfinder_t_none")), array('value' => 'thumbnail', 'title' => __("backend/mg.f_melfinder_t_thumbnail")), array('value' => 'fixsize', 'title' => __("backend/mg.f_melfinder_t_fixsize")), array('value' => 'maxsize', 'title' => __("backend/mg.f_melfinder_t_maxsize")), array('value' => 'minsize', 'title' => __("backend.mg.f_melfinder_t_minsize")), array('value' => 'resize', 'title' => __("backend/mg.f_melfinder_t_resize"))), 'title' => __("backend/mg.f_melfinder_type")), 'width' => array('type' => 'int', 'title' => __("backend/mg.f_melfinder_width")), 'height' => array('type' => 'int', 'title' => __("backend/mg.f_melfinder_height")));
    }

    public function set() {
        $results = array();

        $isimage = $this->option("isimage");
        $type = $this->option("type");

        $width = $this->option("width");
        $height = $this->option("height");
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
                            if (isset($type) and $type == "maxsize") {

                                $image_result = getimagesize($full_img);
                                if (isset($image_result[0]) and (int) $image_result[0] < 400) {
                                    \core\Notify::add(__("backend/mg.f_elfinder_er1", array("px" => 400)));
                                    $canadd = false;
                                }
                                if (isset($image_result[1]) and (int) $image_result[1] < 400) {
                                    \core\Notify::add(__("backend/mg.f_elfinder_er2", array("px" => 400)));
                                    $canadd = false;
                                }


                                if (isset($image_result[0]) and (int) $image_result[0] > (int) $width) {
                                    \core\Notify::add(__("backend/mg.f_elfinder_er11", array("px" => $width)));
                                    $canadd = false;
                                }
                                if (isset($image_result[1]) and (int) $image_result[1] > (int) $height) {
                                    \core\Notify::add(__("backend/mg.f_elfinder_er22", array("px" => $height)));
                                    $canadd = false;
                                }
                            } else if (isset($type) and $type == "fixsize") {
                                $image_result = getimagesize($full_img);
                                if (isset($image_result[0]) and (int) $image_result[0] != (int) $width) {
                                    \core\Notify::add(__("backend/mg.f_elfinder_er3", array("px" => $width)));
                                    $canadd = false;
                                }
                                if (isset($image_result[1]) and (int) $image_result[1] != (int) $height) {
                                    \core\Notify::add(__("backend/mg.f_elfinder_er4", array("px" => $height)));
                                    $canadd = false;
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





        if (isset($results) and is_array($results) and count($results) > 0) {
            return $results;
        } else {
            return null;
        }
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

        return $this->value;
    }

    public function get() {



        $this->option['all'] = $this->all();
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/mg.f_melfinder");
    }

}
