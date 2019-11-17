<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $manager = \core\ManagerConf::get();

        if ($manager == "backend") {
//            View::composer(
//                    '*', 'managers\models\AdminComposer'
//            );
        }
        if ($manager == "frontend") {
//            View::composer('*', function ($view) {
//
//                $view->withShortcodes();
//            });
        }
        //
    }

}
