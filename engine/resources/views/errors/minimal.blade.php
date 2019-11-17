<!DOCTYPE html>
<!--

        Theme Name: HASWELL
        Description: HTML/CSS 
        Author: ABCgomel 
        Designed & Coded by ABCgomel
        
-->

<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
        <meta name="robots" content="index, follow" > 
        <meta name="keywords" content="HTML5 Template" > 
        <meta name="description" content="Haswell - Responsive HTML5 Template" > 
        <meta name="author" content="ABCgomel">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="/favicon.ico">
        <!--        <link rel="apple-touch-icon" href="images/favicon/apple-touch-icon.png">
                <link rel="apple-touch-icon" sizes="72x72" href="/themefrontend/html/images/favicon/apple-touch-icon-72x72.png">
                <link rel="apple-touch-icon" sizes="114x114" href="/themefrontend/html/images/favicon/apple-touch-icon-114x114.png">-->

        <!-- CSS -->

        <!-- FLEXSLIDER SLIDER CSS -->
        <link rel="stylesheet" type="text/css" href="/themefrontend/html/css/flexslider.css"  >

        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="/themefrontend/html/css/bootstrap.min.css"> 

        <!-- GOOGLE FONT -->		
        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700%7COpen+Sans:400,300,700' rel='stylesheet' type='text/css'>

        <!-- ICONS ELEGANT FONT & FONT AWESOME & LINEA ICONS -->		
        <link rel="stylesheet" href="/themefrontend/html/css/icons-fonts.css" >	

        <!-- CSS THEME -->		
        <link rel="stylesheet" href="/themefrontend/html/css/style.css" >

        <!-- ANIMATE -->	
        <link rel='stylesheet' href="/themefrontend/html/css/animate.min.css">

        <!-- IE Warning CSS -->
        <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="css/ie-warning.css" ><![endif]-->
        <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="css/ie8-fix.css" ><![endif]-->

        <!-- Magnific popup  in style.css	Owl Carousel Assets in style.css -->		

        <!-- CSS end -->

        <!-- JS begin some js files in bottom of file-->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Modernizr -->
        <!-- <script src="js/modernizr.js"></script> -->

    </head>
    <body>

        <!-- LOADER -->	
        <div id="loader-overflow">
            <div id="loader3">Please enable JS</div>
        </div>	

        <div id="wrap" class="boxed ">
            <div class="grey-bg"> <!-- Grey BG  -->	

                <!--[if lte IE 8]>
                <div id="ie-container">
                        <div id="ie-cont-close">
                                <a href='#' onclick='javascript&#058;this.parentNode.parentNode.style.display="none"; return false;'><img src='images/ie-warn/ie-warning-close.jpg' style='border: none;' alt='Close'></a>
                        </div>
                        <div id="ie-cont-content" >
                                <div id="ie-cont-warning">
                                        <img src='images/ie-warn/ie-warning.jpg' alt='Warning!'>
                                </div>
                                <div id="ie-cont-text" >
                                        <div id="ie-text-bold">
                                                You are using an outdated browser
                                        </div>
                                        <div id="ie-text">
                                                For a better experience using this site, please upgrade to a modern web browser.
                                        </div>
                                </div>
                                <div id="ie-cont-brows" >
                                        <a href='http://www.firefox.com' target='_blank'><img src='images/ie-warn/ie-warning-firefox.jpg' alt='Download Firefox'></a>
                                        <a href='http://www.opera.com/download/' target='_blank'><img src='images/ie-warn/ie-warning-opera.jpg' alt='Download Opera'></a>
                                        <a href='http://www.apple.com/safari/download/' target='_blank'><img src='images/ie-warn/ie-warning-safari.jpg' alt='Download Safari'></a>
                                        <a href='http://www.google.com/chrome' target='_blank'><img src='images/ie-warn/ie-warning-chrome.jpg' alt='Download Google Chrome'></a>
                                </div>
                        </div>
                </div>
                <![endif]-->

                <!-- HEADER 1  -->
                <header id="nav" class="header header-1">

                    <div class="header-wrapper">
                        <div class="container-m-30 clearfix">
                            <div class="logo-row">

                                <!-- LOGO --> 
                                <div class="logo-container-2">
                                    <div class="logo-2">
                                        <a href="/" class="clearfix">
                                            <img src="/themefrontend/html/images/logo.png" class="logo-img" alt="Logo">
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- END header-wrapper -->

                </header>

                <!-- COTENT CONTAINER -->
                <div class="container maintenance-container">

                    <div class="row m-bot-40">
                        <div class="col-md-4 text-center maintenance-icon-container">
                            <span aria-hidden="true" class="icon_tools maintenance-icon"></span>
                        </div>
                        <div class="col-md-8 maintenance-text-container">
                            <h1> @yield('code')</h1>
                            <h2>@yield('message')</h2>

                        </div>

                    </div>

                </div>

                <!-- NEWS LETTER -->


                <!-- FOOTER 2 -->


                <!-- BACK TO TOP -->
                <p id="back-top">
                    <a href="#top" title="Back to Top"><span class="icon icon-arrows-up"></span></a>
                </p>

            </div><!-- End BG -->	
        </div><!-- End wrap -->	

        <!-- JS begin -->

        <!-- jQuery  -->
        <script src="/themefrontend/html/js/jquery-1.11.2.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/themefrontend/html/js/bootstrap.min.js"></script>		

        <!-- MAGNIFIC POPUP -->
        <script src='/themefrontend/html/js/jquery.magnific-popup.min.js'></script>

        <!-- PORTFOLIO SCRIPTS -->
        <script src="/themefrontend/html/js/imagesloaded.pkgd.min.js"></script>

        <!-- COUNTER -->
        <script src="/themefrontend/html/js/jquery.countTo.js"></script>

        <!-- APPEAR -->    
        <script src="/themefrontend/html/js/jquery.appear.js"></script>

        <!-- OWL CAROUSEL -->    
        <script src="/themefrontend/html/js/owl.carousel.min.js"></script>

        <!-- MAIN SCRIPT -->
        <script src="/themefrontend/html/js/main.js"></script>

        <!-- JS end -->	

    </body>
</html>		