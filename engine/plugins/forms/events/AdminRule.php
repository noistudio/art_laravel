<?php

namespace forms\events;

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







        $blocks = \db\JsonQuery::all("forms");
        if (count($blocks)) {
            foreach ($blocks as $block) {
                $urls = array();
                $urls [] = "/forms/manage/show/" . $block->id;
                $urls [] = "/forms/manage/delete/" . $block->id;
                $urls [] = "/forms/manage/setup/" . $block->id;
                $urls [] = "/forms/manage/deletefield/" . $block->id;
                $urls [] = "/forms/manage/ops/" . $block->id;
                $urls [] = "/forms/manage/savenotify/" . $block->id;
                $urls [] = "/forms/manage/templateemail/" . $block->id;
                $urls [] = "/forms/manage/template/" . $block->id;
                $urls [] = "/forms/manage/ajaxedit/" . $block->id;
                $urls [] = "/forms/manage/index/" . $block->id;
                $event->addRule('forms_' . $block->id, __("backend/forms.rule_form", array("name" => $block->title)), $urls);
            }
        }
        $event->addRule("forms_create", __("backend/forms.rule_create"), array("/forms/add", "/forms/ajaxadd"));
        $event->addRule("forms_delete", __("backend/forms.rule_delete"), array("/forms/add", "/forms/delete"));
        $urls = array();
        $urls[] = "/forms/manage/show/";
        $urls [] = "/forms/manage/delete/";
        $urls [] = "/forms/manage/setup/";
        $urls [] = "/forms/manage/ops/";
        $urls [] = "/forms/manage/savenotify/";
        $urls [] = "/forms/manage/templateemail/";
        $urls [] = "/forms/manage/template/";
        $urls [] = "/forms/manage/ajaxedit/";
        $urls [] = "/forms/manage/index/";
        $event->addRule('forms_see', __("backend/forms.rule_see"), $urls);
    }

}
