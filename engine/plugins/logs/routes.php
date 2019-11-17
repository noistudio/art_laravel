<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/logs/add/index", "\\logs\\controllers\\backend\\AddLogs@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/add/index');
Route::any($admin_url . "/logs/add", "\\logs\\controllers\\backend\\AddLogs@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/add');
Route::any($admin_url . "/logs/add/ajaxadd", "\\logs\\controllers\\backend\\AddLogs@actionAjaxadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/add/ajaxadd');
Route::any($admin_url . "/logs/index", "\\logs\\controllers\\backend\\Logs@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/index');
Route::any($admin_url . "/logs", "\\logs\\controllers\\backend\\Logs@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs');

Route::any($admin_url . "/logs/delete/{val_0?}", "\\logs\\controllers\\backend\\Logs@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/delete');

Route::any($admin_url . "/logs/update/index/{val_0?}", "\\logs\\controllers\\backend\\UpdateLogs@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/update/index');
Route::any($admin_url . "/logs/update/{val_0}", "\\logs\\controllers\\backend\\UpdateLogs@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/update');
Route::any($admin_url . "/logs/update/ajaxedit/{val_0?}", "\\logs\\controllers\\backend\\UpdateLogs@actionAjaxedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/logs/update/ajaxedit');
Route::get($admin_url . "/logs/see", '\\KrishnaKodoth\\LogEditor\\LogEditorController@getLogEditor')->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/logs/see");
