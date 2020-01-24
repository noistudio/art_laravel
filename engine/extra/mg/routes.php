<?php

$admin_url = \core\ManagerConf::getUrl("backend");
Route::any($admin_url . "/mg/arrows/up/{val_0?}/{val_1?}", "\\mg\\controllers\\backend\\ArrowsMg@actionUp")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mg/arrows/up');
Route::any($admin_url . "/mg/arrows/down/{val_0?}/{val_1?}", "\\mg\\controllers\\backend\\ArrowsMg@actionDown")->middleware(env("BACKEND_MIDDLEWARE"))->name('backend/mg/arrows/down');
Route::any($admin_url . "/mg/collections/select", "\\mg\\controllers\\backend\\CollectionsMg@actionSelect")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/select");

Route::any($admin_url . "/mg/collections/index", "\\mg\\controllers\\backend\\CollectionsMg@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/index");
Route::any($admin_url . "/mg/collections", "\\mg\\controllers\\backend\\CollectionsMg@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections");
Route::any($admin_url . "/mg/collections/add", "\\mg\\controllers\\backend\\CollectionsMg@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/add");
Route::any($admin_url . "/mg/collections/ajaxadd", "\\mg\\controllers\\backend\\CollectionsMg@actionAjaxadd")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/ajaxadd");
Route::any($admin_url . "/mg/collections/ajaxedit/{val_0?}", "\\mg\\controllers\\backend\\CollectionsMg@actionAjaxedit")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/ajaxedit");
Route::any($admin_url . "/mg/collections/edit/{val_0?}", "\\mg\\controllers\\backend\\CollectionsMg@actionEdit")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/edit");
Route::any($admin_url . "/mg/collections/deletefield/{val_0?}/{val_1?}", "\\mg\\controllers\\backend\\CollectionsMg@actionDeletefield")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/deletefield");
Route::any($admin_url . "/mg/collections/delete/{val_0?}", "\\mg\\controllers\\backend\\CollectionsMg@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/delete");
Route::any($admin_url . "/mg/collections/field/{val_0?}/{val_1?}", "\\mg\\controllers\\backend\\CollectionsMg@actionField")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/collections/field");



Route::any($admin_url . "/mg/manage/index/{val_0?}/{val_1?}/{val_2?}", "\\mg\\controllers\\backend\\ManageMg@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/index");
Route::any($admin_url . "/mg/manage/doupdate/{val_0?}/{val_1?}/{val_2?}", "\\mg\\controllers\\backend\\ManageMg@actionDoupdate")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/doupdate");
Route::any($admin_url . "/mg/manage/doadd/{val_0?}", "\\mg\\controllers\\backend\\ManageMg@actionDoadd")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/doadd");
Route::any($admin_url . "/mg/manage/add/{val_0?}", "\\mg\\controllers\\backend\\ManageMg@actionAdd")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/add");
Route::any($admin_url . "/mg/manage/enable/{val_0?}/{val_1?}", "\\mg\\controllers\\backend\\ManageMg@actionEnable")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/enable");
Route::any($admin_url . "/mg/manage/clone/{val_0?}/{val_1?}", "\\mg\\controllers\\backend\\ManageMg@actionClone")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/clone");
Route::any($admin_url . "/mg/manage/ops/{val_0?}", "\\mg\\controllers\\backend\\ManageMg@actionOps")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/ops");
Route::any($admin_url . "/mg/manage/update/{val_0?}/{val_1?}/{val_2?}", "\\mg\\controllers\\backend\\ManageMg@actionUpdate")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/update");
Route::any($admin_url . "/mg/manage/delete/{val_0?}/{val_1?}", "\\mg\\controllers\\backend\\ManageMg@actionDelete")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage/delete");

Route::any($admin_url . "/mg/manage/{val_0?}/{val_1?}/{val_2?}", "\\mg\\controllers\\backend\\ManageMg@actionIndex")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/manage");


Route::any($admin_url . "/mg/template/list/{val_0?}", "\\mg\\controllers\\backend\\TemplateMg@actionList")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/template/list");
Route::any($admin_url . "/mg/template/one/{val_0?}", "\\mg\\controllers\\backend\\TemplateMg@actionOne")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/template/one");
Route::any($admin_url . "/mg/template/rss/{val_0?}", "\\mg\\controllers\\backend\\TemplateMg@actionRss")->middleware(env("BACKEND_MIDDLEWARE"))->name("backend/mg/template/rss");


//frontend
//frontend

$collections = \db\JsonQuery::all("collections", "title", "ASC");

$islang = \languages\models\LanguageHelp::is("frontend");


if (count($collections) > 0) {
    foreach ($collections as $collection) {

        if (!Route::has("frontend/mg/" . $collection->name . "/list")) {
            Route::any("/mg/" . $collection->name . "/index", "\\mg\\controllers\\frontend\\Mg@actionIndex")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/mg/" . $collection->name . "/list")->defaults("val_0", $collection->name);
        }

        if (!Route::has("frontend/mg/" . $collection->name . "/one")) {
            Route::any("/mg/" . $collection->name . "/{id}", "\\mg\\controllers\\frontend\\Mg@actionOne")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/mg/" . $collection->name . "/one")->defaults("table", $collection->name);
        }
        if ($islang) {
            Route::any("{lang}/mg/" . $collection->name . "/index", "\\mg\\controllers\\frontend\\Mg@actionIndex")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/mg/" . $collection->name . "/list_lang")->defaults("val_0", $collection->name);
        }



        //Route::any("/mg/rss/{val_0}/{val_1}", "\\mg\\controllers\\frontend\\Mg@actionRss")->middleware(env("FRONTEND_MIDDLEWARE"))->name("frontend/mg/rss");
    }
}

//Route::any("/mg/index/{val_0?}/{val_1?}", "\\mg\\controllers\\frontend\\Mg@actionIndex")->name("frontend/mg/index");
//Route::any("/mg/{val_0?}/{val_1?}", "\\mg\\controllers\\frontend\\Mg@actionIndex")->name("frontend/mg");
//Route::any("/mg/rss/{val_0?}/{val_1?}", "\\mg\\controllers\\frontend\\Mg@actionRss")->name("frontend/mg/rss");

