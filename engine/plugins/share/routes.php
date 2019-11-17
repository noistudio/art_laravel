<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/share/index", "\\share\\controllers\\backend\\Share@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/share/index');
Route::any($admin_url . "/share/doedit/{id}", "\\share\\controllers\\backend\\Share@actionDoedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/share/doedit');
Route::any($admin_url . "/share/edit/{id}", "\\share\\controllers\\backend\\Share@actionEdit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/share/edit');
Route::any($admin_url . "/share/fastupdate/{id}", "\\share\\controllers\\backend\\Share@actionFastupdate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/share/fastupdate');
Route::any($admin_url . "/share/add", "\\share\\controllers\\backend\\Share@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/share/add');
Route::any($admin_url . "/share/delete{id}", "\\share\\controllers\\backend\\Share@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/share/delete');
Route::any($admin_url . "/share/doadd", "\\share\\controllers\\backend\\Share@actionDoadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/share/doadd');
