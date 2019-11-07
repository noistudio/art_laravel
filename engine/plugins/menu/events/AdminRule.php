<?php

namespace menu\events;

use admins\events\EventAdminRule;

class AdminRule {

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
    public function handle(EventAdminRule $event) {






        $blocks = \db\JsonQuery::all("menus");
        if (count($blocks)) {
            foreach ($blocks as $block) {
                $event->addRule('menu_' . $block->id, __("backend/menu.rule_menu") . " " . $block->title, array("/menu/arrows/up/" . $block->id, "/menu/arrows/down/" . $block->id, "/menu/update/editmenu/" . $block->id, "/menu/update/template/" . $block->id, "/menu/update/editlink/" . $block->id, "/menu/update/doeditlink/" . $block->id, "/menu/update/doedit/" . $block->id, "/menu/update/delete/" . $block->id, "/menu/update/add/" . $block->id, "/menu/update/index/" . $block->id, "/menu/update/" . $block->id));
            }
        }

        $event->addRule("menu_create", __("backend/menu.rule_create"), array("/menu/add", "/menu/doadd"));
        $event->addRule("menu_delete", __("backend/menu.rule_delete"), array("/menu/delete",));
        $event->addRule("menu edit", __("backend/menu.rule_edit"), array("/menu/arrows/up", "/menu/arrows/down", "/menu/update/editmenu", "/menu/update/template", "/menu/update/editlink", "/menu/update/doeditlink", "/menu/update/doedit", "/menu/update/delete", "/menu/update/add",));
        $event->addRule("menu_see", __("backend/menu.rule_see"), array("/menu/update/index", "/menu/update/"));
    }

}
