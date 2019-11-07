<?php

namespace menu\events;

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
        $menus = \db\JsonQuery::all("menus");
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $subs[] = array(
                    'href' => 'menu/update/' . $menu->id,
                    'title' => $menu->title,
                    'nav' => 'menu' . $menu->id,
                    'name_rule' => array("menu_" . $menu->id, "menu_see"),
                    'onlyroot' => false,
                    'icon' => 'fa-pencil',
                );
            }
        }

        $subs[] = array(
            'href' => 'menu/index',
            'title' => __("backend/admin_links.menu_link_all"),
            'nav' => 'menu',
            'name_rule' => "menu_see",
            'onlyroot' => false,
            'icon' => 'fa-cog',
        );





        $event->add('#', __("backend/admin_links.menu_link"), "menu", "", false, "fa-th", $subs);
    }

}
