<?php

$admin_url = \core\ManagerConf::getUrl("backend");


Route::any($admin_url . "/mailer/test/index", "\\mailer\\controllers\\backend\\TestMailer@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mailer/test/index');
Route::any($admin_url . "/mailer/test", "\\mailer\\controllers\\backend\\TestMailer@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mailer/test');
Route::any($admin_url . "/mailer/test/send", "\\mailer\\controllers\\backend\\TestMailer@actionSend")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mailer/test/send');


Route::any($admin_url . "/mailer/config/index", "\\mailer\\controllers\\backend\\ConfigMailer@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mailer/config/index');
Route::any($admin_url . "/mailer/config", "\\mailer\\controllers\\backend\\ConfigMailer@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mailer/config');
Route::any($admin_url . "/mailer/config/save", "\\mailer\\controllers\\backend\\ConfigMailer@actionSave")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mailer/config/save');
