<?php

$admin_url = \core\ManagerConf::getUrl("backend");


Route::any($admin_url . "/adminmenu/editlink/{val_0}/{val_1?}", "\\adminmenu\\controllers\\backend\\Adminmenu@actionEditlink")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/editlink');
Route::any($admin_url . "/adminmenu/index", "\\adminmenu\\controllers\\backend\\Adminmenu@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/index');

Route::any($admin_url . "/adminmenu/edit/{val_0?}/{val_1?}", "\\adminmenu\\controllers\\backend\\Adminmenu@actionEdit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/edit');


Route::any($admin_url . "/adminmenu/savestatus", "\\adminmenu\\controllers\\backend\\Adminmenu@actionSavestatus")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/savestatus');
Route::any($admin_url . "/adminmenu/addlink", "\\adminmenu\\controllers\\backend\\Adminmenu@actionAddlink")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/addlink');
Route::any($admin_url . "/adminmenu/delete/{val_0?}/{val_1?}", "\\adminmenu\\controllers\\backend\\Adminmenu@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/delete');


//arrows

Route::any($admin_url . "/adminmenu/arrows/up/{val_0?}/{val_1?}", "\\adminmenu\\controllers\\backend\\ArrowsAdminmenu@actionUp")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/arrows/up');
Route::any($admin_url . "/adminmenu/arrows/down/{val_0?}/{val_1?}", "\\adminmenu\\controllers\\backend\\ArrowsAdminmenu@actionDown")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/adminmenu/arrows/down');
