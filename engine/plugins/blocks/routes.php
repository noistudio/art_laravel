<?php

$admin_url = \core\ManagerConf::getUrl("backend");


Route::any($admin_url . "/blocks/add/index", "\\blocks\\controllers\\backend\\AddBlocks@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/add/index');
Route::any($admin_url . "/blocks/add", "\\blocks\\controllers\\backend\\AddBlocks@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/add');
Route::any($admin_url . "/blocks/add/ajaxadd", "\\blocks\\controllers\\backend\\AddBlocks@actionAjaxadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/add/ajaxadd');
Route::any($admin_url . "/blocks/index", "\\blocks\\controllers\\backend\\Blocks@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/index');
Route::any($admin_url . "/blocks", "\\blocks\\controllers\\backend\\Blocks@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks');
Route::any($admin_url . "/blocks/loadtype/{val_0?}", "\\blocks\\controllers\\backend\\Blocks@actionLoadtype")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/loadtype');
Route::any($admin_url . "/blocks/enable/{val_0?}", "\\blocks\\controllers\\backend\\Blocks@actionEnable")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/enable');
Route::any($admin_url . "/blocks/disable/{val_0?}", "\\blocks\\controllers\\backend\\Blocks@actionEnable")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/disable');
Route::any($admin_url . "/blocks/ops", "\\blocks\\controllers\\backend\\Blocks@actionOps")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/ops');
Route::any($admin_url . "/blocks/delete/{val_0?}", "\\blocks\\controllers\\backend\\Blocks@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/delete');

Route::any($admin_url . "/blocks/update/index/{val_0?}", "\\blocks\\controllers\\backend\\UpdateBlocks@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/update/index');
Route::any($admin_url . "/blocks/update/{val_0?}", "\\blocks\\controllers\\backend\\UpdateBlocks@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/update');
Route::any($admin_url . "/blocks/update/ajaxedit/{val_0?}", "\\blocks\\controllers\\backend\\UpdateBlocks@actionAjaxedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/blocks/update/ajaxedit');
