<?php

namespace art\providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {

        $plugins_dir = \core\ManagerConf::plugins_path();



        $folders = scandir($plugins_dir);
        foreach ($folders as $folder) {
            if ($folder != "." and $folder != "..") {

                if (file_exists($plugins_dir . "" . $folder . "/routes.php")) {

                    Route::middleware('web')
                            ->namespace($this->namespace)
                            ->group($plugins_dir . "" . $folder . "/routes.php");
                }
            }
        }
        //  $this->mapApiRoutes();
        //  $this->mapWebRoutes();
        //
    }

}
