<!DOCTYPE html>
<html lang="en">
<?php
use Illuminate\Support\Facades\Auth;$doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()), 1);
$info = json_decode(json_encode(Auth::guard('patient')->user()), 1);
?>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Doctored @yield('title')</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/img/foot_logo.png" rel="icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/material/global/vendor/select2/select2.css">
    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}"/>
</head>

<body>
<!-- ======= Top Bar ======= -->
<div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
        <div class="contact-info mr-auto">
            <i class="icofont-envelope"></i> <a href="mailto:contact@example.com">contact@doctored.com</a>
            <i class="icofont-phone"></i> +91 98XXXXXXXX
        </div>
        <div class="social-links">
            <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
            <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
            <a href="#" class="linkedin"><i class="icofont-linkedin"></i></a>
        </div>
        <div class="col-md-2 form-group">
            <select class="selectpicker w-100" data-width="fit">
                <option data-content='<span class="flag-icon flag-icon-us"></span> English'>English US</option>
                <!--<option  data-content='<span class="flag-icon flag-icon-mx"></span> Español'>Hindi</option>-->
            </select>
        </div>
    </div>
</div>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo mr-auto">
            <a href="/"><img src="/assets/img/logo_web.svg" class="web-logo" alt="web-logo"/></a>
            <a href="/"><img src="/assets/img/foot_logo.png" class="mob-logo" alt="mobile-logo"/></a>
        </h1>

        <nav class="nav-menu d-none d-lg-block">
            <ul>

                @if(!isset($doctorInfo) && !isset($info))
                    <li class="active"><a href="/">Home</a></li>
                    <li><a href="/#how-does-it-work">How does it work?</a></li>
                    <li><a href="/#vision">Our Vision</a></li>
                    <li><a href="/#departments">Multi-speciality Clinics</a></li>
                @else

                    @if(isset($doctorInfo))
                        <li class="active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('slot.manage') }}">Manage Slots</a></li>
                        <li><a href="{{ route('doctor.manage-prescription') }}">Manage Prescription</a></li>

                    @else
                        <li class="<?php if(in_array('patient-dashboard', explode('/', url()->current()))) { ?>active <?php } ?>">
                            <a href="/patient-dashboard">Dashboard</a></li>
                        <li class="<?php if(in_array('managebookings', explode('/', url()->current()))) { ?>active <?php } ?>">
                            <a href="/managebookings">Manage Bookings</a></li>
                    @endif
                    <li class="<?php if(in_array('manage-reports', explode('/', url()->current()))) { ?>active <?php } ?>">
                        <a href="/manage-reports">Manage Reports</a></li>



                @endif

            </ul>
        </nav><!-- .nav-menu -->
        @if(!isset($doctorInfo) && !isset($info))
            <a href="/login" class="appointment-btn scrollto">Login/Signup</a>
        @else
            <div class="user-menu-wrap">
                <?php
                $name = "Name";            $code = "#";            $image = "";            $link = "";
                if (isset($doctorInfo)) {
                    $name = "DR." . $doctorInfo['firstname'] . " " . $doctorInfo['lastname'];
                    $code = "#" . $doctorInfo['doctorcode'];
                    $image = $doctorInfo['photo'];
                    if ($image == '') {
                        $image = '/assets/img/doc.png';
                    }
                } else {
                    $name = $info['title'] . "." . $info['firstname'] . " " . $info['lastname'];
                    $code = "#" . $info['patientcode'];
                    $image = $info['photo'];
                    if ($image == '') {
                        $image = '/assets/img/patient-avatar.png';
                    }
                }
                ?>
                <a @click="e => e.target.classList.toggle('active')" class="mini-photo-wrapper" href="#"><img alt=""
                                                                                                              class="mini-photo"
                                                                                                              src="{{$image}}"
                                                                                                              width="36"
                                                                                                              height="36"/></a>

                <div class="menu-container">
                    <ul class="user-menu">

                        <div class="profile-highlight">
                            <img src="{{$image}}" alt="profile-img" width="36" height="36">
                            <div class="details">
                                <div id="profile-name">{{$name}}</div>
                                <div id="profile-footer">{{$code}} </div>
                                <!--<div id="profile-footer">Neuro</div>-->
                            </div>
                        </div>
                        <li class="user-menu__item">
                            <a class="user-menu-link" href="/doctor/editprofile/{{str_replace('#', '', $code)}}">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                <div>Edit Profile</div>
                            </a>
                        </li>
                        <div class="footer">
                            <li class="user-menu__item"><a class="user-menu-link txt-green"
                                                           href="{{ route('logout') }}"><i class="fa fa-sign-out"
                                                                                           aria-hidden="true"></i>
                                    <div>Logout</div>
                                </a></li>
                        </div>
                    </ul>
                </div>
            </div>
        @endif


    </div>
</header><!-- End Header -->
<div id="main" class="container">
    <div class="clearfix"></div>
    <div class="circle square-1"></div>
    <div class="circle square-2"></div>
    <div class="circle square-3"></div>
    <div class="circle square-4"></div>
    <div class="circle square-5"></div>
    <div class="circle square-6"></div>

    @yield('content')

</div><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="fixed-bottom">

    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h3><img src="/assets/img/foot_logo.png" alt="footer-logo"/></h3>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6 col-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">How does it work?</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Contact Us</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-6 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">FAQ's</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Terms & Conditions</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy Policy</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-md-flex py-4">

        <div class="mr-md-auto text-center text-md-left">
            <div class="copyright">
                &copy; Copyright <strong><span>Doctored</span></strong>. All Rights Reserved
            </div>

        </div>

        <input type="text" name="userip" class="user-ip" value="" style="background:#214214;color:#fff;border:0px"
               readonly disabled>
        <input type="text" name="usercountry" class="user-country" value=""
               style="background:#214214;color:#fff;border:0px" readonly disabled>

        <div class="social-links text-center text-md-right pt-3 pt-md-0">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
    </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
<script src="{{ mix('js/app.js') }}"></script>


<!-- Vendor JS Files -->
<!--- important for footer and dependecies -->
<script type="text/javascript">
    initCountry();


    //regular expressions to extract IP and country values
    const countryCodeExpression = /loc=([\w]{2})/;
    const userIPExpression = /ip=([\w\.]+)/;

    //automatic country determination.
    function initCountry() {
        let xhr = new XMLHttpRequest();
        xhr.timeout = 3000;
        xhr.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    let countryCode = countryCodeExpression.exec(this.responseText)
                    let ip = userIPExpression.exec(this.responseText)
                    if (countryCode === null || countryCode[1] === '' ||
                        ip === null || ip[1] === '') {
                        console.log('IP/Country code detection failed');
                    }
                    /*var result = {
                        "countryCode": countryCode[1],
                        "IP": ip[1]
                    }; */
                    cc = countryCode[1];
                    //adding to footer
                    $('.user-ip').val(ip[1]);
                    $('.user-country').val(cc);
                    $.ajax('/settimezone/' + cc);

                } else {
                    // console.log(xhr.status)
                }
            }
        }
        xhr.ontimeout = function () {
            // console.log('timeout')
        }
        xhr.open('GET', 'https://www.cloudflare.com/cdn-cgi/trace', true);
        xhr.send();

    }

    $(document).ready(function () {
        $('#preloader').hide();
        $.widget("custom.catcomplete", $.ui.autocomplete, {
            _create: function () {
                this._super();
                this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
            },
            _renderMenu: function (ul, items) {
                var that = this,
                    currentCategory = "";
                $.each(items, function (index, item) {
                    var li;
                    if (item.category !== currentCategory) {
                        ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                        currentCategory = item.category;
                    }
                    li = that._renderItemData(ul, item);
                    if (item.category) {
                        li.attr("aria-label", item.category + " : " + item.label);
                    }
                });

            }
        });

        $("#doctor").catcomplete({
            delay: 0,
            source: 'getsuggestions',
            select: function (event, ui) {
                location_name = $('#city').val();
                gotosearchpage = "";
                if (ui.item.type == 'group') {
                    event.preventDefault();
                    gotosearchpage = 't=g&v=' + ui.item.name;
                    gotoprofilepage = 'group/' + ui.item.code;
                } else if (ui.item.type == 'doctor') {
                    gotosearchpage = 't=d&v=' + ui.item.label;
                    gotoprofilepage = 'doctor/' + ui.item.code;
                    //  window.location.href='doctor/profile/'+ui.item.id;
                } else if (ui.item.type == 'hospital') {
                    gotosearchpage = 't=h&v=' + ui.item.label;
                    gotoprofilepage = 'hospital/' + ui.item.code;
                    // window.location.href='hospital/profile/'+ui.item.id;
                }
                gotosearchpage = '/search?' + gotosearchpage;
                if (location_name != '' || location_name != undefined) {
                    //	gotosearchpage = gotosearchpage+'&location_name='+location_name;
                }
                //window.location.href = gotosearchpage;
                window.location.href = gotoprofilepage;
            }
        });
        if ($(document).hasClass('js-example-basic-multiple')) {
            $('.js-example-basic-multiple').select2();
        }
        if ($('a').hasClass("mini-photo-wrapper")) {
            document.querySelector('.mini-photo-wrapper').addEventListener('click', function () {
                document.querySelector('.menu-container').classList.toggle('active');
            });
        }
    });


    //Code for get geo location
    function getTimezones() {

        $('.timezone').find("option:eq(0)").html("Please wait..");

        var jqxhr = $.ajax("/getTimezones")
            .done(function (data) {
                $('.timezone').find("option:eq(0)").html("Select Timezone");
                var countrySelectedId = 0;
                var data = JSON.parse(data);
                //console.log(data);
                $.each(data, function (key, val) {
                    // console.log(val.name);
                    var option = $('<option />');

                    option.attr('value', val.countrycode).text(val.utc);

                    $('.timezone').append(option);
                    //customzied with another method only for screen


                });

                //	console.log('timezones loaded');
                //console.log('timezones updated');

            })
            .fail(function () {
                //  alert( "error" );
            })
            .always(function () {
                //  alert( "complete" );
            });

    }


</script>

<script src="/assets/vendor/jquery/jquery.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="/assets/vendor/php-email-form/validate.js"></script>
<script src="/assets/vendor/venobox/venobox.min.js"></script>
<script src="/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="/assets/vendor/counterup/counterup.min.js"></script>


<!-- Owl Carouse JS File -->
<script type="text/javascript" src="/assets/js/owl.carousel/owl.carousel.js"></script>

<!-- Template Main JS File -->
<script src="/frontend/locate.js"></script>

{{--<script src="/frontend/custom.js"></script>--}}

<!-- search -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@yield('jscript')
@if(Request::is('/'))
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9ZxHaV_cEegOJfb8FnF_qcNUPIMDQ0A&callback=initAutocomplete&libraries=places&v=weekly"
        defer
    ></script>
    <script src="frontend/maps.js"></script>
@endif

<!-- SlotConfiguration Code -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!--end of slot configuration-->
<!-- Owl Carouse JS File -->

</body>

</html>
