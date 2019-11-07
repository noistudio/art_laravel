<?php

if (php_sapi_name() != 'cli-server') {
    exit;
}

if (php_sapi_name() == 'cli-server') {
    // Replicate the effects of basic "index.php"-hiding mod_rewrite rules
    // Tested working under FatFreeFramework 2.0.6 through 2.0.12.
    $_SERVER['SCRIPT_NAME'] = str_replace(__DIR__, '', __FILE__);
    $_SERVER['SCRIPT_FILENAME'] = __FILE__;
    $_SERVER['QUERY_STRING'] = $_SERVER["REQUEST_URI"];


    $_SERVER['DOCUMENT_ROOT'] = __DIR__;
    // Replicate the FatFree/WordPress/etc. .htaccess "serve existing files" bit
    $url_parts = parse_url($_SERVER["REQUEST_URI"]);
    $_req = rtrim($_SERVER['DOCUMENT_ROOT'] . $url_parts['path'], '/' . DIRECTORY_SEPARATOR);

    if (__FILE__ !== $_req && __DIR__ !== $_req && file_exists($_req)) {




        return false;    // serve the requested resource as-is.
    }
}


/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */
$uri = urldecode(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/index.php';
