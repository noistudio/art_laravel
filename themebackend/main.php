
<!DOCTYPE html>

<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo __('backend/main.title'); ?></title>
        <?php echo $pwa_meta; ?>

        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-param" content="_token">
        <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="/themebackend/img/favicon.png">
        <link rel="apple-touch-icon" href="/themebackend/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="/themebackend/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="/themebackend/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="/themebackend/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="/themebackend/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="/themebackend/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="/themebackend/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="/themebackend/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="/themebackend/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="/themebackend/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="/themebackend/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="/themebackend/css/themes.css">
        <link rel="stylesheet" href="/themebackend/css/themes/<?php echo Env('APP_BACKEND_CSS'); ?>">

        <!--        <link rel="stylesheet" href="/themebackend/css/themes/classy.css">-->
        <!-- END Stylesheets -->
        <link rel="stylesheet" type="text/css" href="/themebackend/js/packages/barryvdh/elfinder/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" href="/themebackend/filemanager/css/theme.css">
        <!--        <link rel="stylesheet" type="text/css" href="/themebackend/js/packages/barryvdh/elfinder/css/theme.css">-->
        <!--        <link rel="stylesheet" type="text/css" href="/themebackend/css/elfinder_theme.css">--->

        <link rel="stylesheet" href="/themebackend/js/newgui/dist/ui/trumbowyg.min.css"> 
        <link rel="stylesheet" href="/themebackend//js/plugins/summernote.css">
        <link rel="stylesheet" href="/themebackend/js/bootstrap_select/css/bootstrap-select.css">
        <link rel="stylesheet" href="/themebackend/css/custom.css">

        <!-- Mac OS X Finder style for jQuery UI smoothness theme (OPTIONAL) -->
        <!-- Modernizr (browser feature detection library) -->
        <script src="/themebackend/js/vendor/modernizr-3.3.1.min.js"></script>
        <script>
            var editorjs_configs = [];
        </script>
    </head>
    <?php
    $query_string = \admins\models\AdminModel::getQueryString();
    ?>
    <body id="pathadmin" data-link-fetchurl="<?php echo route('backend/editjs/link/fetch'); ?>"   data-file-upload="<?php echo route('backend/editjs/image/upload'); ?>" data-path="{pathadmin}" data-elfinder-connector="<?= route("elfinder.connector") ?>">
        <!-- Page Wrapper -->
        <!-- In the PHP version you can set the following options from inc/config file -->
        <!--
            Available classes:

            'page-loading'      enables page preloader
        -->
        <div id="page-wrapper" class="page-loading">
            <!-- Preloader -->
            <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
            <!-- Used only if page preloader enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
            <div class="preloader">
                <div class="inner">
                    <!-- Animation spinner for all modern browsers -->
                    <div class="preloader-spinner themed-background hidden-lt-ie10"></div>

                    <!-- Text for IE9 -->
                    <h3 class="text-primary visible-lt-ie10"><strong>Loading..</strong></h3>
                </div>
            </div>
            <!-- END Preloader -->

            <!-- Page Container -->
            <!-- In the PHP version you can set the following options from inc/config file -->
            <!--
                Available #page-container classes:

                'sidebar-light'                                 for a light main sidebar (You can add it along with any other class)

                'sidebar-visible-lg-mini'                       main sidebar condensed - Mini Navigation (> 991px)
                'sidebar-visible-lg-full'                       main sidebar full - Full Navigation (> 991px)

                'sidebar-alt-visible-lg'                        alternative sidebar visible by default (> 991px) (You can add it along with any other class)

                'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
                'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar

                'fixed-width'                                   for a fixed width layout (can only be used with a static header/main sidebar layout)

                'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links (You can add it along with any other class)
            -->
            <div id="page-container" class="header-fixed-top sidebar-visible-lg-full enable-cookies">
                <!-- Alternative Sidebar -->
                <div id="sidebar-alt" tabindex="-1" aria-hidden="true">
                    <!-- Toggle Alternative Sidebar Button (visible only in static layout) -->
                    <a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>

                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll-alt">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">
                            <!-- Sidebar Section -->
                            <div class="sidebar-section">
                                <h2 class="text-light">Header</h2>
                                <p>Section content..</p>
                            </div>
                            <!-- END Sidebar Section -->
                        </div>
                        <!-- END Sidebar Content -->
                    </div>
                    <!-- END Wrapper for scrolling functionality -->
                </div>
                <!-- END Alternative Sidebar -->

                <!-- Main Sidebar -->
                <div id="sidebar">
                    <!-- Sidebar Brand -->
                    <div id="sidebar-brand" class="themed-background">
                        <a href="<?php echo Env('APP_BACKEND_COPYRIGHT_LINK'); ?>" target="_blank" class="sidebar-title">
                            <?php echo Env('APP_BACKEND_COPYRIGHT_TITLE'); ?><span class="sidebar-nav-mini-hide"></span>
                        </a>
                    </div>
                    <!-- END Sidebar Brand -->

                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">

                            <!-- Sidebar Navigation -->

                            <ul class="sidebar-nav">
                                <?php
                                $nav = (string) core\AppConfig::get("nav");
                                $subnav = (string) core\AppConfig::get("subnav");
                                ?>

                                <li class="<?php
                                if ($query_string == "index") {
                                    echo 'active';
                                }
                                ?>">
                                    <a href="<?php echo route('backend/index'); ?>"  ><i class="gi gi-compass sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?php echo __("backend/main.home"); ?></span></a>
                                </li>












                                <?php
                                $links_global = $mainmenu;

                                if (is_array($links_global) and count($links_global)) {
                                    foreach ($links_global as $link) {

                                        $haveaccess = false;
                                        if (!(isset($link['onlyroot']) and is_bool($link['onlyroot']))) {
                                            $link['onlyroot'] = false;
                                        }
                                        if ($link['onlyroot'] == true and \admins\models\AdminAuth::isRoot()) {
                                            $haveaccess = true;
                                        } else {
                                            if (isset($link['name_rule'])) {
                                                if (!is_array($link['name_rule'])) {
                                                    if (\admins\models\AdminAuth::have($link['name_rule'])) {
                                                        $haveaccess = true;
                                                    } else if (\admins\models\AdminAuth::isRoot()) {
                                                        $haveaccess = true;
                                                    }
                                                } else {
                                                    foreach ($link['name_rule'] as $rule) {
                                                        if (\admins\models\AdminAuth::have($rule)) {
                                                            $haveaccess = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $haveaccess = true;
                                            }
                                        }



                                        if (!(isset($link['sub']) and is_array($link['sub']))) {
                                            $link['sub'] = array();
                                        }
                                        if ($haveaccess) {
                                            if (count($link['sub']) == 0) {
                                                $main_class = "";
                                                if (isset($link['nav']) and strlen($link['nav']) > 1 and $nav == $link['nav']) {
                                                    $main_class = 'active';
                                                }
                                                if (isset($query_string) and strlen($query_string) > 1 and $link['href'] == $query_string) {
                                                    $main_class = "active";
                                                }
                                                ?>
                                                <li class="<?php
                                                echo $main_class;
                                                ?>">
                                                    <a href="<?php echo route('backend', array(), false) . "/" . $link['href']; ?>"  ><i class="fa <?php echo $link['icon']; ?> sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?php echo $link['title']; ?></span></a>
                                                </li>
                                                <?php
                                            } else {
                                                $main_class = "";

                                                if (isset($link['nav']) and strlen($link['nav']) > 1 and $nav == $link['nav']) {
                                                    $main_class = "active";
                                                }

                                                if (isset($query_string) and strlen($query_string) > 1 and $link['href'] == $query_string) {
                                                    $main_class = "active";
                                                }

                                                $sub_html = "";

                                                foreach ($link['sub'] as $sub_link) {
                                                    $haveaccess = false;
                                                    if (!(isset($sub_link['onlyroot']) and is_bool($sub_link['onlyroot']))) {
                                                        $sub_link['onlyroot'] = false;
                                                    }
                                                    if ($sub_link['onlyroot'] == true and \admins\models\AdminAuth::isRoot()) {
                                                        $haveaccess = true;
                                                    } else {
                                                        if (isset($sub_link['name_rule'])) {
                                                            if (!is_array($sub_link['name_rule'])) {
                                                                if (\admins\models\AdminAuth::have($sub_link['name_rule'])) {
                                                                    $haveaccess = true;
                                                                }
                                                            } else {
                                                                foreach ($sub_link['name_rule'] as $rule) {
                                                                    if (\admins\models\AdminAuth::have($rule)) {
                                                                        $haveaccess = true;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            $haveaccess = true;
                                                        }
                                                    }
                                                    if ($haveaccess) {
                                                        $subclass = "";
                                                        if (isset($sub_link['nav']) and strlen($sub_link['nav']) > 1 and $subnav == $sub_link['nav']) {
                                                            $subclass = "active";
                                                            $main_class = "active";
                                                        }

                                                        if (isset($query_string) and strlen($query_string) > 1 and $sub_link['href'] == $query_string) {
                                                            $subclass = "active";
                                                            $main_class = "active";
                                                        }
                                                        $sub_link_tmp = route('backend', array(), false) . "/" . $sub_link['href'];

                                                        $sub_html .= '<li  >

                                                                    <a class="' . $subclass . '" href="' . $sub_link_tmp . '"  ><i class="fa ' . $sub_link['icon'] . ' sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">' . $sub_link['title'] . '</span></a>
                                                                </li>'
                                                        ?>


                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <li class="<?php echo $main_class; ?>">
                                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa <?php echo $link['icon']; ?> sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?php echo $link['title']; ?></span></a>
                                                    <ul>



                                                        <?php echo $sub_html; ?>



                                                    </ul>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>









                                <li  >
                                    <a href="<?php echo route('backend/logout', array(), false); ?>"  ><i class="fa fa fa-sign-out sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide"><?php echo __("backend/main.logout"); ?></span></a>
                                </li>

                            </ul>
                            <!-- END Sidebar Navigation -->

                            <!-- Color Themes -->
                            <!-- Preview a theme on a page functionality can be found in js/app.js - colorThemePreview() -->

                            <!-- END Color Themes -->
                        </div>
                        <!-- END Sidebar Content -->
                    </div>
                    <!-- END Wrapper for scrolling functionality -->

                    <!-- Sidebar Extra Info -->

                    <!-- END Sidebar Extra Info -->
                </div>
                <!-- END Main Sidebar -->

                <!-- Main Container -->
                <div id="main-container">

                    <!-- Header -->
                    <!-- In the PHP version you can set the following options from inc/config file -->
                    <!--
                        Available header.navbar classes:

                        'navbar-default'            for the default light header
                        'navbar-inverse'            for an alternative dark header

                        'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                            'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                        'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                            'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
                    -->
                    <header class="navbar navbar-fixed-top ">
                        <!-- Left Header Navigation -->

                        <ul class="nav navbar-nav-custom ">
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar'); this.blur();">
                                    <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                    <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                </a>
                            </li> 

                            <ul class="nav navbar-nav-custom  hidden-sm hidden-lg hidden-md hidden-print ">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i> <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        if (\admins\models\AdminAuth::isRoot()) {
                                            ?>

                                            <li class="btn btn-rounded <?php
                                            if (\Route::current()->getName() == "backend/adminmenu/index") {
                                                echo 'active_top';
                                            }
                                            ?>">
                                                <a href="<?php echo route("backend/adminmenu/index") ?>" >
                                                    <i class="fa fas fa-cog"></i> <?php echo __("backend/main.adminmenu"); ?>
                                                </a>
                                            </li>
                                            <li class="btn btn-rounded <?php
                                            if (\Route::current()->getName() == "backend/backup") {
                                                echo 'active_top';
                                            }
                                            ?>">
                                                <a  href="<?php echo route("backend/backup") ?>" >
                                                    <i class="fa fas fa-cog"></i> <?php echo __("backend/main.backups_link"); ?>
                                                </a>
                                            </li>

                                            <?php
                                        }


                                        if (\admins\models\AdminAuth::isRoot()) {
                                            ?>
                                            <li class="btn btn-rounded <?php
                                            if (\Route::current()->getName() == "backend/setup") {
                                                echo 'active_top';
                                            }
                                            ?>">
                                                <a href="<?php echo route("backend/setup"); ?>" >
                                                    <i class="fa fas fa-cog"></i> <?php echo __("backend/main.colors"); ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?> 
                                        <?php
                                        if (\admins\models\AdminAuth::isRoot()) {
                                            ?>
                                            <li class="btn btn-rounded <?php
                                            if (\Route::current()->getName() == "backend/admins/rules/index") {
                                                echo 'active_top';
                                            }
                                            ?>">
                                                <a href="<?php echo route("backend/admins/rules/index") ?>" >
                                                    <i class="fa fa-check"></i> <?php echo __("backend/main.access_rules"); ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>      


                                        <?php
                                        if (!\admins\models\AdminAuth::isRoot()) {
                                            ?> 
                                            <li class="btn btn-rounded <?php
                                            if (\Route::current()->getName() == "backend/admins/edit") {
                                                echo 'active_top';
                                            }
                                            ?>">
                                                <a href="<?php echo route("backend/admins/edit") ?>" >
                                                    <?php echo __("backend/main.change_password"); ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>

                                        <li class="btn btn-rounded">
                                            <a href="<?php echo route("backend/logout") ?>" >
                                                <i class=" fa fa-sign-out"></i> <?php echo __("backend/main.exit"); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li> 

                            </ul>

                            <?php
                            if (isset($languages) and is_array($languages) and count($languages)) {
                                ?>

                                <?php
                                foreach ($languages as $lang) {
                                    ?>
                                    <li>
                                        <a   href="<?php echo route("backend/setlanguage", array('locale' => $lang)); ?>" >
                                            <img src="/themebackend/img/lang_<?php echo $lang; ?>.png" class="img img-thumbnail">
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>



                                <?php
                            }
                            ?>
                            <li> 
                                <a  class="btn btn-rounded"  href="<?php echo route("about") ?>" >
                                    <?php echo __("backend/main.about"); ?>
                                </a>
                            </li> 
                        </ul>   



                        <ul class="nav navbar-nav-custom pull-right hidden-xs">
                            <!-- Main Sidebar Toggle Button -->




                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>

                                <li class=" <?php
                                if (\Route::current()->getName() == "backend/adminmenu/index") {
                                    echo 'active_top';
                                }
                                ?>">
                                    <a class="btn btn-rounded" href="<?php echo route("backend/adminmenu/index") ?>" >
                                        <i class="fa fas fa-cog"></i> <?php echo __("backend/main.adminmenu"); ?>
                                    </a>
                                </li>
                                <li class=" <?php
                                if (\Route::current()->getName() == "backend/backup") {
                                    echo 'active_top';
                                }
                                ?>">
                                    <a class="btn btn-rounded" href="<?php echo route("backend/backup") ?>" >
                                        <i class="fa fas fa-cog"></i> <?php echo __("backend/main.backups_link"); ?>
                                    </a>
                                </li>

                                <?php
                            }


                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <li class=" <?php
                                if (\Route::current()->getName() == "backend/setup") {
                                    echo 'active_top';
                                }
                                ?>">
                                    <a class="btn btn-rounded" href="<?php echo route("backend/setup"); ?>" >
                                        <i class="fa fas fa-cog"></i> <?php echo __("backend/main.colors"); ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?> 
                            <?php
                            if (\admins\models\AdminAuth::isRoot()) {
                                ?>
                                <li class=" <?php
                                if (\Route::current()->getName() == "backend/admins/rules/index") {
                                    echo 'active_top';
                                }
                                ?>">
                                    <a class="btn btn-rounded" href="<?php echo route("backend/admins/rules/index") ?>" >
                                        <i class="fa fa-check"></i> <?php echo __("backend/main.access_rules"); ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>      


                            <?php
                            if (!\admins\models\AdminAuth::isRoot()) {
                                ?> 
                                <li class=" <?php
                                if (\Route::current()->getName() == "backend/admins/edit") {
                                    echo 'active_top';
                                }
                                ?>">
                                    <a class="btn btn-rounded" href="<?php echo route("backend/admins/edit") ?>" >
                                        <?php echo __("backend/main.change_password"); ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>

                            <li class="">
                                <a class="btn btn-rounded" href="<?php echo route("backend/logout") ?>" >
                                    <i class=" fa fa-sign-out"></i> <?php echo __("backend/main.exit"); ?>
                                </a>
                            </li>



                            <!-- END Main Sidebar Toggle Button -->

                            <!-- Header Link -->

                            <!-- END Header Link -->
                        </ul>

                        <!-- END Left Header Navigation -->

                        <!-- Right Header Navigation -->

                        <!-- END Right Header Navigation -->
                    </header>
                    <!-- END Header -->

                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Page Header -->
                        <?php
                        if (isset($plugin)) {
                            echo $plugin;
                        }
                        ?>

                        <!-- END Example Block -->
                    </div>

                    <!-- END Page Content -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="/themebackend/js/vendor/jquery-2.2.4.min.js"></script>


        <script src="/themebackend/js/plugins.js"></script>
        <script src="/themebackend/js/app.js"></script>

        <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="/themebackend/js/vendor/bootstrap.min.js"></script>
        <script src="/themebackend/js/bootstrap_select/js/bootstrap-select.js"></script>

        <script src="/themebackend/js/plugins/summernote.js"></script>

        <script src="/themebackend/js/packages/barryvdh/elfinder/js/elfinder.min.js"></script>

        <?php if ($locale) { ?>
            <!-- elFinder translation (OPTIONAL) -->
            <script src="/themebackend/js/packages/barryvdh/elfinder/js/i18n/elfinder.<?php echo $locale; ?>.js"></script>
        <?php } ?>
        <!--        <-- Import Trumbowyg -->

        <script type="text/javascript" charset="utf-8">
                                    // Documentation for client options:
                                    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
                                    $().ready(function() {
                                    if ($(".elfinder").length > 0){
                                    $('.elfinder').elfinder({
                                    // set your elFinder options here
<?php if ($locale) { ?>
                                        lang: '<?= $locale ?>', // locale
<?php } ?>
                                    customData: {
                                    _token: '<?= csrf_token() ?>'
                                    },
                                            url : '<?= route("elfinder.connector") ?>', // connector URL
                                            soundPath: '<?= asset('/themebackend/js/packages/barryvdh/elfinder/sounds') ?>'
                                    });
                                    }
                                    });
        </script>
        <!--        <-- Import Trumbowyg plugins... -->
        <!--        <script src="/themebackend/js/newgui/plugins/upload/trumbowyg.cleanpaste.min.js"></script>
        -->
        <script src="/themebackend/js/newgui/dist/trumbowyg.elfinder.js"></script>
        <script src="/themebackend/js/newgui/plugins/pasteimage/trumbowyg.pasteimage.js"></script>
        <script src="/themebackend/js/newgui/dist/trumbowyg.js"></script>

        <!--        <-- Init Trumbowyg -->
        <script>
                                    // Doing this in a loaded JS file is better, I put this here for simplicity

        </script>


        <link rel="stylesheet" href="/themebackend/notify/themes/alertify.core.css" />
        <link rel="stylesheet" href="/themebackend/notify/themes/alertify.default.css" id="toggleCSS" />
        <script src="/themebackend/notify/lib/alertify.min.js"></script>

        <script>


        </script>




        <script src="/themebackend/js/editor.js/json-preview.js" type="text / javascript"></script>
        <script src="/themebackend/js/editor.js/plugin_psummernote.js"></script>
        <script src="/themebackend/js/editor.js/plugin_paragraph.js"></script>
        <script src="/themebackend/js/editor.js/plugin_header.js"></script>
        <script src="<?php echo route('backend/editjs/blocks.js'); ?>" type="text/javascript"></script>


        <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@2.1.3/dist/bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@1.1.0/dist/bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@1.1.1/dist/bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script> 


        <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script> 
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest"></script> 
        <script src="<?php echo route('backend/editjs/config.js'); ?>"></script>
        <script src="/themebackend/js/editor.js/editor.js" type="text/javascript">

        </script>
        <script type="text/javascript" src="/themebackend/js/global.js"></script>
        <link rel="stylesheet" href="/themebackend/notify/themes/alertify.core.css" />
        <link rel="stylesheet" href="/themebackend/notify/themes/alertify.default.css" id="toggleCSS" />
        <script src="/themebackend/notify/lib/alertify.min.js"></script>
        <script>
<?php
if (isset($flash_success)) {
    ?>
                                        alertify.alert("<?php echo $flash_success; ?>");
    <?php
}
?>
<?php
if (isset($flash_error)) {
    ?>
                                        alertify.alert("<?php echo $flash_error; ?>");
    <?php
}
?>


        </script>


    </body>
</html>
