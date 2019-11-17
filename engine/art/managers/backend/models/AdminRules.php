<?php

namespace managers\backend\models;

class AdminRules {

    static function getAll() {
        $tmp_rules = \core\AppConfig::get("app.tmp_rules");
        if (isset($tmp_rules) and is_array($tmp_rules) and count($tmp_rules) > 0) {
            return $tmp_rules;
        }


        $rules = array();


        $rules["subroot"] = array("title" => 'Доступ ко всему', "name" => 'subroot', "links" => array("*"));


        $rows = \db\SqlDocument::all("admin_access");
        if (count($rows)) {
            foreach ($rows as $key => $row) {
                if (!isset($rules[$row['name']])) {

                    $rules[$row['name']] = array('id' => $key, 'name' => $row['name'], "title" => $row['title'], "links" => $row['links']);
                }
            }
        }
        \Debugbar::startMeasure('load_all_admin_rules_event', 'Start search event admin rule');

        $event_admin_rule = new \admins\events\EventAdminRule();
        event($event_admin_rule);

        $rules2 = $event_admin_rule->get();

        $rules = array_merge($rules, $rules2);


        \core\AppConfig::set("app.tmp_rules", $rules);

        \Debugbar::stopMeasure('load_all_admin_rules_event');

        return $rules;
    }

}
