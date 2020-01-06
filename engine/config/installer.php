<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Server Requirements
      |--------------------------------------------------------------------------
      |
      | This is the default Laravel server requirements, you can add as many
      | as your application require, we check if the extension is enabled
      | by looping through the array and run "extension_loaded" on it.
      |
     */
    'core' => [
        'minPhpVersion' => '7.3.0'
    ],
    'requirements' => [
        'openssl',
        'pdo',
        'mbstring',
        'tokenizer',
        'fileinfo',
        'curl'
    ],
    /*
      |--------------------------------------------------------------------------
      | Folders Permissions
      |--------------------------------------------------------------------------
      |
      | This is the default Laravel folders permissions, if your application
      | requires more permissions just add them to the array list bellow.
      |
     */
    'permissions' => [
        'storage/app/' => '775',
        'storage/framework/' => '775',
        'storage/logs/' => '775',
        'bootstrap/cache/' => '775',
        'db_json/' => '775',
        'db_json/_object.config.json' => '775',
        'db_json/_object.data.json' => '775',
        'db_json/blocks.config.json' => '775',
        'db_json/blocks.data.json' => '775',
        'db_json/builders.config.json' => '775',
        'db_json/builders.data.json' => '775',
        'db_json/collections.config.json' => '775',
        'db_json/collections.data.json' => '775',
        'db_json/forms.config.json' => '775',
        'db_json/forms.data.json' => '775',
        'db_json/logs.config.json' => '775',
        'db_json/logs.data.json' => '775',
        'db_json/menus.config.json' => '775',
        'db_json/menus.data.json' => '775',
        'db_json/routes.config.json' => '775',
        'db_json/routes.data.json' => '775',
        'db_json/tables.config.json' => '775',
        'db_json/tables.data.json' => '775',
    ]
];

