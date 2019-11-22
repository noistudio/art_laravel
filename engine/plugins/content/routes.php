<?php

$admin_url = \core\ManagerConf::getUrl("backend");
Route::any($admin_url . "/content/arrows/up/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ArrowsContent@actionUp")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/arrows/up');
Route::any($admin_url . "/content/arrows/down/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ArrowsContent@actionDown")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/arrows/down');
Route::any($admin_url . "/content/arrows/move/{val_0?}/{val_1?}/{val_2?}", "\\content\\controllers\\backend\\ArrowsContent@actionMove")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/arrows/move');

Route::any($admin_url . "/content/manage/index/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/index');
Route::any($admin_url . "/content/manage/add/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/add');


Route::any($admin_url . "/content/manage/delete/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/delete');
Route::any($admin_url . "/content/manage/doadd/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionDoadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/doadd');
Route::any($admin_url . "/content/manage/doupdate/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionDoupdate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/doupdate');
Route::any($admin_url . "/content/manage/enable/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionEnable")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/enable');
Route::any($admin_url . "/content/manage/update/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionUpdate")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/update');
Route::any($admin_url . "/content/manage/ops/{val_0?}", "\\content\\controllers\\backend\\ManageContent@actionOps")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage/ops');
Route::any($admin_url . "/content/manage/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\ManageContent@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/manage');



Route::any($admin_url . "/content/tables/index", "\\content\\controllers\\backend\\TablesContent@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/index');
Route::any($admin_url . "/content/tables", "\\content\\controllers\\backend\\TablesContent@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables');
Route::any($admin_url . "/content/tables/select", "\\content\\controllers\\backend\\TablesContent@actionSelect")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/select');


Route::any($admin_url . "/content/tables/add", "\\content\\controllers\\backend\\TablesContent@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/add');
Route::any($admin_url . "/content/tables/ajaxadd", "\\content\\controllers\\backend\\TablesContent@actionAjaxadd")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/ajaxadd');
Route::any($admin_url . "/content/tables/ajaxedit/{val_0?}", "\\content\\controllers\\backend\\TablesContent@actionAjaxedit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/ajaxedit');
Route::any($admin_url . "/content/tables/edit/{val_0?}", "\\content\\controllers\\backend\\TablesContent@actionEdit")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/edit');
Route::any($admin_url . "/content/tables/deletefield/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\TablesContent@actionDeletefield")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/deletefield');
Route::any($admin_url . "/content/tables/delete", "\\content\\controllers\\backend\\TablesContent@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/delete');
Route::any($admin_url . "/content/tables/field/{val_0?}/{val_1?}", "\\content\\controllers\\backend\\TablesContent@actionField")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/tables/field');


Route::any($admin_url . "/content/template/list/{val_0?}", "\\content\\controllers\\backend\\TemplateContent@actionList")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/template/list');
Route::any($admin_url . "/content/template/rss/{val_0?}", "\\content\\controllers\\backend\\TemplateContent@actionRss")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/template/rss');
Route::any($admin_url . "/content/template/one/{val_0?}", "\\content\\controllers\\backend\\TemplateContent@actionOne")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/content/template/one');


//frontend

$collections = \db\JsonQuery::all("tables", "title", "ASC");

$islang = \languages\models\LanguageHelp::is("frontend");


if (count($collections) > 0) {
    foreach ($collections as $collection) {

        if (!Route::has("frontend/content/" . $collection->name . "/list")) {
            Route::any("/content/" . $collection->name . "/index", "\\content\\controllers\\frontend\\Content@actionIndex")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/content/" . $collection->name . "/list")->defaults("val_0", $collection->name);
        }

        if (!Route::has("frontend/content/" . $collection->name . "/one")) {
            Route::any("/content/" . $collection->name . "/{id}", "\\content\\controllers\\frontend\\Content@actionOne")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/content/" . $collection->name . "/one")->defaults("table", $collection->name);
        }
        if ($islang) {
            Route::any("{lang}/content/" . $collection->name . "/index", "\\content\\controllers\\frontend\\Content@actionIndex")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/content/" . $collection->name . "/list_lang")->defaults("val_0", $collection->name);
        }



        //Route::any("/mg/rss/{val_0}/{val_1}", "\\mg\\controllers\\frontend\\Mg@actionRss")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/mg/rss");
    }
}