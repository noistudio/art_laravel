<?php

namespace mg\events;

use menu\events\MenuLink;

class MgMenuLink {

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
    public function handle(MenuLink $event) {





        $tables = \db\JsonQuery::all("collections");

        if (count($tables)) {
            foreach ($tables as $table) {
                $fields = json_decode($table->fields, true);
                $path_to_template = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/mg/";

                if (file_exists($path_to_template . "" . $table->name . "_list.php")) {

                    $event->add('/mg/' . $table->name . "/index", __("backend/mg.list_from_cat", array('name' => $table->title)));

                    if (\languages\models\LanguageHelp::is("frontend")) {
                        $languages = \languages\models\LanguageHelp::getAll("frontend");
                        foreach ($languages as $language) {
                            $url = route('frontend/mg/' . $table->name . "/list", array(), false);
                            $event->add("/" . $language . '/mg/' . $table->name . "/index", __("backend/mg.list_from_cat", array('name' => $table->title, 'language' => $language)));
                        }
                    }
                }

                $model = \mg\core\DynamicCollection::find($table->name);

                $data = $model->all();
                $fields = $model->getFieldsinList();
                if (count($data['rows'])) {
                    foreach ($data['rows'] as $row) {
                        $title = "";
                        if (count($fields)) {
                            foreach ($fields as $field) {
                                if (isset($row[$field['name']]) and ! is_array($row[$field['name']])) {
                                    $title .= " " . $row[$field['name']];
                                }
                            }
                            if (file_exists($path_to_template . "" . $table->name . "_one.php")) {
                                $url = route('frontend/mg/' . $table->name . "/one", $row['last_id'], false);
                                $event->add($url, 'Раздел  ' . $table->title . " Документ " . $title);
                            }
                        }
                    }
                }
            }
        }



























        return true;
    }

}
