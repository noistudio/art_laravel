<!DOCTYPE html>

<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title> Login</title>
        <?php echo $pwa_meta; ?>

        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{asset}/img/favicon.png">
        <link rel="apple-touch-icon" href="{asset}img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="{asset}img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="{asset}img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="{asset}img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="{asset}img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="{asset}img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="{asset}img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="{asset}img/icon180.png" sizes="180x180">
        <!-- END Icons -->


        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link href="{asset}css/bootstrap.min.css" rel="stylesheet">
        <link href="{asset}css/plugins.css" rel="stylesheet">


        <!-- Related styles of various icon packs and plugins -->


        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->

        <link href="{asset}css/main.css" rel="stylesheet">
        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->
        <link href="{asset}css/themes.css" rel="stylesheet">
        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link href="{asset}themebackend/css/themes/<?php echo Env('APP_BACKEND_CSS'); ?>" rel="stylesheet">

        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="{asset}js/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
        <!-- Full Background -->
        <!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
        <img src="{asset}img/placeholders/layout/login2_full_bg.jpg" alt="Full Background" class="full-bg animation-pulseSlow">
        <!-- END Full Background -->

        <!-- Login Container -->
        <div id="login-container"> 
            <!-- Login Header --> 
            <h1 class="h2 text-light text-center push-top-bottom animation-pullDown">
                <i class="fa fa-cube text-light-op"></i> <strong><a href="LINK" target="_blank"><?php echo Env('APP_BACKEND_COPYRIGHT_TITLE'); ?></a></strong>
            </h1>
            <!-- END Login Header -->

            <!-- Login Block -->
            <div class="block animation-fadeInQuick">
                <!-- Login Title -->
                <div class="block-title">

                    <h2><?php echo __('backend/login.predstavtes'); ?></h2>

                </div>
                <?php
                if (isset($languages) and is_array($languages) and count($languages)) {
                    ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Язык (<?php echo $current_lang; ?>)
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            foreach ($languages as $lang) {
                                ?>
                                <li><a href="{pathadmin}setlanguage/<?php echo $lang; ?>">Язык <?php echo $lang; ?></a></li>
                                <?php
                            }
                            ?>


                        </ul>
                    </div>
                    <?php
                }
                ?>
                <!-- END Login Title -->

                <!-- Login Form -->
                <form id="form-login" action="<?php echo route('backend/login/doit'); ?>" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label for="login-email" class="col-xs-12"><?php echo __('backend/login.login') ?></label>
                        <div class="col-xs-12">
                            <input type="text"   name="login" class="form-control" placeholder="<?php echo __('backend/login.your_login') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password" class="col-xs-12"><?php echo __('backend/login.password') ?></label>
                        <div class="col-xs-12">
                            <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo __('backend/login.your_password') ?>">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-8">
                            <?php echo csrf_field(); ?>
                        </div>
                        <div class="col-xs-4 text-right">
                            <button type="submit" class="btn btn-effect-ripple btn-sm btn-success"><?php echo __('backend/login.enter'); ?></button>
                        </div>
                    </div>
                </form>
                <!-- END Login Form -->

                <!-- Social Login -->


                <!-- END Social Login -->
            </div>
            <!-- END Login Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a href="<?php echo Env('APP_BACKEND_COPYRIGHT_LINK'); ?>" target="_blank"><?php echo Env('APP_BACKEND_COPYRIGHT_TITLE'); ?></a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="{asset}js/vendor/jquery-2.2.4.min.js"></script>
        <script src="{asset}js/vendor/bootstrap.min.js"></script>
        <script src="{asset}js/plugins.js"></script>
        <script src="{asset}js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="{asset}js/pages/readyLogin.js"></script>
        <script>$(function () {
                ReadyLogin.init();
            });</script>
        <link rel="stylesheet" href="{asset}notify/themes/alertify.core.css" />
        <link rel="stylesheet" href="{asset}notify/themes/alertify.default.css" id="toggleCSS" />
        <script src="{asset}notify/lib/alertify.min.js"></script>

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
