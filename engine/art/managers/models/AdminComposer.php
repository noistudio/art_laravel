<?php

namespace managers\models;

use Illuminate\View\View;

class AdminComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) {

        $data = $view->getData();
        var_dump($data);
        exit;
    }

}
