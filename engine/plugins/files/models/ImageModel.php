<?php

namespace files\models;

use Imagick;

class ImageModel {

    private $file;
    private $width = 0;
    private $height = 0;

    function __construct($path_to_file, $width, $height) {
        $this->file = $path_to_file;
        $this->width = $width;
        $this->height = $height;
    }

    private function result($src) {
        $document_root = public_path();
        $src = str_replace($document_root, "", $src);
        return $src;
    }

    public function resize() {
        $src = $this->file;
        $image = null;

        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            $image = imagecreatefromgif($src);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($src);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            $image = imagecreatefrompng($src);
        }

        if (is_null($image)) {
            return false;
        }
        $pathinfo = pathinfo($src);
        $prefix = $this->width . "x" . $this->height;
        $newsrc = $src;
        $newsrc = str_replace($pathinfo['filename'], $pathinfo['filename'] . $prefix, $newsrc);
        $newsrc = str_replace(public_path(), "", $newsrc);

        $newsrc = str_replace("/" . env("APP_PATH_FILES"), "", $newsrc);
        $newsrc = str_replace("_finish", "_res", $newsrc);

        $newsrc = public_path() . "/" . env("APP_PATH_RESIZE_FOLDER") . "/" . str_replace("/", "_", $newsrc);
        $newsrc = str_replace("_resize/", "_resize/_res", $newsrc);


        if (file_exists($newsrc)) {
            return $this->result($newsrc);
        }



        // Get new dimensions
        list($width, $height) = getimagesize($src);


        if ((int) $width == (int) $this->width and
                (int) $height == (int) $this->height) {
            return $this->result($src);
        }

        if ($width < $this->width) {


            return $this->result($src);
        }

        if ($height < $this->height) {

            return $this->result($src);
        }
        $desired_height = $this->height;
        $desired_width = floor($width * ($this->height / $height));

// Resample
        $image_p = imagecreatetruecolor($desired_width, $desired_height);

        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);












        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            imagegif($image_p, $newsrc);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {

            imagejpeg($image_p, $newsrc);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            imagepng($image_p, $newsrc);
        }


//        $imagick = new Imagick($newsrc);
//        $imagick->setImageCompression(imagick::COMPRESSION_JPEG);
//        $imagick->setImageCompressionQuality(100);
//        $imagick->adaptiveSharpenImage(0, 1);
//        if (file_put_contents($newsrc, $imagick) === false) {
//            throw new Exception("Could not put contents.");
//        }
//
//
//        $this->cropImage($newsrc, $newsrc, $this->width, $this->height);
//        $newsrc = str_replace(\plugsystem\GlobalParams::getDocumentRoot(), "", $newsrc);
        return $this->result($newsrc);
    }

    public function crop() {
        $src = $this->file;
        $image = null;

        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            $image = imagecreatefromgif($src);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($src);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            $image = imagecreatefrompng($src);
        }

        if (is_null($image)) {
            return false;
        }
        $pathinfo = pathinfo($src);
        $prefix = $this->width . "x" . $this->height;
        $newsrc = $src;
        $newsrc = str_replace($pathinfo['filename'], $pathinfo['filename'] . $prefix, $newsrc);
        $newsrc = str_replace(public_path(), "", $newsrc);

        $newsrc = str_replace("/" . env("APP_PATH_FILES"), "", $newsrc);
        $newsrc = str_replace("_finish", "", $newsrc);
        $newsrc = public_path() . "/" . env("APP_PATH_RESIZE_FOLDER") . "/" . str_replace("/", "_", $newsrc);

        if (file_exists($newsrc)) {
            return $this->result($newsrc);
        }



        // Get new dimensions
        list($width, $height) = getimagesize($src);


        if ((int) $width == (int) $this->width and
                (int) $height == (int) $this->height) {
            return $this->result($src);
        }

        if ($width < $this->width) {


            return $this->result($src);
        }

        if ($height < $this->height) {

            return $this->result($src);
        }
        $desired_height = $this->height;
        $desired_width = floor($width * ($this->height / $height));

// Resample
        $image_p = imagecreatetruecolor($desired_width, $desired_height);

        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);












        if (exif_imagetype($src) == IMAGETYPE_GIF) {
            imagegif($image_p, $newsrc);
        } else if (exif_imagetype($src) == IMAGETYPE_JPEG) {

            imagejpeg($image_p, $newsrc);
        } else if (exif_imagetype($src) == IMAGETYPE_PNG) {
            imagepng($image_p, $newsrc);
        }


        $imagick = new Imagick($newsrc);
        $imagick->setImageCompression(imagick::COMPRESSION_JPEG);
        $imagick->setImageCompressionQuality(100);
        $imagick->adaptiveSharpenImage(0, 1);
        if (file_put_contents($newsrc, $imagick) === false) {
            throw new Exception("Could not put contents.");
        }


        $this->cropImage($newsrc, $newsrc, $this->width, $this->height);
        $newsrc = str_replace(public_path(), "", $newsrc);
        return $this->result($newsrc);
    }

    public function cropImage($aInitialImageFilePath, $aNewImageFilePath, $aNewImageWidth, $aNewImageHeight) {
        if (($aNewImageWidth < 0) || ($aNewImageHeight < 0)) {
            return false;
        }

        // Массив с поддерживаемыми типами изображений
        $lAllowedExtensions = array(1 => "gif", 2 => "jpeg", 3 => "png");

        // Получаем размеры и тип изображения в виде числа
        list($lInitialImageWidth, $lInitialImageHeight, $lImageExtensionId) = getimagesize($aInitialImageFilePath);

        if (!array_key_exists($lImageExtensionId, $lAllowedExtensions)) {
            return false;
        }
        $lImageExtension = $lAllowedExtensions[$lImageExtensionId];

        // Получаем название функции, соответствующую типу, для создания изображения
        $func = 'imagecreatefrom' . $lImageExtension;
        // Создаём дескриптор исходного изображения
        $lInitialImageDescriptor = $func($aInitialImageFilePath);

        // Определяем отображаемую область
        $lCroppedImageWidth = 0;
        $lCroppedImageHeight = 0;
        $lInitialImageCroppingX = 0;
        $lInitialImageCroppingY = 0;
        if ($aNewImageWidth / $aNewImageHeight > $lInitialImageWidth / $lInitialImageHeight) {
            $lCroppedImageWidth = floor($lInitialImageWidth);
            $lCroppedImageHeight = floor($lInitialImageWidth * $aNewImageHeight / $aNewImageWidth);
            $lInitialImageCroppingY = floor(($lInitialImageHeight - $lCroppedImageHeight) / 2);
        } else {
            $lCroppedImageWidth = floor($lInitialImageHeight * $aNewImageWidth / $aNewImageHeight);
            $lCroppedImageHeight = floor($lInitialImageHeight);
            $lInitialImageCroppingX = floor(($lInitialImageWidth - $lCroppedImageWidth) / 2);
        }

        // Создаём дескриптор для выходного изображения
        $lNewImageDescriptor = imagecreatetruecolor($aNewImageWidth, $aNewImageHeight);
        imagecopyresampled($lNewImageDescriptor, $lInitialImageDescriptor, 0, 0, $lInitialImageCroppingX, $lInitialImageCroppingY, $aNewImageWidth, $aNewImageHeight, $lCroppedImageWidth, $lCroppedImageHeight);
        $func = 'image' . $lImageExtension;

        // сохраняем полученное изображение в указанный файл
        return $func($lNewImageDescriptor, $aNewImageFilePath);
    }

}
