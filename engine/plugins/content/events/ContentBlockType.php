<?php

namespace content\events;

use blocks\events\BlockType;

class ContentBlockType {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(BlockType $event) {




        $tables = \db\JsonQuery::all("tables");


        if (count($tables)) {
            foreach ($tables as $key => $table) {



                $fields = json_decode($table->fields, true);
                $id = $table->name . "_list";
                $event->add($id, "\\content\\models\\ContentBlock", $table->name, "list", __("backend/content.list_raz", array('title' => $table->title)));

                $model = \content\models\MasterTable::find($table->name);

                $table = $model->getTable();

                $data = $model->getRows();

                $fields = $model->getFieldsinList();

                if (count($data['rows'])) {
                    foreach ($data['rows'] as $row) {
                        $title = "";
                        if (count($fields)) {
                            foreach ($fields as $field) {

                                if (!is_array($row[$field['name']])) {
                                    $title .= " " . $row[$field['name']];
                                }
                            }
                            $id = $table->name . "_one_" . $row['last_id'];
                            $event->add($id, "\\content\\models\\ContentBlock", $table->name, $row['last_id'], __("backend/content.onedoc", array("table" => $table->title, "title" => $title)));
                        }
                    }
                }
            }
        }






























        return true;
    }

}
