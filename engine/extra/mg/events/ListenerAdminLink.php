<?php

namespace mg\events;

use adminmenu\events\EventAdminLink;

class ListenerAdminLink {

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
    public function handle(EventAdminLink $event) {





        $subs = array();


        $listtables = \db\JsonQuery::all("collections", "title", "ASC");
        if (count($listtables)) {
            foreach ($listtables as $table) {
                $subs[] = array(
                    'href' => 'mg/manage/index/' . $table->name,
                    'title' => $table->title,
                    'nav' => $table->name,
                    'name_rule' => array("content_mg_" . $table->name, "allcontent"),
                    'onlyroot' => false,
                    'icon' => 'fa-pencil',
                );
            }
        }

        $subs[] = array(
            'href' => 'mg/collections/index',
            'title' => __("backend/admin_links.all_collections"),
            'nav' => 'collections',
            'name_rule' => "allcontent",
            'onlyroot' => false,
            'icon' => 'fa-cog',
        );
//        \plugsystem\GlobalParams::set("load_links_content", array());
//        \plugsystem\models\EventModel::run("load_links_content", array());
//        $sub_links = \plugsystem\GlobalParams::get("load_links_content");
//        if (isset($sub_links) and is_array($sub_links)) {
//            $subs = array_merge($subs, $sub_links);
//        }



        $event->add('#', __("backend/admin_links.content_mg"), "mg", "", false, "fa-pencil-square-o", $subs);

























        return true;
    }

}
