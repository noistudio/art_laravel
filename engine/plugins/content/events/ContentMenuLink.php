<?php

namespace content\events;

use menu\events\MenuLink;

class ContentMenuLink {

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





        $tables = \db\JsonQuery::all("tables");

        if (count($tables)) {
            foreach ($tables as $table) {
                $fields = json_decode($table->fields, true);
                $path_to_template = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/content/";

                if (file_exists($path_to_template . "" . $table->name . "_list.php")) {

                    $event->add('frontend/content/' . $table->name . "/list", __("backend/content.list_raz", array("title" => $table->title)));

                    if (\languages\models\LanguageHelp::is("frontend")) {
                        $languages = \languages\models\LanguageHelp::getAll("frontend");
                        foreach ($languages as $language) {
                            $event->add(route('frontend/content/' . $table->name . "/list_lang", $language, array(), false), __("backend/content.list_raz_lng", array("title" => $table->title, 'lng' => $language)));
                        }
                    }
                }
                $model = \content\models\MasterTable::find($table->name);

                $data = $model->getRows();
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
                                $url = route('frontend/content/' . $table->name . "/one", $row['last_id'], false);
                                $event->add($url, __("backend/content.onedoc", array("table" => $table->title, "title" => $title)));
                            }
                        }
                    }
                }
            }
        }



























        return true;
    }

}
