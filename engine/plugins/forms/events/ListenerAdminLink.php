<?php

namespace forms\events;

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
        $forms = \db\JsonQuery::all("forms");
        if (count($forms) > 0) {
            foreach ($forms as $form) {
                $subs[] = array(
                    'href' => 'forms/manage/' . $form->id,
                    'title' => $form->title,
                    'nav' => 'form' . $form->id,
                    'name_rule' => array("forms_" . $form->id, "forms_see"),
                    'onlyroot' => false,
                    'icon' => 'fa-pencil',
                );
            }
        }

        $subs[] = array(
            'href' => 'forms/index',
            'title' => __("backend/admin_links.allforms"),
            'nav' => 'allforms',
            'name_rule' => "forms_see",
            'onlyroot' => false,
            'icon' => 'fa-cog',
        );



        $event->add('#', __("backend/admin_links.forms"), 'forms', '', false, 'fa-circle-o', $subs);




























        return true;
    }

}
