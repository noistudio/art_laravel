как установить?

добавьте в composer.json 
"yiisoft/yii2-mongodb": "~2.1.0"
после наберите composer update
в /frame/config/web.php 
добавьте в components следующее
'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/cms_test',
        ],