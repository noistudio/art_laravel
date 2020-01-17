<?php

$admin_url = \core\ManagerConf::getUrl("backend");
Route::any($admin_url . "/params/fields/index/{key}", "\\params\\controllers\\backend\\FieldsParams@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/fields/index');
Route::any($admin_url . "/params/fields/add/{key}", "\\params\\controllers\\backend\\FieldsParams@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/fields/add');
Route::any($admin_url . "/params/fields/delete/{key}/{field_key}", "\\params\\controllers\\backend\\FieldsParams@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/fields/delete');
Route::any($admin_url . "/params/manage/index/{name}", "\\params\\controllers\\backend\\ManageParams@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/manage/index');
Route::any($admin_url . "/params/manage/add/{name}", "\\params\\controllers\\backend\\ManageParams@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/manage/add');
Route::any($admin_url . "/params/manage/form/{name}", "\\params\\controllers\\backend\\ManageParams@actionForm")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/manage/form');
Route::any($admin_url . "/params/manage/doupdate/{name}/{key}", "\\params\\controllers\\backend\\ManageParams@actionDoupdate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/manage/doupdate');
Route::any($admin_url . "/params/manage/update/{name}/{key}", "\\params\\controllers\\backend\\ManageParams@actionUpdate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/manage/update');
Route::any($admin_url . "/params/manage/delete/{name}/{key}", "\\params\\controllers\\backend\\ManageParams@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/manage/delete');

Route::any($admin_url . "/params/manage/{name}", "\\params\\controllers\\backend\\ManageParams@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/manage/');
Route::any($admin_url . "/params/fields/{key}", "\\params\\controllers\\backend\\FieldsParams@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/fields/');
