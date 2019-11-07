<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/files/index", "\\files\\controllers\\backend\\Files@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/files/index');
Route::any($admin_url . "/files", "\\files\\controllers\\backend\\Files@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/files');
Route::any($admin_url . "/files/dialog", "\\files\\controllers\\backend\\Files@actionDialog")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/files/dialog');


