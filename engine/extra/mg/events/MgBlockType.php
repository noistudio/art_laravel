<?php

namespace mg\events;

use blocks\events\BlockType;

class MgBlockType {

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


        $tables = \db\JsonQuery::all("collections");

        if (count($tables)) {
            foreach ($tables as $table) {
                $fields = json_decode($table->fields, true);
                $id = $table->name . "_list";
                $event->add($id, "\\mg\core\\Block", $table->name, "list", __("backend/mg.list_from_cat", array("name" => $table->title)));

                $model = \mg\core\DynamicCollection::find($table->name);

                $data = $model->all();
                $fields = $model->getFieldsinList();
                if (count($data['rows'])) {
                    foreach ($data['rows'] as $row) {
                        $title = "";
                        if (count($fields)) {
                            foreach ($fields as $field) {

                                $title .= " " . $row[$field['name']];
                            }
                            $id = $table->name . "_one_" . $row['last_id'];
                            $event->add($id, "\\mg\core\\Block", $table->name, $row['last_id'], __("backend/mg.onedoc", array("table" => $table->title, 'title' => $title)));
                        }
                    }
                }
            }
        }



































        return true;
    }

}
