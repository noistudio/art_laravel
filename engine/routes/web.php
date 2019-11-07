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

Route::get('/', function () {
    return view('welcome');
});
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
Route::any($admin_url . "/setup", "\\managers\\backend\\controllers\\SetupBackend@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/setup");
Route::any($admin_url . "/setup/save", "\\managers\\backend\\controllers\\SetupBackend@actionSave")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/setup/save");


Route::any($admin_url . "/logout", "\\managers\\backend\\controllers\\DefaultBackend@actionLogout")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/logout");
Route::any($admin_url . "/val/{one?}/{two?}", "\\managers\\backend\\controllers\\DefaultBackend@actionVal")->middleware(env("BACKEND_MIDDLEWARE"));

Route::any($admin_url . "/login", "\\managers\\backend\\controllers\\LoginBackend@actionIndex")->name("backend/login/index");
Route::any($admin_url . "/doit", "\\managers\\backend\\controllers\\LoginBackend@actionDoit")->name("backend/login/doit");
Route::any($admin_url . "/about", "\\managers\\backend\\controllers\\AboutBackend@actionIndex")->name("about");

Route::any($admin_url . "/superblock", function() {
    $request = Request::create("/adminsystem/blocks/update/2", 'GET', array());
    return Route::dispatch($request)->getContent();
});

Route::get($admin_url . '/setlanguage/{locale}', function ($locale) {


    languages\models\LanguageHelp::set($locale);
    return back();
    //
})->name("backend/setlanguage");


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
