<?php

$admin_url = \core\ManagerConf::getUrl("backend");


Route::any($admin_url . "/cache/index", "\\cache\\controllers\\backend\\Cache@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/cache/index');
Route::any($admin_url . "/cache", "\\cache\\controllers\\backend\\Cache@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/cache');
Route::any($admin_url . "/cache/save", "\\cache\\controllers\\backend\\Cache@actionSave")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/cache/save');
Route::any($admin_url . "/cache/clear", "\\cache\\controllers\\backend\\Cache@actionClear")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/cache/clear');
