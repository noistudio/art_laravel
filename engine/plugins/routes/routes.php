<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/routes/add/index", "\\routes\\controllers\\backend\\AddRoutes@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/add/index');
Route::any($admin_url . "/routes/add", "\\routes\\controllers\\backend\\AddRoutes@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/add');
Route::any($admin_url . "/routes/add/doadd", "\\routes\\controllers\\backend\\AddRoutes@actionDoadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/add/doadd');
Route::any($admin_url . "/routes/ajax/show", "\\routes\\controllers\\backend\\AjaxRoutes@actionShow")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/ajax/show');
Route::any($admin_url . "/routes/ajax/save", "\\routes\\controllers\\backend\\AjaxRoutes@actionSave")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/ajax/save');
Route::any($admin_url . "/routes/index", "\\routes\\controllers\\backend\\Routes@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/index');
 
Route::any($admin_url . "/routes", "\\routes\\controllers\\backend\\Routes@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes');
Route::any($admin_url . "/routes/delete/{val_0?}", "\\routes\\controllers\\backend\\Routes@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/delete');
Route::any($admin_url . "/routes/update/index/{val_0?}", "\\routes\\controllers\\backend\\UpdateRoutes@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/update/index');
Route::any($admin_url . "/routes/update/{val_0?}", "\\routes\\controllers\\backend\\UpdateRoutes@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/update');
Route::any($admin_url . "/routes/update/doupdate/{val_0?}", "\\routes\\controllers\\backend\\UpdateRoutes@actionDoupdate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/routes/update/doupdate');


\Debugbar::startMeasure('load_custom_routes', 'Start loading custom routes saved in DB');
$routes = \db\JsonQuery::all("routes");
if (isset($routes) and count($routes) > 0) {
    foreach ($routes as $route) {
        if($route->old_url!=$route->new_url){
        Route::any($route->new_url, function() use ($route) {
            $request = Request::create($route->old_url, 'GET', array());
            return Route::dispatch($request)->getContent();
        });
        }
    }
}

\Debugbar::stopMeasure('load_custom_routes');

//Route::get('/supertestString', '\\routes\\controllers\\backend\\UpdateRoutes@actionIndex')->defaults('val_0', '4');
