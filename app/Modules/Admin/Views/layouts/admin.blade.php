
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="bootstrap material admin template">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard | @yield('title') || {{ env('APP_NAME')}}</title>

        <link rel="apple-touch-icon" href="/material/base/assets/images/apple-touch-icon.png">
        <link rel="shortcut icon" href="/material/base/assets/images/favicon.ico">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="/material/global/css/bootstrap.min.css">
        <link rel="stylesheet" href="/material/global/css/bootstrap-extend.min.css">
        <link rel="stylesheet" href="/material/base/assets/css/site.min.css">

        <!-- Plugins -->
        <link rel="stylesheet" href="/material/global/vendor/animsition/animsition.css">
        <link rel="stylesheet" href="/material/global/vendor/asscrollable/asScrollable.css">
        <link rel="stylesheet" href="/material/global/vendor/switchery/switchery.css">
        <link rel="stylesheet" href="/material/global/vendor/intro-js/introjs.css">
        <link rel="stylesheet" href="/material/global/vendor/slidepanel/slidePanel.css">
        <link rel="stylesheet" href="/material/global/vendor/flag-icon-css/flag-icon.css">
        <link rel="stylesheet" href="/material/global/vendor/waves/waves.css">
        <link rel="stylesheet" href="/material/global/vendor/chartist/chartist.css">
        <link rel="stylesheet" href="/material/global/vendor/jvectormap/jquery-jvectormap.css">
        <link rel="stylesheet" href="/material/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
        <link rel="stylesheet" href="/material/global/vendor/summernote/summernote.css">
        <link rel="stylesheet" href="/material/base/assets/examples/css/dashboard/v1.css">
        <link rel="stylesheet" href="/material/global/vendor/select2/select2.css">


        <!-- Fonts -->
        <link rel="stylesheet" href="/material/global/fonts/material-design/material-design.min.css">
        <link rel="stylesheet" href="/material/global/fonts/brand-icons/brand-icons.min.css">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
		
		<!--data tables-->

        <link rel="stylesheet" href="/material/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="/material/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
        <link rel="stylesheet" href="/material/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
        <link rel="stylesheet" href="/material/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
        <link rel="stylesheet" href="/material/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
        <link rel="stylesheet" href="/material/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
        <link rel="stylesheet" href="/material/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
        <link rel="stylesheet" href="/material/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
        <link rel="stylesheet" href="/material/base/assets/examples/css/tables/datatable.css">
        <link rel="stylesheet" href="/admin/css/bootstrapValidator.css">
        <!--<link rel="stylesheet" href="/admin/css/bootstrap.css">-->
        <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>


        <!--[if lt IE 9]>
        <script src="/material/global/vendor/html5shiv/html5shiv.min.js"></script>
        <![endif]-->

        <!--[if lt IE 10]>
        <script src="/material/global/vendor/media-match/media.match.min.js"></script>
        <script src="/material/global/vendor/respond/respond.min.js"></script>
        <![endif]-->

        <!-- Scripts -->
        <script src="/material/global/vendor/breakpoints/breakpoints.js"></script>
        <script>
Breakpoints();
        </script>
        <style type="text/css">

            .site-navbar {
                background-color: #224314;
            }
        </style>


    </head>
    <body class="animsition dashboard">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

            <div class="navbar-header">
                <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                        data-toggle="menubar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="hamburger-bar"></span>
                </button>
                <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
                        data-toggle="collapse">
                    <i class="icon md-more" aria-hidden="true"></i>
                </button>
                <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
                    <img class="navbar-brand-logo" src="/material/base/assets/images/logo.png" title="Remark">
                    <span class="navbar-brand-text hidden-xs-down" style="color:#fcd243"> doctored <sup><span style="font-size:10px;font-weight:normal"> &#174;</span></sup></span>
                </div>
                <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
                        data-toggle="collapse">
                    <span class="sr-only">Toggle Search</span>
                    <i class="icon md-search" aria-hidden="true"></i>
                </button>
            </div>

            <div class="navbar-container container-fluid">
                <!-- Navbar Collapse -->
                <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
                    <!-- Navbar Toolbar -->
                    <ul class="nav navbar-toolbar">
                        <li class="nav-item hidden-float" id="toggleMenubar">
                            <a class="nav-link" data-toggle="menubar" href="#" role="button">
                                <i class="icon hamburger hamburger-arrow-left">
                                    <span class="sr-only">Toggle menubar</span>
                                    <span class="hamburger-bar"></span>
                                </i>
                            </a>
                        </li>

                        <!--<li class="nav-item hidden-float">
                          <a class="nav-link icon md-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
                            role="button">
                            <span class="sr-only">Toggle Search</span>
                          </a>
                        </li>-->

                    </ul>
                    <!-- End Navbar Toolbar -->
                    <!-- start hospital list -->
                    <?php $hospitalList = App\Modules\Admin\Controllers\AdminIndexController::getHospitalListHtml(); ?>
                    <?php $selectedHospital = Session::get('hospital_id'); ?>
                    @if(!empty($hospitalList))
                    <div class="nav navbar-toolbar navbar-left hospital_list" style="margin-top: 20px;">
                        <select name="hospital_id" id="hospital_id">
                            @foreach($hospitalList as $hospitalData)
                            <?php $hospitalDetails = App\Modules\Admin\Controllers\AdminIndexController::getHospitalDetails($hospitalData->hospital_id);
                            $hospitalName = $hospitalDetails ? $hospitalDetails->hospital_name : ''; ?>
                            <option value="{{$hospitalData->hospital_id}}" @if($selectedHospital == $hospitalData->hospital_id) selected @endif>{{$hospitalName}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <!-- end hospital list -->
                    <!-- Navbar Toolbar Right -->
                    <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                               data-animation="scale-up" role="button">
                                <span>Welcome <b>{{Session::get('user_name') ? ucwords(Session::get('user_name')): 'Test'}}</b></span>
                                <span class="avatar avatar-online">
                                @if(Session::get('profilepic'))
                                    <img src="../../uploads/{{Session::get('profilepic')}}" alt="{{Session::get('user_name')}}">
                                @else
                                <img src="/material/global/portraits/5.jpg" alt="{{Session::get('user_name')}}">
                                @endif
                                    <i></i>
                                </span>
                            </a>
                            <div class="dropdown-menu" role="menu">
                                 <a class="dropdown-item" href="javascript:void(0)" onclick="window.location.href='/admin/profile/'" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Profile</a>
                                <!-- <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-card" aria-hidden="true"></i> Billing</a>
                                <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-settings" aria-hidden="true"></i> Settings</a> -->
                                <div class="dropdown-divider" role="presentation"></div>
                                <a class="dropdown-item" href="/admin/logout" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>
                            </div>
                        </li>

                    </ul>
                    <!-- End Navbar Toolbar Right -->
                </div>
                <!-- End Navbar Collapse -->

                <!-- Site Navbar Seach -->
                <div class="collapse navbar-search-overlap" id="site-navbar-search">
                    <form role="search">
                        <div class="form-group">
                            <div class="input-search">
                                <i class="input-search-icon md-search" aria-hidden="true"></i>
                                <input type="text" class="form-control" name="site-search" placeholder="Search...">
                                <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
                                        data-toggle="collapse" aria-label="Close"></button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End Site Navbar Seach -->
            </div>
        </nav>    <div class="site-menubar">
            <div class="site-menubar-body">
                <div>
                    <div>
                        <ul class="site-menu treeview" data-plugin="menu">
                            <!--<li class="site-menu-category">Navigation</li>-->
                            <?php $menuList = App\Modules\Admin\Controllers\AdminIndexController::getMenusHtml(); ?>
                            <?php $hospitalId = isset($_GET['hospital_id']) ? $_GET['hospital_id'] : 0; ?>
                            @if(!empty($menuList))
                            @foreach($menuList as $menuItem)
                                <?php $menuDetails = App\Modules\Admin\Controllers\AdminIndexController::getMenuDetails($menuItem->menu_id); ?>
                                <?php if(!empty($menuDetails)){
                                    $menuUrl = $menuDetails->menu_url;
                                    $menuIcon = $menuDetails->menu_icon;
                                    $menuName = $menuDetails->menu_name;
                                } ?>
                                <li class="site-menu-item nav-item has-treeview {{ Request::is(ltrim($menuUrl, '/')) ? 'active' : '' }}">
                                    <a class="animsition-link" @if($hospitalId > 0 && !property_exists($menuItem, 'sub_menu')) href="{{$menuUrl.'?hospital_id='.$hospitalId}}" @elseif(!property_exists($menuItem, 'sub_menu')) href="{{$menuUrl}}" @endif>
                                        <i class="site-menu-icon {{$menuIcon}}" aria-hidden="true"></i>
                                        <span class="site-menu-title">{{$menuName}}</span>
                                    </a>
                                    @if(property_exists($menuItem, 'sub_menu'))
                                    <ul class="site-menu nav nav-treeview" data-plugin="menu">
                                        @foreach($menuItem->sub_menu as $subMenu)
                                            <?php $subMenuDetails = App\Modules\Admin\Controllers\AdminIndexController::getMenuDetails($subMenu->menu_id); ?>
                                            <?php if(!empty($subMenuDetails)){
                                                $subMenuUrl = $subMenuDetails->menu_url;
                                                $subMenuIcon = $subMenuDetails->menu_icon;
                                                $subMenuName = $subMenuDetails->menu_name;
                                            } ?>
                                            <li class="site-menu-item nav-item {{ Request::is($subMenuUrl) ? 'active' : '' }}">
                                                <a class="animsition-link" @if($hospitalId > 0) href="{{$subMenuUrl.'?hospital_id='.$hospitalId}}" @else href="{{$subMenuUrl}}" @endif>
                                                    <i class="site-menu-icon {{$subMenuIcon}}" aria-hidden="true"></i>
                                                    <span class="site-menu-title">{{$subMenuName}}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                            @endforeach
                            @endif
<!--                            <li class="site-menu-item active">
                                <a class="animsition-link" href="/admin/dashboard">
                                    <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                                    <span class="site-menu-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="site-menu-item active">
                                <a class="animsition-link" href="/admin/roles">
                                    <i class="site-menu-icon md-view-roles" aria-hidden="true"></i>
                                    <span class="site-menu-title">Roles</span>
                                </a>
                            </li>
                            <li class="site-menu-item active">
                                <a class="animsition-link" href="/admin/users">
                                    <i class="site-menu-icon md-view-users" aria-hidden="true"></i>
                                    <span class="site-menu-title">Users</span>
                                </a>
                            </li>
                            <li class="site-menu-item active">
                                <a class="animsition-link" href="/admin/hospitals">
                                    <i class="site-menu-icon md-view-hospitals" aria-hidden="true"></i>
                                    <span class="site-menu-title">Hospitals</span>
                                </a>
                            </li>-->
                        </ul>
                        <div class="site-menubar-section">




                        </div>      </div>
                </div>
            </div>

            <div class="site-menubar-footer">
                <!--  <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
                    data-original-title="Settings">
                    <span class="icon md-settings" aria-hidden="true"></span>
                  </a>
                  <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
                    <span class="icon md-eye-off" aria-hidden="true"></span>
                  </a>
                  <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
                    <span class="icon md-power" aria-hidden="true"></span>
                  </a>-->
            </div>
        </div>    <div class="site-gridmenu">
            <div>
                <div>
                    <ul>
                        <li>
                            <a href="/admin/dashboard">
                                <i class="icon md-view-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Page -->
        <div class="page">
            <div class="page-content container-fluid">
                @yield('flash-message', View::make('Admin::flashmessage'))
                @yield('content')
            </div>
        </div>
        <!-- End Page -->


        <!-- Footer -->
        <footer class="site-footer">
            <div class="site-footer-legal">Doctored ®</div>
            <div class="site-footer-right">.
            </div>
        </footer>
        <!-- Core  -->
        <script src="/material/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
        <script src="/material/global/vendor/jquery/jquery.js"></script>
        <script src="/material/global/vendor/popper-js/umd/popper.min.js"></script>
        <script src="/material/global/vendor/bootstrap/bootstrap.js"></script>
        <script src="/material/global/vendor/animsition/animsition.js"></script>
        <script src="/material/global/vendor/mousewheel/jquery.mousewheel.js"></script>
        <script src="/material/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
        <script src="/material/global/vendor/asscrollable/jquery-asScrollable.js"></script>
        <script src="/material/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
        <script src="/material/global/vendor/waves/waves.js"></script>

        <!-- Plugins -->
        <script src="/material/global/vendor/switchery/switchery.js"></script>
        <script src="/material/global/vendor/intro-js/intro.js"></script>
        <script src="/material/global/vendor/screenfull/screenfull.js"></script>
        <script src="/material/global/vendor/slidepanel/jquery-slidePanel.js"></script>
     
     <!-- getting jquery conflicts start-->
        <script src="/material/global/vendor/chartist/chartist.min.js"></script>
        <script src="/material/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js"></script>
        <script src="/material/global/vendor/jvectormap/jquery-jvectormap.min.js"></script>
        <script src="/material/global/vendor/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
        <!-- getting jquery conflicts end-->

        <script src="/material/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
        <script src="/material/global/vendor/peity/jquery.peity.min.js"></script>
        <script src="/material/global/vendor/summernote/summernote.js"></script>

        <!-- Scripts -->
        <script src="/material/global/js/Component.js"></script>
        <script src="/material/global/js/Plugin.js"></script>
        <script src="/material/global/js/Base.js"></script>
        <script src="/material/global/js/Config.js"></script>

        <script src="/material/base/assets/js/Section/Menubar.js"></script>
        <script src="/material/base/assets/js/Section/GridMenu.js"></script>
        <script src="/material/base/assets/js/Section/Sidebar.js"></script>
        <script src="/material/base/assets/js/Section/PageAside.js"></script>
        <script src="/material/base/assets/js/Plugin/menu.js"></script>

        <script src="/material/global/js/config/colors.js"></script>
        <script src="/material/base/assets/js/config/tour.js"></script>
        <script>Config.set('assets', '/assets');</script>

        <!-- Page -->
        <script src="/material/base/assets/js/Site.js"></script>
        <script src="/material/global/js/Plugin/asscrollable.js"></script>
        <script src="/material/global/js/Plugin/slidepanel.js"></script>
        <script src="/material/global/js/Plugin/switchery.js"></script>
        <script src="/material/global/js/Plugin/matchheight.js"></script>
        <script src="/material/global/js/Plugin/jvectormap.js"></script>
        <script src="/material/global/js/Plugin/peity.js"></script>
		
		 <!--Data Tables -->
        <script src="/material/global/vendor/datatables.net/jquery.dataTables.js"></script>
        <script src="/material/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
        <script src="/material/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
        <script src="/material/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
        <script src="/material/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
        <script src="/material/global/vendor/datatables.net-scroller/dataTables.scroller.js"></script>
        <script src="/material/global/vendor/datatables.net-responsive/dataTables.responsive.js"></script>
        <script src="/material/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
        <script src="/material/global/vendor/datatables.net-buttons/dataTables.buttons.js"></script>
        <script src="/material/global/vendor/datatables.net-buttons/buttons.html5.js"></script>
        <script src="/material/global/vendor/datatables.net-buttons/buttons.flash.js"></script>
        <script src="/material/global/vendor/datatables.net-buttons/buttons.print.js"></script>
        <script src="/material/global/vendor/datatables.net-buttons/buttons.colVis.js"></script>
        <script src="/material/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
        <script src="/material/global/vendor/select2/select2.full.min.js"></script>
        <script src="/material/global/js/Plugin/select2.js"></script>
        <script src="/material/global/js/Plugin/datatables.js"></script>
    
        <script src="/material/base/assets/examples/js/tables/datatable.js"></script>
        <!-- getting jquery conflicts -->
        <script src="/material/base/assets/examples/js/dashboard/v1.js"></script>
        
        <script src="{{URL::asset('/admin/js/custom.js')}}"></script>
        <script src="{{URL::asset('/frontend/locate.js')}}"></script>
        <script src="{{URL::asset('/admin/js/bootstrapValidator.min.js')}}"></script>
        
    </body>
    @yield('jscript')
    <script type="text/javascript">

      autosuggest();
      function autosuggest(){
        $( "#doc_licence" ).autocomplete({
           source: 'getdoctors',
           minLength: 2,
           params: {  },
           select: function( event, ui ) {
                if(ui.item.label=='No Result Found'){
                   event.preventDefault();
                }
                $('#doctor_id').val(ui.item.doctor_id);
           }
       });
      }
    </script>
</html>
