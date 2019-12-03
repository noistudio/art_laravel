<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */



Route::get("/", "\\managers\\frontend\\controllers\\SiteController@actionIndex")->name("frontend/");

Route::get("/citycurrent", "\\managers\\frontend\\controllers\\SiteController@actionCityCurrent")->name("frontend/citycurrent");

Route::get("/savecity/{last_id}", "\\managers\\frontend\\controllers\\SiteController@actionSaveCity")->name("frontend/savecity");



$dynamic_route = new core\DynamicRoute();
$routes = $dynamic_route->getRules();

$manager = core\ManagerConf::current();
//
//var_dump($routes);
//exit;
$run_on_end = array();

if (isset($routes) and is_array($routes) and count($routes) > 0) {
    foreach ($routes as $route) {
        if (!(isset($route['on_end']))) {
            $name = $manager . $route['inner'];

            $first_char = $route['inner_link'][0];
            if ($first_char == "/") {
                $route['inner_link'] = ltrim($route['inner_link'], $route['inner_link'][0]);
            }
            //$route['inner_link'] = str_replace("//", "/", $route['inner_link']);

            if ($manager == "backend") {
                Route::any($route['inner_link'], $route['class'])->middleware(env("BACKEND_MIDDLEWARE"))->name($name);
            } else {
                Route::any($route['inner_link'], $route['class'])->name($name);
            }
        } else {
            $run_on_end[] = $route;
        }
    }
}


$admin_url = core\ManagerConf::getUrl("backend");
$first_char = $admin_url[0];
if ($first_char == "/") {
    $admin_url = ltrim($admin_url, $admin_url [0]);
}


Route::any($admin_url . "/", "\\managers\\backend\\controllers\\DefaultBackend@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/");
Route::any($admin_url, "\\managers\\backend\\controllers\\DefaultBackend@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend");

Route::any($admin_url . "/index", "\\managers\\backend\\controllers\\DefaultBackend@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/index");


Route::any($admin_url . "/backup", "\\managers\\backend\\controllers\\BackupBackend@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/backup");
Route::any($admin_url . "/createbackup", "\\managers\\backend\\controllers\\BackupBackend@actionCreate")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/backup/create");
Route::any($admin_url . "/createonlydb", "\\managers\\backend\\controllers\\BackupBackend@actionCreateonlyDB")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/backup/createonlydb");


Route::any($admin_url . "/backup/delete/{filename}", "\\managers\\backend\\controllers\\BackupBackend@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/backup/delete");

Route::any($admin_url . "/download/{filename}", "\\managers\\backend\\controllers\\BackupBackend@actionDownload")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/backup/download");

Route::any($admin_url . "/setup", "\\managers\\backend\\controllers\\SetupBackend@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/setup");
Route::any($admin_url . "/setup/save", "\\managers\\backend\\controllers\\SetupBackend@actionSave")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/setup/save");


Route::any($admin_url . "/logout", "\\managers\\backend\\controllers\\DefaultBackend@actionLogout")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/logout");
Route::any($admin_url . "/val/{one?}/{two?}", "\\managers\\backend\\controllers\\DefaultBackend@actionVal")->middleware(env("BACKEND_MIDDLEWARE"));

Route::any($admin_url . "/login", "\\managers\\backend\\controllers\\LoginBackend@actionIndex")->name("backend/login/index");
Route::any($admin_url . "/doit", "\\managers\\backend\\controllers\\LoginBackend@actionDoit")->name("backend/login/doit");
Route::any($admin_url . "/about", "\\managers\\backend\\controllers\\AboutBackend@actionIndex")->name("about");

Route::get($admin_url . '/manifest.json', '\\managers\\backend\\controllers\\DefaultBackend@manifestJson')
        ->name('laravelpwa.manifest');

Route::any($admin_url . "/superblock", function() {
    $request = Request::create("/adminsystem/blocks/update/2", 'GET', array());
    return Route::dispatch($request)->getContent();
});

Route::get($admin_url . '/setlanguage/{locale}', function ($locale) {
    \cache\models\Model::removeAll();

    languages\models\LanguageHelp::set($locale);
    return back();
    //
})->name("backend/setlanguage");


Route::get('/setlang/{locale}', function ($locale) {


    languages\models\LanguageHelp::set($locale);
    return back();
    //
})->name("frontend/setlanguage");






if (isset($run_on_end) and is_array($run_on_end) and count($run_on_end) > 0) {
    foreach ($routes as $route) {
        if ((isset($route['on_end']))) {
            $name = $manager . $route['inner'];
            $first_char = $route['inner_link'][0];
            if ($first_char == "/") {
                $route['inner_link'] = ltrim($route['inner_link'], $route['inner_link'][0]);
            }
            //$route['inner_link'] = str_replace("//", "/", $route['inner_link']);

            if ($manager == "backend") {
                Route::any($route['inner_link'], $route['class'])->middleware(env("BACKEND_MIDDLEWARE"))->name($name);
            } else {
                Route::any($route['inner_link'], $route['class'])->name($name);
            }
        }
    }
}


//Route::get('sitemap', function() {
//
//    // create new sitemap object
//    $sitemap = App::make('sitemap');
//
//    // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
//    // by default cache is disabled
//    $sitemap->setCache('laravel.sitemap', 60);
//
//    // check if there is cached sitemap and build new only if is not
//    if (!$sitemap->isCached()) {
//        $sitemap->add(route('frontend/targets'));
//        $sitemap->add(route("frontend/about"));
//        $sitemap->add(route("frontend/projects"));
//        $sitemap->add(route('frontend/services'));
//        $sitemap->add(route('frontend/hobby'));
//
//        $pages = mg\MongoQuery::all("pages", array('enable' => 1), array('last_id' => 1));
//        if (count($pages)) {
//            foreach ($pages as $page) {
//                $sitemap->add(route("frontend/mg/pages/one", $page['last_id']));
//            }
//        }
//
//
//        $types = mg\MongoQuery::all("types", array('enable' => 1), array('last_id' => 1));
//        if (count($types)) {
//            foreach ($types as $type) {
//                $sitemap->add(route("frontend/projects/type", $type['last_id']));
//            }
//        }
//
//        $categorys = mg\MongoQuery::all("categorys", array('enable' => 1), array('last_id' => 1));
//        if (count($categorys)) {
//            foreach ($categorys as $cat) {
//                $sitemap->add(route("frontend/blog/cat", $cat['last_id']));
//            }
//        }
//
//
//        $services = mg\MongoQuery::all("services", array('enable' => 1), array('last_id' => 1));
//        if (count($services)) {
//            foreach ($services as $service) {
//                $sitemap->add(route("frontend/services/one", $service['last_id']));
//            }
//        }
//
//        $projects = mg\MongoQuery::all("projects", array('enable' => 1), array('last_id' => 1));
//        if (count($projects)) {
//            foreach ($projects as $project) {
//                $sitemap->add(route("frontend/projects/one", $project['last_id']));
//            }
//        }
//
//
//        // add item to the sitemap (url, date, priority, freq)
//        $posts = mg\MongoQuery::all("posts", array("enable" => 1, 'date' => array('$exists' => true)), array('date' => 1));
//        if (count($posts)) {
//            foreach ($posts as $post) {
//
//                $sitemap->add(route('frontend/mg/pages/one', $post['last_id']), date("Y-m-d\Th:m:s+00:00", \mg\MongoHelper::time($post['date'])), '1.0', 'daily');
//            }
//        }
//    }
//
//    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
//    return $sitemap->render('xml');
//});


