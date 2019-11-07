<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/languages/index", "\\languages\\controllers\\backend\\Languages@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/languages/index');
Route::any($admin_url . "/languages", "\\languages\\controllers\\backend\\Languages@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/languages');

