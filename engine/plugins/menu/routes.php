<?php

$admin_url = \core\ManagerConf::getUrl("backend");


Route::any($admin_url . "/menu/arrows/up/{val_0?}/{val_1?}", "\\menu\\controllers\\backend\\ArrowsMenu@actionUp")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/arrows/up');
Route::any($admin_url . "/menu/arrows/down/{val_0?}/{val_1?}", "\\menu\\controllers\\backend\\ArrowsMenu@actionDown")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/arrows/down');


Route::any($admin_url . "/menu/index", "\\menu\\controllers\\backend\\Menu@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/index');
Route::any($admin_url . "/menu", "\\menu\\controllers\\backend\\Menu@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu');
Route::any($admin_url . "/menu/add", "\\menu\\controllers\\backend\\Menu@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/add');
Route::any($admin_url . "/menu/doadd", "\\menu\\controllers\\backend\\Menu@actionDoadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/doadd');
Route::any($admin_url . "/menu/delete/{val_0?}", "\\menu\\controllers\\backend\\Menu@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/delete');


Route::any($admin_url . "/menu/update/index/{val_0?}", "\\menu\\controllers\\backend\\UpdateMenu@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update/index');
Route::any($admin_url . "/menu/update/{val_0?}", "\\menu\\controllers\\backend\\UpdateMenu@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update');
Route::any($admin_url . "/menu/update/template/{val_0?}", "\\menu\\controllers\\backend\\UpdateMenu@actionTemplate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update/template');
Route::any($admin_url . "/menu/update/doedit/{val_0?}", "\\menu\\controllers\\backend\\UpdateMenu@actionDoedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update/doedit');
Route::any($admin_url . "/menu/update/add/{val_0?}", "\\menu\\controllers\\backend\\UpdateMenu@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update/add');
Route::any($admin_url . "/menu/update/editlink/{val_0?}/{val_1?}", "\\menu\\controllers\\backend\\UpdateMenu@actionEditlink")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update/editlink');
Route::any($admin_url . "/menu/update/delete/{val_0?}/{val_1?}", "\\menu\\controllers\\backend\\UpdateMenu@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update/delete');
Route::any($admin_url . "/menu/update/doeditlink/{val_0?}/{val_1?}", "\\menu\\controllers\\backend\\UpdateMenu@actionDoeditlink")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/menu/update/doeditlink');
