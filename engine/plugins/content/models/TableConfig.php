<?php

namespace content\models;

use Illuminate\Support\Facades\Artisan;
use Lazer\Classes\Database as Lazer;

class TableConfig
{

    static function actions()
    {
        return array();
    }

    static function makeMigrationDelete($table, $field)
    {


        $json_field = $table['fields'][$field];
        $json_field['name'] = $field;
        $name_table = $table['name'];
        Artisan::call('make:migration', [
            'name' => 'crud_' . $name_table . "_remove_field_" . $field
        ]);


        $path_to_migrations = base_path("database/migrations");
        $files = scandir($path_to_migrations);
        $file_migrate = null;
        foreach ($files as $key => $file) {
            $next_key = $key + 1;
            if (!isset($files[$next_key])) {
                $file_migrate = $files[$key];
            }
        }
        $path_to_migration = base_path("database/migrations/" . $file_migrate);
        $content_migration = file_get_contents($path_to_migration);
        $occurrence = strpos($content_migration, "//");
        $content_migration = substr_replace($content_migration, "[upcode]", strpos($content_migration, "//"), strlen("//"));
        $occurrence = strpos($content_migration, "//");
        $content_migration = substr_replace($content_migration, "[downcode]", strpos($content_migration, "//"), strlen("//"));
        //
        $template_migration_up = config('admin.template_migration_remove_up');
        $template_migration_up = str_replace("[field]", "'" . $field . "'", $template_migration_up);
        $template_migration_up = str_replace("%name_table%", "'" . $name_table . "'", $template_migration_up);

        $template_migration_down = config('admin.template_migration_remove_down');
        $template_migration_down = str_replace("%name_table%", "'" . $name_table . "'", $template_migration_down);
        $template_migration_down = str_replace("[JSON_DATA]", "'" . json_encode(array($json_field['name'] => $json_field)) . "'", $template_migration_down);


        $content_migration = str_replace("[upcode]", $template_migration_up, $content_migration);
        $content_migration = str_replace("[downcode]", $template_migration_down, $content_migration);


        $path_to_migrations = base_path("database/migrations");
        file_put_contents($path_to_migration, $content_migration);
        Artisan::call('migrate');

        return true;
    }

    static function makeMigrationUpdate($update_fields, $name_table)
    {
        $names_fields = array();
        foreach ($update_fields as $upd_key => $upd_f) {
            $names_fields[] = $upd_key;
        }
        Artisan::call('make:migration', [
            'name' => 'crud_' . $name_table . "_add_field_" . implode("_", $names_fields)
        ]);

        $path_to_migrations = base_path("database/migrations");
        $files = scandir($path_to_migrations);
        $file_migrate = null;
        foreach ($files as $key => $file) {
            $next_key = $key + 1;
            if (!isset($files[$next_key])) {
                $file_migrate = $files[$key];
            }
        }
        $path_to_migration = base_path("database/migrations/" . $file_migrate);
        $content_migration = file_get_contents($path_to_migration);
        $occurrence = strpos($content_migration, "//");
        $content_migration = substr_replace($content_migration, "[upcode]", strpos($content_migration, "//"), strlen("//"));
        $occurrence = strpos($content_migration, "//");
        $content_migration = substr_replace($content_migration, "[downcode]", strpos($content_migration, "//"), strlen("//"));
        //
        $template_migration_up = config('admin.template_migration_update_up');
        $template_migration_up = str_replace("[JSON_DATA]", "'" . json_encode($update_fields) . "'", $template_migration_up);
        $template_migration_up = str_replace("%name_table%", "'" . $name_table . "'", $template_migration_up);

        $template_migration_down = config('admin.template_migration_update_down');
        $template_migration_down = str_replace("%name_table%", "'" . $name_table . "'", $template_migration_down);
        $template_migration_down = str_replace("[JSON_DATA]", "'" . json_encode($update_fields) . "'", $template_migration_down);


        $content_migration = str_replace("[upcode]", $template_migration_up, $content_migration);
        $content_migration = str_replace("[downcode]", $template_migration_down, $content_migration);


        $path_to_migrations = base_path("database/migrations");
        file_put_contents($path_to_migration, $content_migration);
        Artisan::call('migrate');

        return true;
    }

    static function makeMigration($json)
    {

        Artisan::call('make:migration', [
            'name' => 'crud_' . $json['name']
        ]);

        $path_to_migrations = base_path("database/migrations");
        $files = scandir($path_to_migrations);
        $file_migrate = null;
        foreach ($files as $key => $file) {
            $next_key = $key + 1;
            if (!isset($files[$next_key])) {
                $file_migrate = $files[$key];
            }
        }
        $path_to_migration = base_path("database/migrations/" . $file_migrate);
        $content_migration = file_get_contents($path_to_migration);
        $occurrence = strpos($content_migration, "//");
        $content_migration = substr_replace($content_migration, "[upcode]", strpos($content_migration, "//"), strlen("//"));
        $occurrence = strpos($content_migration, "//");
        $content_migration = substr_replace($content_migration, "[downcode]", strpos($content_migration, "//"), strlen("//"));
        //
        $template_migration_up = config('admin.template_migration_up');
        $template_migration_up = str_replace("[JSON_DATA]", "'" . json_encode($json) . "'", $template_migration_up);
        $template_migration_down = config('admin.template_migration_down');
        $template_migration_down = str_replace("%name_table%", "'" . $json['name'] . "'", $template_migration_down);


        $content_migration = str_replace("[upcode]", $template_migration_up, $content_migration);
        $content_migration = str_replace("[downcode]", $template_migration_down, $content_migration);


        $path_to_migrations = base_path("database/migrations");
        file_put_contents($path_to_migration, $content_migration);
        Artisan::call('migrate');

        return true;


    }

    static function addField($table, $key, $field)
    {
        /*
          ALTER TABLE `cms`.`team`
          ADD COLUMN `add` VARCHAR(45) NULL AFTER `content`;

         */
        $class = "\\content\\fields\\" . $field['type'];

        $obj = new $class($key, $key);


        $result = \Schema::table($table->name, function ($table) use ($obj) {
            $obj->setTypeLaravel($table);
        });


//        $sql = ' ALTER TABLE `' . $table->name . '`
//          ADD COLUMN ' . $additional_sql . ' AFTER `last_id`;';
        // $result = \DB::statement($sql);
    }

    static function deleteFieldAdmin($table, $field)
    {
        if (count($table['fields']) == 1) {
            \core\Notify::add(__("backend/content.err12"));
            return false;
        }
        TableConfig::makeMigrationDelete($table, $field);

    }


    static function deleteField($table, $field)
    {
        if (count($table['fields']) == 1) {
            \core\Notify::add(__("backend/content.err12"));
            return false;
        }


        unset($table['fields'][$field]);
        $object = \db\JsonQuery::get($table['name'], "tables", "name");
        $object->fields = json_encode($table['fields']);


//        $sql = 'ALTER TABLE `' . $table['name'] . '` 
//DROP COLUMN `' . $field . '`;';
//        $result = \DB::statement($sql);


        $result = \Schema::table($table['name'], function ($table_obj) use ($field) {
            $table_obj->dropColumn($field);
        });
        $object->save();
    }

    static function delete($nametable)
    {

        $table = TableConfig::get($nametable);
        if (isset($table) and is_object($table) and !is_null($table->name)) {
            return false;
        }
        Lazer::table('tables')->where('name', '=', $nametable)->find()->delete();


        //\db\SqlQuery::delete($nametable, array());
        \Schema::dropIfExists($nametable);
        \Cache::forget('events.EventAdminLink');
    }

    static function edit($row)
    {
        $post = request()->post();

        $table = \db\JsonQuery::get($row['name'], "tables", "name");

        if ((isset($post['count']) and is_numeric($post['count']) and (int)$post['count'] > 0)) {
            $table->count = (int)$post['count'];
        }
        if ((isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            $table->title = strip_tags($post['title']);
        }
        if (isset($post['sort']) and $post['sort'] == "arrow_sort") {
            $table->sort_field = "arrow_sort";
        }
        if (isset($post['sort']) and isset($row['fields'][$post['sort']])) {
            $table->sort_field = $post['sort'];
        }

        if (isset($post['sort_type']) and $post['sort_type'] == "ASC") {
            $table->sort_type = "ASC";
        }

        if (isset($post['sort_type']) and $post['sort_type'] == "DESC") {
            $table->sort_type = "DESC";
        }

        $fields = json_decode($table->fields, true);
        if (count($row['fields'])) {
            foreach ($row['fields'] as $field_name => $field) {
                $field['name'] = $field_name;
                $fields[$field['name']]['showinlist'] = 0;
                if (isset($post['fields'][$field['name']]['showinlist'])) {
                    $fields[$field['name']]['showinlist'] = 1;
                }
                $fields[$field['name']]['showsearch'] = 0;
                if (isset($post['fields'][$field['name']]['showsearch'])) {
                    $fields[$field['name']]['showsearch'] = 1;
                }
                $fields[$field['name']]['unique'] = 0;
                if (isset($post['fields'][$field['name']]['unique'])) {
                    $fields[$field['name']]['unique'] = 1;
                }

                if ((isset($post['fields'][$field['name']]['title']) and is_string($post['fields'][$field['name']]['title']) and strlen($post['fields'][$field['name']]['title']) > 0)) {
                    $fields[$field['name']]['title'] = strip_tags($post['fields'][$field['name']]['title']);
                }
                $order = 1;
                if (isset($post['fields'][$field['name']]['order']) and is_numeric($post['fields'][$field['name']]['order']) and (int)$post['fields'][$field['name']]['order'] >= 0) {
                    $order = (int)$post['fields'][$field['name']]['order'];
                }

                $fields[$field['name']]['order'] = $order;
                $required = 0;
                if (isset($post['fields'][$field['name']]['required'])) {
                    $required = 1;
                }
                $fields[$field['name']]['required'] = $required;
                if (count($field['config'])) {
                    foreach ($field['config'] as $key => $conf) {

                        if ($conf['type'] == "bool") {
                            $fields[$field['name']]['options'][$key] = false;
                            if (isset($post['fields'][$field['name']]['options'][$key])) {
                                $fields[$field['name']]['options'][$key] = true;
                            }
                        } else if ($conf['type'] == "int") {
                            if (!(isset($post['fields'][$field['name']]['options'][$key]) and is_numeric($post['fields'][$field['name']]['options'][$key]) and (int)$post['fields'][$field['name']]['options'][$key] >= 0)) {

                            } else {
                                $fields[$field['name']]['options'][$key] = (int)$post['fields'][$field['name']]['options'][$key];
                            }
                        } else if ($conf['type'] == "text") {
                            if (!(isset($post['fields'][$field['name']]['options'][$key]) and is_string($post['fields'][$field['name']]['options'][$key]) and strlen($post['fields'][$field['name']]['options'][$key]) > 0)) {
                                // $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = $post['fields'][$field['name']]['options'][$key];
                            }
                        } else if ($conf['type'] == "select") {

                            if (!(isset($post['fields'][$field['name']]['options'][$key]))) {
                                //$fields[$field['name']]['options'][$key] = null;
                            } else {

                                if (isset($conf['options'])) {
                                    foreach ($conf['options'] as $option) {
                                        if ((string)$option['value'] == (string)$post['fields'][$field['name']]['options'][$key]) {
                                            $fields[$field['name']]['options'][$key] = $post['fields'][$field['name']]['options'][$key];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $update_fields = array();
        if (isset($post['newfields']) and is_array($post['newfields']) and count($post['newfields'])) {
            foreach ($post['newfields'] as $field) {
                $options = array();
                if (!(isset($field['name']) and is_string($field['name']) and preg_match('/^\w{2,}$/', $field['name']))) {
                    \core\Notify::add(__("backend/content.err13"), "error");
                    return false;
                }
                $field['name'] = strtolower($field['name']);


                if (isset($fields[$field['name']])) {
                    \core\Notify::add(__("backend/content.err14", array('name' => $field['name'])), "error");
                    return false;
                }

                if (!(isset($field['title']) and is_string($field['title']) and strlen($field['title']) > 0)) {
                    \core\Notify::add(__("backend/content.err15", array('name' => $field['name'])), "error");
                    return false;
                }
                $row = null;
                if (!(isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) and class_exists("\\content\fields\\" . $field['type'])) {

                    \core\Notify::add(__("backend/content.err16", array('type' => $field['type'])), "error");
                    return false;
                }


                if (isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) {
                    $row = TableConfig::getField($field['type'], $table->name);
                }
                if (is_null($row)) {
                    \core\Notify::add(__("backend/content.err16", array('type' => $field['type'])), "error");
                    return false;
                }

                if (!is_array($row)) {
                    \core\Notify::add(__("backend/content.err16", array('type' => "")), "error");
                    return false;
                }
                $showinlist = 0;
                if (isset($field['showinlist'])) {
                    $showinlist = 1;
                }
                $showsearch = 0;
                if (isset($field['showsearch'])) {
                    $showsearch = 1;
                }
                $required = 0;
                if (isset($field['required'])) {
                    $required = 1;
                }


                $unique = 0;
                if (isset($field['unique'])) {
                    $unique = 1;
                }


                $order = 1;
                if (isset($field['order']) and is_numeric($field['order']) and (int)$field['order'] >= 0) {
                    $order = (int)$field['order'];
                }
                $fields[$field['name']] = array('unique' => $unique, 'showsearch' => $showsearch, 'order' => $order, 'required' => $required, 'showinlist' => $showinlist, 'title' => $field['title'], 'type' => $field['type'], 'options' => array());

                if (count($row['config'])) {
                    foreach ($row['config'] as $key => $conf) {
//                        if (!isset($field['options'][$key])) {
//                            \core\Notify::add("Вы не ввели параметр " . $key . " для поля " . $field['name'], "error");
//                            return false;
//                        }
                        $fields[$field['name']]['options'][$key] = null;
                        if ($conf['type'] == "bool") {
                            $fields[$field['name']]['options'][$key] = false;
                            if (isset($field['options'][$key])) {
                                $fields[$field['name']]['options'][$key] = true;
                            }
                        } else if ($conf['type'] == "int") {

                            if (!(isset($field['options'][$key]) and is_numeric($field['options'][$key]) and (int)$field['options'][$key] >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = (int)$field['options'][$key];
                            }
                        } else if ($conf['type'] == "text") {
                            if (!(isset($field['options'][$key]) and is_string($field['options'][$key]) and strlen($field['options'][$key]) >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = $field['options'][$key];
                            }
                        } else if ($conf['type'] == "select") {
                            if (!(isset($field['options'][$key]))) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {

                                if (isset($conf['options'])) {
                                    foreach ($conf['options'] as $option) {
                                        if ((string)$option['value'] == (string)$field['options'][$key]) {
                                            $fields[$field['name']]['options'][$key] = $field['options'][$key];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $update_fields[$field['name']] = $fields[$field['name']];

                // TableConfig::addField($table, $field['name'], $fields[$field['name']]);
            }
        }
        if (count($update_fields) > 0) {
            TableConfig::makeMigrationUpdate($update_fields, $table->name);
        } else {
            $table->fields = json_encode($fields);
            $table->save();
        }


        return true;
    }

    static function add()
    {
        $post = request()->post();
        if (!(isset($post['count']) and is_numeric($post['count']) and (int)$post['count'] > 0)) {
            \core\Notify::add(__("backend/content.err17"), "error");
            return false;
        }

        if (!(isset($post['name']) and is_string($post['name']) and preg_match('/^\w{2,}$/', $post['name']))) {
            \core\Notify::add(__("backend/content.err18"), "error");
            return false;
        }

        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \core\Notify::add(__("backend/content.err19"), "error");
            return false;
        }

        $post['name'] = strtolower($post['name']);
        $table = \db\JsonQuery::get($post['name'], "tables", "name");

        if (is_object($table) and isset($table->name) and $table->name != null) {
            \core\Notify::add(__("backend/content.err20", array('name' => $post['name'])), "error");
            return false;
        }
        $fields = array();

        if (isset($post['fields']) and is_array($post['fields']) and count($post['fields'])) {
            foreach ($post['fields'] as $field) {
                $options = array();
                if (!(isset($field['name']) and is_string($field['name']) and preg_match('/^\w{2,}$/', $field['name']))) {
                    \core\Notify::add(__("backend/content.err13"), "error");
                    return false;
                }
                $field['name'] = strtolower($field['name']);
                if (isset($fields[$field['name']])) {
                    \core\Notify::add(__("backend/content.err14", array('name' => $field['name'])), "error");
                    return false;
                }

                if (!(isset($field['title']) and is_string($field['title']) and strlen($field['title']) > 0)) {
                    \core\Notify::add(__("backend/content.err15", array('name' => $field['name'])), "error");
                    return false;
                }
                $row = null;
                if (!(isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) and class_exists("\\content\fields\\" . $field['type'])) {

                    \core\Notify::add(__("backend/content.err16", array('type' => $field['type'])), "error");
                    return false;
                }


                if (isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) {
                    $row = TableConfig::getField($field['type'], $post['name']);
                }
                if (is_null($row)) {
                    \core\Notify::add(__("backend/content.err16", array('type' => $field['type'])), "error");
                    return false;
                }

                if (!is_array($row)) {
                    \core\Notify::add(__("backend/content.err16", array('type' => "")), "error");
                    return false;
                }
                $showinlist = 0;
                if (isset($field['showinlist'])) {
                    $showinlist = 1;
                }
                $showsearch = 0;
                if (isset($field['showsearch'])) {
                    $showsearch = 1;
                }
                $required = 0;
                if (isset($field['required'])) {
                    $required = 1;
                }
                $unique = 0;
                if (isset($field['unique'])) {
                    $unique = 1;
                }
                $order = 1;
                if (isset($field['order']) and is_numeric($field['order']) and (int)$field['order'] >= 0) {
                    $order = (int)$field['order'];
                }
                $fields[$field['name']] = array('unique' => $unique, 'showsearch' => $showsearch, 'order' => $order, 'required' => $required, 'showinlist' => $showinlist, 'title' => $field['title'], 'type' => $field['type'], 'options' => array());
                if (count($row['config'])) {
                    foreach ($row['config'] as $key => $conf) {
//                        if (!isset($field['options'][$key])) {
//                            \core\Notify::add("Вы не ввели параметр " . $key . " для поля " . $field['name'], "error");
//                            return false;
//                        }
                        $fields[$field['name']]['options'][$key] = null;
                        if ($conf['type'] == "bool") {
                            $fields[$field['name']]['options'][$key] = false;
                            if (isset($field['options'][$key])) {
                                $fields[$field['name']]['options'][$key] = true;
                            }
                        } else if ($conf['type'] == "int") {

                            if (!(isset($field['options'][$key]) and is_numeric($field['options'][$key]) and (int)$field['options'][$key] >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = (int)$field['options'][$key];
                            }
                        } else if ($conf['type'] == "text") {
                            if (!(isset($field['options'][$key]) and is_string($field['options'][$key]) and strlen($field['options'][$key]) >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = $field['options'][$key];
                            }
                        } else if ($conf['type'] == "select") {
                            if (!(isset($field['options'][$key]))) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {

                                if (isset($conf['options'])) {
                                    foreach ($conf['options'] as $option) {
                                        if ((string)$option['value'] == (string)$field['options'][$key]) {
                                            $fields[$field['name']]['options'][$key] = $field['options'][$key];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (count($fields) == 0) {
            \core\Notify::add(__("backend/content.err21"), "error");
            return false;
        }

        $newtable = \db\JsonQuery::insert("tables");
        $newtable->name = $post['name'];
        $newtable->fields = json_encode($fields);
        $newtable->title = strip_tags($post['title']);
        $newtable->count = (int)$post['count'];
        $newtable->sort_field = "arrow_sort";
        $newtable->sort_type = "ASC";

        $json_table = array();
        $json_table['name'] = $post['name'];
        $json_table['fields'] = $fields;
        $json_table['title'] = strip_tags($post['title']);
        $json_table['count'] = (int)$post['count'];
        $json_table['sort_field'] = "arrow_sort";
        $json_table['sort_type'] = "ASC";

        TableConfig::makeMigration($json_table);

        return true;

//        TableConfig::createTable($newtable);
//
//        $newtable->save();
//
//        return true;
    }

    static function createTable($table)
    {
        $fields = json_decode($table->fields, true);
        $additional_sql = "";


        $result = \Schema::create($table->name, function ($table) use ($fields) {
            $table->increments('last_id');
            $table->timestamps();
            $table->integer("enable")->nullable()->default(0);
            $table->binary("action")->nullable();
            $table->integer("sort")->nullable();
            $table->string("_lng", 200)->nullable();
            foreach ($fields as $key => $field) {


                $class = "\\content\\fields\\" . $field['type'];

                $obj = new $class($key, $key);
                $obj->setTypeLaravel($table);
            }
        });


//        $sql = 'CREATE TABLE `' . $table->name . '` (
//  `last_id` INT NOT NULL AUTO_INCREMENT,
//  ' . $additional_sql . '
//  `sort` INT NULL,`_lng` VARCHAR(200)  NULL,
//   `action` BLOB NULL,
//  `enable` INT NULL DEFAULT 0,
//  PRIMARY KEY (`last_id`));';
//
//
//
//        $result = \DB::statement($sql);
    }

    static function isExist($nametable)
    {

        $table = \db\JsonQuery::get($nametable, "tables", "name");

        if (is_object($table)) {
            return true;
        }
        return false;
    }

    static function fields()
    {
        $result = array();

        $files = scandir(\core\ManagerConf::plugins_path() . "content/fields/");
        if (count($files)) {
            foreach ($files as $file) {
                $tmp = str_replace(".php", "", $file);
                if ($file != $tmp) {
                    $class = "\\content\\fields\\" . $tmp;
                    $obj = new $class("test", "test");
                    $result[] = array('name' => $tmp, 'obj' => $obj, 'title' => $obj->getFieldTitle());
                }
            }
        }
        return $result;
    }

    static function eventTypes()
    {
        $result = \blocks\models\BlocksModel::allTypes();
        return $result;
    }

    static function listTypes()
    {

    }

    static function event()
    {

    }

    static function get($table)
    {

        $row = \db\JsonQuery::get($table, "tables", "name");
        if (!(is_object($row) and isset($row->name) and !is_null($row->name))) {
            return null;
        } else {


            $row = array('sort_field' => $row->sort_field, 'sort_type' => $row->sort_type, 'name' => $row->name, 'count' => $row->count, 'title' => $row->title, 'fields' => $row->fields);

            $row['fields'] = json_decode($row['fields'], true);


            foreach ($row['fields'] as $key => $field) {
                $tmp = TableConfig::getFieldbyName($key, $table);

                $row['fields'][$key]['type_name'] = $tmp['title'];
                $row['fields'][$key]['config'] = $tmp['config'];
                $row['fields'][$key]['obj'] = $tmp['obj'];
            }
        }
        return $row;
    }

    static function getFieldbyName($name, $tablename = "")
    {

        $row = \db\JsonQuery::get($tablename, "tables", "name");
        $fields = json_decode($row->fields, true);
        $return = null;

        if (count($fields)) {
            foreach ($fields as $key => $row) {
                if ($key == $name) {
                    $options = array();
                    if (isset($row['options'])) {
                        $options = $row['options'];
                    }

                    $class = "\\content\\fields\\" . $row['type'];
                    $obj = new $class("", $key, $options, $required = false, $placeholder = "", $css_class = "", $tablename);
                    $tmp = $obj->getConfigOptions();

                    $array = array();
                    $array = $row;
                    $row['name'] = $key;
                    $row['title'] = $obj->getFieldTitle();
                    $row['config'] = $tmp;
                    $row['obj'] = $obj;

                    $return = $row;
                    break;
                }
            }
        }
        return $return;
    }

    static function getField($name)
    {

        $return = null;
        $result = TableConfig::fields();
        if (count($result)) {
            foreach ($result as $row) {
                if ($row['name'] == $name) {
                    $options = array();
                    if (isset($row['options'])) {
                        $options = $row['options'];
                    }

                    $class = "\\content\\fields\\" . $name;
                    $obj = new $class("test", $row['name']);
                    $tmp = $obj->getConfigOptions();
                    $array = array();
                    $array = $row;
                    $array['name'] = $row['name'];
                    $array['config'] = $tmp;
                    $array['obj'] = $tmp;
                    $return = $array;
                    break;
                }
            }
        }
        return $return;
    }

}
