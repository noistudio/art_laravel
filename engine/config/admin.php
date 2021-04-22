<?php

return [
    "template_migration_remove_up" => '
    $field=[field];
    $table = \content\models\TableConfig::get(%name_table%);
    \content\models\TableConfig::deleteField($table, $field);
    ',
    "template_migration_remove_down" => '
    $table = \content\models\TableConfig::get(%name_table%);
      $newtable = \db\JsonQuery::get($table["name"], "tables", "name");

        $fields = json_decode($newtable->fields, true);
         $json_data = [JSON_DATA];
         $table_data = json_decode($json_data, true);
         foreach($table_data as $name_field=>$new_field){
              $fields[$name_field] = $new_field;
            \content\models\TableConfig::addField($newtable, $name_field, $new_field);
            
     
        }
        $newtable->fields = json_encode($fields);
        $newtable->save();
    ',
    "template_migration_update_down" => '
         $table = \content\models\TableConfig::get(%name_table%);
         $json_data = [JSON_DATA];
         $table_data = json_decode($json_data, true);
         foreach($table_data as $name_field=>$new_field){
        if (is_array($table) and isset($name_field) and is_string($name_field) > 0 and isset($table["fields"][$name_field])) {
            \content\models\TableConfig::deleteField($table, $name_field);
        }
        }
  ',
    "template_migration_update_up" => '$json_data = [JSON_DATA];

        $table_data = json_decode($json_data, true);
            
        $newtable  = \db\JsonQuery::get(%name_table%, "tables", "name");
        
        $fields=json_decode($newtable->fields,true);
        foreach($table_data as $name_field=>$new_field){
        $fields[$name_field]=$new_field;
        \content\models\TableConfig::addField($newtable, $name_field, $new_field); 
        } 
        $newtable->fields = json_encode($fields);
        

        $newtable->save();',
    "template_migration_down" => '\content\models\TableConfig::delete(%name_table%);',

    "template_migration_up" => '
   $json_data = [JSON_DATA];

        $table_data = json_decode($json_data, true);

        $newtable = \db\JsonQuery::insert("tables");
        $newtable->name = $table_data["name"];
        $newtable->fields = json_encode($table_data["fields"]);
        $newtable->title = $table_data["title"];
        $newtable->count = $table_data["count"];
        $newtable->sort_field = $table_data["sort_field"];
        $newtable->sort_type = $table_data["sort_type"];
        \content\models\TableConfig::createTable($newtable);

        $newtable->save();
  ',
    "template_form_migration_down" => '$query = \Lazer\Classes\Database::table("forms")->orderBy("id", "DESC")->findAll();


        if (count($query)) {
            foreach ($query as $q) {
                \forms\models\FormConfig::delete($q->id);
                break;
            }
        }',
    "template_form_migration_up" => '
   $json_data = [JSON_DATA];

        $table_data = json_decode($json_data, true);

         $newform = \db\JsonQuery::insert("forms");
        $newform->id=1;
        $newform->fields = json_encode($table_data["fields"]);
        $newform->title = $table_data["title"];
        $newform->email = $table_data["email"];
        $newform->notify = "";
        $newform->type = $table_data["type"];
        $newform->save();
        \forms\models\FormConfig::createTable($newform);

        
  ',
];
