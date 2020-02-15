<?php

namespace files;

use files\models\ImageModel;

class ImageResizer {

    static function is_image($filename) {
        $is = @getimagesize($filename);
        if (!$is)
            return false;
        elseif (!in_array($is[2], array(1, 2, 3)))
            return false;
        else
            return true;
    }

    static function resize($path, $width = null, $height = null) {
        $document_root = public_path();
        $full_path = $document_root . $path;
        if (file_exists($full_path) and is_file($full_path)) {

            if (($height == null and isset($width) and is_numeric($width)) or ( $width == null and isset($height) and is_numeric($height))) {
                $isimage = ImageResizer::is_image($full_path);
                if ($isimage) {
                    list($file_width, $file_height) = getimagesize($full_path);
                    if ($height == null) {
                        $res = $file_width / $width;
                        $height = $file_height / $res;
                        $height = (int) $height;
                    } else if ($width == null) {
                        $res = $file_height / $height;
                        $width = $file_width / $res;
                        $width = (int) $width;
                    }
                }
            }


            if (is_numeric($width) and (int) $width > 0
                    and is_numeric($height) and (int) $height > 0) {

                $model = new ImageModel($full_path, $width, $height);

                return $model->resize();
            } else {
                return $path;
            }
        } else {
            return $path;
        }
    }
    
     static function to_fix($path, $size = 400) {
      $document_root = public_path();
        $full_path = $document_root . $path;
        $isimage = ImageResizer::is_image($full_path);
        $width = null;
        $height = null;
        if ($isimage) {
            list($file_width, $file_height) = getimagesize($full_path);
            if ($file_width > $file_height) {
                $height = $size;
                $width = null;
            } else {
                $width = $size;
                $height = null;
            }
            $image = ImageResizer::resize($path, $width, $height);
            $image = ImageResizer::crop($path, $size, $size);
            return $image;
        }

        return null;
    }

    static function crop($path, $width, $height = null) {
        $document_root = public_path();
        $full_path = $document_root . $path;
        if (file_exists($full_path) and is_file($full_path)) {

            if (($height == null and isset($width) and is_numeric($width)) or ( $width == null and isset($height) and is_numeric($height))) {
                $isimage = ImageResizer::is_image($full_path);
                if ($isimage) {
                    list($file_width, $file_height) = getimagesize($full_path);
                    if ($height == null) {
                        $res = $file_width / $width;
                        $height = $file_height / $res;
                        $height = (int) $height;
                    } else if ($width == null) {
                        $res = $file_height / $height;
                        $width = $file_width / $res;
                        $width = (int) $width;
                    }
                }
            }


            if (is_numeric($width) and (int) $width > 0
                    and is_numeric($height) and (int) $height > 0) {

                $model = new ImageModel($full_path, $width, $height);

                return $model->crop();
            } else {
                return $path;
            }
        } else {
            return $path;
        }
    }

}
