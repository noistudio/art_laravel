<?php

namespace art\providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Shortcode;

class ArtServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {


        if (!defined('LAZER_DATA_PATH')) {

            define('LAZER_DATA_PATH', base_path() . '/' . Env("LAZER_DATA_PATH"));
        }
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router) {
        $lang = \languages\models\LanguageHelp::get();
        \App::setLocale($lang);

        $manager = \core\ManagerConf::current();

        //config('view.paths')

        $this->app['view']->prependNamespace('app', \core\ManagerConf::render_path());

        $this->app['view']->prependNamespace('app_frontend', \core\ManagerConf::render_path("frontend"));
        $this->app['view']->prependNamespace('app_backend', \core\ManagerConf::render_path("backend"));
        \View::share("asset", \core\ManagerConf::getTemplateFolder());

        if ($manager == "backend") {

            \View::share('admin_url', \core\ManagerConf::getUrl() . "/");
        }

        if ($manager == "frontend") {
            \Blade::directive('runwidget', function ($expression) {
                return "<?php echo 'Hello ' . {$expression}; ?>";
            });
        }



//        $viewPath = __DIR__ . '/../resources/views';
//        $this->loadViewsFrom($viewPath, 'elfinder');
//        $this->publishes([
//            $viewPath => base_path('resources/views/vendor/elfinder'),
//                ], 'views');
//
//        if (!defined('ELFINDER_IMG_PARENT_URL')) {
//            define('ELFINDER_IMG_PARENT_URL', $this->app['url']->asset('packages/barryvdh/elfinder'));
//        }
//
//        $config = $this->app['config']->get('elfinder.route', []);
//        $config['namespace'] = 'Barryvdh\Elfinder';
//
//        $router->group($config, function($router) {
//            $router->get('/', ['as' => 'elfinder.index', 'uses' => 'ElfinderController@showIndex']);
//            $router->any('connector', ['as' => 'elfinder.connector', 'uses' => 'ElfinderController@showConnector']);
//            $router->get('popup/{input_id}', ['as' => 'elfinder.popup', 'uses' => 'ElfinderController@showPopup']);
//            $router->get('filepicker/{input_id}', ['as' => 'elfinder.filepicker', 'uses' => 'ElfinderController@showFilePicker']);
//            $router->get('tinymce', ['as' => 'elfinder.tinymce', 'uses' => 'ElfinderController@showTinyMCE']);
//            $router->get('tinymce4', ['as' => 'elfinder.tinymce4', 'uses' => 'ElfinderController@showTinyMCE4']);
//            $router->get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'ElfinderController@showCKeditor4']);
//        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        
    }

}
