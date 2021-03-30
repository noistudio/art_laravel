<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InstallNoiStudioLibrary extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        if (!\core\ManagerConf::isOnlyMongodb()) {


            Schema::create('elfinder_files', function (Blueprint $table) {
                $table->string('file', 200);
                $table->increments('id_file');
                $table->string("min_image", 200);
                $table->string("type", 255);
            });
            Schema::create('multiselect', function (Blueprint $table) {

                $table->string("data_table", 200);
                $table->string("from_table", 200);
                $table->string("value", 200);
                $table->increments('last_id');
                $table->integer("row_id");
            });
        }

        $files = scandir(LAZER_DATA_PATH);
        if (count($files)) {
            foreach ($files as $file) {
                if ($file != "_object.config.json" and $file != "_object.data.json") {
                    $path_to_file = LAZER_DATA_PATH . "/" . $file;

                    $is_config = str_replace("config.json", "", $file);
                    $is_data = str_replace("data.json", "", $file);
                    if ($file != $is_config or $file != $is_data) {
                        $content_file = file_get_contents($path_to_file);
                        $json = json_decode($content_file, true);
                        if ($file != $is_config) {
                            $json['last_id'] = 0;
                        } else if ($file != $is_data) {
                            $json = array();
                        }
                        file_put_contents($path_to_file, json_encode($json));
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (!\core\ManagerConf::isOnlyMongodb()) {

            Schema::dropIfExists('elfinder_files');
            Schema::dropIfExists('multiselect');
        }

//        $files = scandir(LAZER_DATA_PATH);
//        if (count($files)) {
//            foreach ($files as $file) {
//                if ($file != "_object.config.json" and $file != "_object.data.json") {
//                    $path_to_file = LAZER_DATA_PATH . "/" . $file;
//
//                    $is_config = str_replace("config.json", "", $file);
//                    $is_data = str_replace("data.json", "", $file);
//                    if ($file != $is_config or $file != $is_data) {
//                        $content_file = file_get_contents($path_to_file);
//                        $json = json_decode($content_file, true);
//                        if ($file != $is_config) {
//                            $json['last_id'] = 0;
//                        } else if ($file != $is_data) {
//                            $json = array();
//                        }
//                        file_put_contents($path_to_file, json_encode($json));
//                    }
//                }
//            }
//        }
    }

}
