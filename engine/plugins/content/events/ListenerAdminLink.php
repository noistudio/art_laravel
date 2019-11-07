<?php

namespace content\events;

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


        $params = array();
        $params['ismongodb'] = false;
        if (!(isset($params['ismongodb']) and $params['ismongodb'] == true)) {
            $listtables = \db\JsonQuery::all("tables", "title", "ASC");
            if (count($listtables)) {
                foreach ($listtables as $table) {
                    $subs[] = array(
                        'href' => 'content/manage/index/' . $table->name,
                        'title' => $table->title,
                        'nav' => $table->name,
                        'name_rule' => array("content_" . $table->name, "allcontent"),
                        'onlyroot' => false,
                        'icon' => 'fa-pencil',
                    );
                }
            }
        }

        if (!(isset($params['ismongodb']) and $params['ismongodb'] == true)) {
            $subs[] = array(
                'href' => 'content/tables/index',
                'title' => __("backend/admin_links.all_tables"),
                'nav' => 'tables',
                'name_rule' => "allcontent",
                'onlyroot' => false,
                'icon' => 'fa-cog',
            );
        }
//        \plugsystem\GlobalParams::set("load_links_content", array());
//        \plugsystem\models\EventModel::run("load_links_content", array());
//        $sub_links = \plugsystem\GlobalParams::get("load_links_content");
//        if (isset($sub_links) and is_array($sub_links)) {
//            $subs = array_merge($subs, $sub_links);
//        }



        $event->add('#', __("backend/admin_links.content"), "content", "", false, "fa-pencil-square-o", $subs);

























        return true;
    }

}
