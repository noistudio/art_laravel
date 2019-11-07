<?php

$admin_url = \core\ManagerConf::getUrl("backend");



Route::any($admin_url . "/admins/edit", "\\admins\\controllers\\backend\\Admins@actionEdit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/edit');
Route::any($admin_url . "/admins/doedit", "\\admins\\controllers\\backend\\Admins@actionDoedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/doedit');
Route::any($admin_url . "/admins/list/index", "\\admins\\controllers\\backend\\ListAdmins@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/list/index');
Route::any($admin_url . "/admins/list/edit/{val_0?}", "\\admins\\controllers\\backend\\ListAdmins@actionEdit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/list/edit');
Route::any($admin_url . "/admins/list/doedit/{val_0?}", "\\admins\\controllers\\backend\\ListAdmins@actionDoedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/list/doedit');
Route::any($admin_url . "/admins/list/delete/{val_0?}", "\\admins\\controllers\\backend\\ListAdmins@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/list/delete');
Route::any($admin_url . "/admins/list/add/", "\\admins\\controllers\\backend\\ListAdmins@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/list/add');

//rules

Route::any($admin_url . "/admins/rules/index", "\\admins\\controllers\\backend\\RulesAdmins@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/rules/index');
Route::any($admin_url . "/admins/rules/add", "\\admins\\controllers\\backend\\RulesAdmins@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/rules/add');
Route::any($admin_url . "/admins/rules/delete/{val_0?}", "\\admins\\controllers\\backend\\RulesAdmins@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/admins/rules/delete');
