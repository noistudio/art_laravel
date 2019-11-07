<?php

namespace builder\models;

class BuilderModel {

    static function runWithHtml($html) {

//        $main_file = \plugsystem\GlobalParams::getDocumentRoot() . "/themefrontend/main.php";
//        $data['plugin'] = $html;
//
//        $return_result = \plugsystem\GlobalParams::render($main_file, $data, false);
//
//        \plugsystem\GlobalParams::set("result_render", $return_result);
//        \plugsystem\models\EventModel::run("before_return", array());
//        $return_result = \plugsystem\GlobalParams::get("result_render");
//
//        return $return_result;
    }

    static function preview() {
        $post = request()->post();
        $session = new \plugsystem\models\SessionModel;
        if (isset($post['page']) and is_string($post['page']) and strlen($post['page']) > 0) {
            $session->set("preview_page", $post['page']);
        }

        $result = $session->get("preview_page");
        if (is_string($result)) {
            return $result;
        } else {
            return false;
        }
    }

    static function upload() {
        $document_root = public_path();
        $uploads_dir = $document_root . '/files/tmpfiles/'; //specify the upload folder, make sure it's writable!
        $relative_path = '/files/tmpfiles/'; //specify the relative path from your elements to the upload folder

        $allowed_types = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/svg", "application/pdf");


        /* DON'T CHANGE ANYTHING HERE!! */

        $return = array();


        //does the folder exist?
        if (!file_exists($uploads_dir)) {

            $return['code'] = 0;
            $return['response'] = "The specified upload location does not exist. Please provide a correct folder in /iupload.php";

            die(json_encode($return));
        }

        //is the folder writable?
        if (!is_writable($uploads_dir)) {

            $return['code'] = 0;
            $return['response'] = "The specified upload location is not writable. Please make sure the specified folder has the correct write permissions set for it.";

            die(json_encode($return));
        }

        if (!isset($_FILES['imageFileField']['error']) || is_array($_FILES['imageFileField']['error'])) {

            $return['code'] = 0;
            $return['response'] = "Something went wrong with the file upload; please refresh the page and try again.";

            die(json_encode($return));
        }

        $name = $_FILES['imageFileField']['name'];

        $file_type = $_FILES['imageFileField']['type'];


        if (in_array($file_type, $allowed_types)) {

            if (move_uploaded_file($_FILES['imageFileField']['tmp_name'], $uploads_dir . "/" . $name)) {

                //echo "yes";
            } else {

                $return['code'] = 0;
                $return['response'] = "The uploaded file couldn't be saved. Please make sure you have provided a correct upload folder and that the upload folder is writable.";
            }

            //print_r ($_FILES);

            $return['code'] = 1;
            $return['response'] = $relative_path . "/" . $name;
        } else {

            $return['code'] = 0;
            $return['response'] = "File type not allowed";
        }



        return json_encode($return);
    }

    static function setMenu() {
        $html = \core\AppConfig::get("plugins_menu");
        if (!is_string($html)) {
            $html = "";
        }


        $data = array();
        $html .= view("app::plugin/builder/menu/menu", $data)->render();


        \core\AppConfig::set("plugins_menu", $html);
    }

}
