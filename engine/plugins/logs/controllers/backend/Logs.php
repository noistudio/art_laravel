<?php

namespace logs\controllers\backend;

use Lazer\Classes\Database as Lazer;

class Logs extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex() {


        \Log::info('123123123');

        $data = array();
        $data['rows'] = \db\JsonQuery::all("logs");





        return $this->render("list", $data);
    }

//    public function actionClearfile($id) {
//        $get_vars = \yii::$app->request->get();
//        $log = \logs\models\LogsModel::get($id);
//        if (is_object($log) and $log->type == "file") {
//            $path = \Yii::getAlias('@runtime/logs/' . $log->namefile);
//            //open file to write
//            $fp = fopen($path, "r+");
//// clear content to 0 bits
//            ftruncate($fp, 0);
////close file
//            fclose($fp);
//            NotifyModel::add("Файл успешно очищен!");
//            GlobalParams::$helper->returnback();
//        }
//    }
//    public function actionRead($id) {
//
//        $get_vars = \yii::$app->request->get();
//        $log = \logs\models\LogsModel::get($id);
//        if (is_object($log) and $log->type == "file") {
//            $path = \Yii::getAlias('@runtime/logs/' . $log->namefile);
//            $file = pathinfo($path);
//
//
//            $data = array();
//            $data['rows'] = array();
//            $data['log_file'] = $log->namefile;
//            if (file_exists($path)) {
//                $file = new \SplFileObject($path);
//// Loop until we reach the end of the file.
//                while (!$file->eof()) {
//                    // Echo one line from the file.
//                    $json = $file->fgets();
//                    $tmp = json_decode($json, true);
//
//                    $iscan = true;
//                    if (isset($get_vars['level']) and is_string($get_vars['level']) and strlen($get_vars['level']) > 1) {
//                        if (!($tmp['level'] == $get_vars['level'])) {
//                            $iscan = false;
//                        }
//                    }
//                    if (isset($get_vars['category']) and is_string($get_vars['category']) and strlen($get_vars['category']) > 1) {
//                        if (!($tmp['category'] == $get_vars['category'])) {
//                            $iscan = false;
//                        }
//                    }
//
//                    if ($iscan) {
//                        $data['rows'][] = $tmp;
//                    }
//                }
//            }
//
//
//
//
//            $data['get_vars'] = $get_vars;
//
//            return $this->render("read", $data);
//        }
//    }

    public function actionDelete($last_id) {

        \db\JsonQuery::delete((int) $last_id, "id", "logs");

        return back();
    }

}
