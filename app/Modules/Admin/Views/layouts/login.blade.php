<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="">
    <!--<meta name="csrf-token" content="{{ csrf_token() }}">-->
    <title>Login | {{ env('APP_NAME')}}</title>
    
    <link rel="apple-touch-icon" href="../material/base/assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="../material/base/assets/images/favicon.ico">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../material/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="../material/global/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="../material/base/assets/css/site.min.css">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="../material/global/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="../material/global/vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="../material/global/vendor/switchery/switchery.css">
    <link rel="stylesheet" href="../material/global/vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="../material/global/vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="../material/global/vendor/flag-icon-css/flag-icon.css">
    <link rel="stylesheet" href="../material/global/vendor/waves/waves.css">
        <link rel="stylesheet" href="../material/base/assets/examples/css/pages/login-v2.css">
    
    
    <!-- Fonts -->
    <link rel="stylesheet" href="../material/global/fonts/material-design/material-design.min.css">
    <link rel="stylesheet" href="../material/global/fonts/brand-icons/brand-icons.min.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    
    <!--[if lt IE 9]>
    <script src="../material/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="../material/global/vendor/media-match/media.match.min.js"></script>
    <script src="../material/global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    
    <!-- Scripts -->
    <script src="../material/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
  </head>
  <body class="animsition page-login-v2 layout-full page-dark">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content">
        <div class="page-brand-info">
          <div class="brand">
            <img class="brand-img" src="../frontend/images/logo_web.svg" style="width:60%;" alt="...">
          
          </div>
          <!-- <p class="font-size-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</p> -->
        </div>
      @yield('content')
      
      </div>
    </div>
    <!-- End Page -->


    <!-- Core  -->
    <script src="../material/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
    <script src="../material/global/vendor/jquery/jquery.js"></script>
    <script src="../material/global/vendor/popper-js/umd/popper.min.js"></script>
    <script src="../material/global/vendor/bootstrap/bootstrap.js"></script>
    <script src="../material/global/vendor/animsition/animsition.js"></script>
    <script src="../material/global/vendor/mousewheel/jquery.mousewheel.js"></script>
    <script src="../material/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
    <script src="../material/global/vendor/asscrollable/jquery-asScrollable.js"></script>
    <script src="../material/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
    <script src="../material/global/vendor/waves/waves.js"></script>
    
    <!-- Plugins -->
    <script src="../material/global/vendor/switchery/switchery.js"></script>
    <script src="../material/global/vendor/intro-js/intro.js"></script>
    <script src="../material/global/vendor/screenfull/screenfull.js"></script>
    <script src="../material/global/vendor/slidepanel/jquery-slidePanel.js"></script>
        <script src="../material/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    
    <!-- Scripts -->
    <script src="../material/global/js/Component.js"></script>
    <script src="../material/global/js/Plugin.js"></script>
    <script src="../material/global/js/Base.js"></script>
    <script src="../material/global/js/Config.js"></script>
    
    <script src="../material/base/assets/js/Section/Menubar.js"></script>
    <script src="../material/base/assets/js/Section/GridMenu.js"></script>
    <script src="../material/base/assets/js/Section/Sidebar.js"></script>
    <script src="../material/base/assets/js/Section/PageAside.js"></script>
    <script src="../material/base/assets/js/Plugin/menu.js"></script>
    
    <script src="../material/global/js/config/colors.js"></script>
    <script src="../material/base/assets/js/config/tour.js"></script>
    <script>Config.set('assets', '../../assets');</script>
    
    <!-- Page -->
    <script src="../material/base/assets/js/Site.js"></script>
    <script src="../material/global/js/Plugin/asscrollable.js"></script>
    <script src="../material/global/js/Plugin/slidepanel.js"></script>
    <script src="../material/global/js/Plugin/switchery.js"></script>
        <script src="../material/global/js/Plugin/jquery-placeholder.js"></script>
        <script src="../material/global/js/Plugin/material.js"></script>
    
    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
    
  </body>
</html>
