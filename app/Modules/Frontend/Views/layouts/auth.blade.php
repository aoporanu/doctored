<!DOCTYPE html>
<html lang="en">
<head>
  <title>Doctored</title>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/frontend/customstyles.css">
 
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
   <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet"> -->
 <link href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2:wght@400;500;600;700;800&display=swa" rel="stylesheet">
 <link rel="stylesheet" href="/frontend/bootstrap.min.css">
 <link rel="stylesheet" href="/frontend/override.css">
  <script src="/frontend/jquery.min.js"></script>
  <script src="/frontend/popper.min.js"></script>
  <script src="/frontend//bootstrap.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

 
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script> 
  
 
</head>
<body>
 
<div class="container-fluid wrap_bg">
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg_green">
  <a class="navbar-brand" href="/"><img src="/frontend/images/logo_web.svg" class="img-responsive logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                   <li class="nav-item dropdown">
               
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          @if(isset($doctorInfo))   Hi {{ucfirst($doctorInfo['firstname'])}}    @endif   
						   @if(isset($info))   Hi {{ucfirst($info['firstname'])}}    @endif   
						  
						  <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" style="color: #000000 !important" 
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
<?php // print_r($doctorInfo);?>
@yield('content')
  <div class="fullcont_sec">
   <div class="bg_grey">
   <div class="foot_bg">
   <div class="row h-100">
   <div class="col-sm-1 col-md-1 col-2 my-auto"><img src="/frontend/images/foot_logo.svg" class="img-responsive fot_logo"></div>
   <div class="col-sm-8 col-md-5 col-10">
   <p>
   Ut perum sequate stempori ut velique cor
maiosti onsectati assinie nditem et omnient,
tem quis autatem sintin re veruptam,
consedCiis eostrum que et hilignatior 
   </p>
   </div>
   <div class="col-sm-3 col-md-3 col-12 my-auto"> 
   <ul class="navbar-nav footer_links">
      <li class="nav-item active">
        <a class="nav-link" href="/terms-and-conditions">Terms and conditions <span class="sr-only">(current)</span></a>
      </li>
      <!-- <li class="nav-item"> -->
        <!-- <a class="nav-link" href="#">Plans & pricing</a> -->
      <!-- </li> -->
      <li class="nav-item">
        <a class="nav-link" href="/privacy-policy">Privacy Policy	</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sitemap">Sitemap</a>
      </li>
    </ul>
   
   </div>
   <div class="col-sm-3 col-md-3 col-12 my-auto">
   <ul class="foot_links">
   <li><i class="fa fa-linkedin"></i></li>
   <li><i class="fa fa-twitter"></i></li>
   <li><i class="fa fa-facebook-f"></i></li>
   </ul>
   </div>
   </div>
   </div>
 </div>
</div>

</div>
</div>
</body>
</html>
<style type="text/css">
.footer_links .nav-link {padding:0px;color:#fff}
.mand{color:#dc3545;}

</style>

<script src="/frontend/locate.js"></script>