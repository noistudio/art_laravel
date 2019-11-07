<?php

//app/plugins



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$option_frontend = array(
    'theme_path' => __DIR__ . "/themefrontend",
    'access' => '',
    'main_css' => 'builder.css',
    'default_paginator_file' => __DIR__ . '/themefrontend/paginator.php',
    'post_validate' => array(
        '[block', "[menu", "{action}"
    )
);
$options['frontend'] = $option_frontend;
$option_backend = array(
    'theme_path' => __DIR__ . "/themebackend",
    'access' => '/adminsystem',
    'admin_login' => 'admin',
    'admin_password' => 'admin',
);

//$option_backend['update_not_changes']=  array(
//        $_SERVER['DOCUMENT_ROOT'] . "/frame/plugins/shop",
//        $_SERVER['DOCUMENT_ROOT'] . "/frame/plugins/user",
//        $_SERVER['DOCUMENT_ROOT'] . "/frame/plugins/vendor",
//        $_SERVER['DOCUMENT_ROOT'] . "/frame/plugins/mg",
//        $_SERVER['DOCUMENT_ROOT'] . "/frame/plugins/setup/",
//        $_SERVER['DOCUMENT_ROOT'] . "/frame/",
//        "{frontend.theme_path}",
//        "{backend.theme_path}",
//        "{backend.theme_path}",
//    );
$options['backend'] = $option_backend;



