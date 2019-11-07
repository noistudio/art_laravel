<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication;

    protected function callBeforeApplicationDestroyedCallbacks() {

        $route = \routes\models\RoutesModel::get("/phpunit");
        if (isset($route) and is_array($route) and isset($route['id'])) {
            \db\JsonQuery::delete((int) $route['id'], "id", "routes");
        }

        if (class_exists("\\mg\\config")) {
            \mg\core\CollectionModel::delete("phpunit");
        }

        if (!\core\ManagerConf::isOnlyMongodb()) {
            \db\SqlQuery::delete("elfinder_files", null);
            \content\models\TableConfig::delete('phpunit_mysql');
        }


        parent::callBeforeApplicationDestroyedCallbacks();
    }

}
