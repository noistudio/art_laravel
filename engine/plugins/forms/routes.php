<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/forms/index", "\\forms\\controllers\\backend\\Forms@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/index');
Route::any($admin_url . "/forms", "\\forms\\controllers\\backend\\Forms@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms');
Route::any($admin_url . "/forms/delete", "\\forms\\controllers\\backend\\Forms@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/delete');
Route::any($admin_url . "/forms/add", "\\forms\\controllers\\backend\\Forms@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/add');
Route::any($admin_url . "/forms/ajaxadd", "\\forms\\controllers\\backend\\Forms@actionAjaxadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/ajaxadd');
Route::any($admin_url . "/forms/manage/show/{val_0?}/{val_1?}", "\\forms\\controllers\\backend\\ManageForms@actionShow")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/show');
Route::any($admin_url . "/forms/manage/deletefield/{val_0?}/{val_1?}", "\\forms\\controllers\\backend\\ManageForms@actionDeletefield")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/deletefield');
Route::any($admin_url . "/forms/manage/delete/{val_0?}/{val_1?}", "\\forms\\controllers\\backend\\ManageForms@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/delete');
Route::any($admin_url . "/forms/manage/setup/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionSetup")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/setup');
Route::any($admin_url . "/forms/manage/ops/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionOps")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/ops');
Route::any($admin_url . "/forms/manage/savenotify/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionSavenotify")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/savenotify');
Route::any($admin_url . "/forms/manage/templateemail/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionTemplateemail")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/templateemail');
Route::any($admin_url . "/forms/manage/template/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionTemplate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/template');
Route::any($admin_url . "/forms/manage/ajaxedit/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionAjaxedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/ajaxedit');
Route::any($admin_url . "/forms/manage/index/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage/index');
Route::any($admin_url . "/forms/manage/{val_0?}", "\\forms\\controllers\\backend\\ManageForms@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/forms/manage');


Route::post("/sendform/{id}", "\\forms\\controllers\\frontend\Forms@send")->name("frontend/sendform");
