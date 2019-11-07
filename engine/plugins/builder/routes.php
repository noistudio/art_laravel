<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/builder/blocks/index", "\\builder\\controllers\\backend\\BlocksBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/blocks/index');
Route::any($admin_url . "/builder/blocks", "\\builder\\controllers\\backend\\BlocksBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/blocks');
Route::any($admin_url . "/builder/index", "\\builder\\controllers\\backend\\Builder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/index');
Route::any($admin_url . "/builder", "\\builder\\controllers\\backend\\Builder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder');
Route::any($admin_url . "/builder/delete/{val_0?}", "\\builder\\controllers\\backend\\Builder@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/delete');
Route::any($admin_url . "/builder/forms/index", "\\builder\\controllers\\backend\\FormsBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/forms/index');
Route::any($admin_url . "/builder/forms", "\\builder\\controllers\\backend\\FormsBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/forms');
Route::any($admin_url . "/builder/page/index/{val_0??}", "\\builder\\controllers\\backend\\PageBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/page/index');
Route::any($admin_url . "/builder/page/{val_0?}", "\\builder\\controllers\\backend\\PageBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/page');
Route::any($admin_url . "/builder/preview/index", "\\builder\\controllers\\backend\\PreviewBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/preview/index');
Route::any($admin_url . "/builder/preview", "\\builder\\controllers\\backend\\PreviewBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/preview');
Route::any($admin_url . "/builder/run/index/{val_0??}", "\\builder\\controllers\\backend\\RunBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/run/index');
Route::any($admin_url . "/builder/run/{val_0?}", "\\builder\\controllers\\backend\\RunBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/run');

Route::any($admin_url . "/builder/save/index", "\\builder\\controllers\\backend\\SaveBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/save/index');
Route::any($admin_url . "/builder/save", "\\builder\\controllers\\backend\\SaveBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/save');
Route::any($admin_url . "/builder/save/title/{val_0?}", "\\builder\\controllers\\backend\\SaveBuilder@actionTitle")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/save/title');
Route::any($admin_url . "/builder/save/page/{val_0?}", "\\builder\\controllers\\backend\\SaveBuilder@actionPage")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/save/page');


Route::any($admin_url . "/builder/upload/index", "\\builder\\controllers\\backend\\UploadBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/upload/index');
Route::any($admin_url . "/builder/upload", "\\builder\\controllers\\backend\\UploadBuilder@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/builder/upload');
