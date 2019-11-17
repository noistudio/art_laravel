<?php

$admin_url = \core\ManagerConf::getUrl("backend");

Route::any($admin_url . "/editjs/image/upload", "\\editjs\\controllers\\backend\\ImageEditjs@actionUpload")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/editjs/image/upload');
Route::any($admin_url . "/editjs/link/fetch", "\\editjs\\controllers\\backend\\LinkEditjs@actionFetch")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/editjs/link/fetch");
Route::any($admin_url . "/editjs/blocks.js", "\\editjs\\controllers\\backend\\BlocksEditjs@js")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/editjs/blocks.js");
Route::any($admin_url . "/editjs/config.js", "\\editjs\\controllers\\backend\\ConfigEditjs@js")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/editjs/config.js");
