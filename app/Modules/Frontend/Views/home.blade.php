@extends('Frontend::layouts.frontend') @section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <form action="forms/appointment.php" method="post" role="form" class="php-email-form">
                <div class="form-row">
                    <div class="col-md-4 form-group pr-0">
                        <div id="map" style="display:none"></div>
                        <input type="text" class="cityInput controls form-control" placeholder="City" id="pac-input"
                               name="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
                        <div class="dialogCity"></div>
                        <input type="hidden" id="PlaceName" name="PlaceName"/>
                        <input type="hidden" id="cityLat" name="cityLat"/>
                        <input type="hidden" id="cityLng" name="cityLng"/>
                        <div class="validate"></div>

                    </div>
                    <div class="col-md-4 form-group pl-0 autocomplete">
                        <input type="text" class="doctorInput form-control"
                               placeholder="Search Doctors/Clinics/Hospitals" id="doctor" name="key" autocomplete/>

                        <div class="validate"></div>
                    </div>
                </div>
                <a href="#how-does-it-work" class="btn-get-started scrollto">Get Started</a>
            </form>

        </div>
    </section><!-- End Hero -->
    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
        <div class="container">

            <div class="row">
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="content">
                        <?php
                        if (isset($pagedata['why-choose-doctored'])) {
                            echo $pagedata['why-choose-doctored']['description'];
                        }
                        ?>
                        <?php
                        if (!\Illuminate\Support\Facades\Auth::guard('doctor')->user() && !\Illuminate\Support\Facades\Auth::guard('patient')->user()) {
                        ?>
                        <div class="text-center">

                            <a href="/register" class="more-btn">Sign Up <i class="bx bx-chevron-right"></i></a>
                        </div>
                            <?php } ?>
                    </div>
                </div>
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="icon-boxes d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-receipt"></i>
                                    <?php
                                    if (isset($pagedata['store-records'])) {
                                        echo $pagedata['store-records']['description'];
                                    }
                                    ?>      </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-cube-alt"></i>
                                    <?php
                                    if (isset($pagedata['reach-doctors'])) {
                                        echo $pagedata['reach-doctors']['description'];
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="bx bx-images"></i>
                                    <?php
                                    if (isset($pagedata['language-support'])) {
                                        echo $pagedata['language-support']['description'];
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- End .content-->
                </div>
            </div>

        </div>
    </section><!-- End Why Us Section -->

    <!-- ======= About Section ======= -->
    <section id="how-does-it-work" class="about">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch">
                </div>

                <div
                    class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <?php
                    if (isset($pagedata['how-does-it-work'])) {
                        echo $pagedata['how-does-it-work']['description'];
                    }
                    ?>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="vision" class="services section-bg">
        <div class="container">

            <div class="section-title">
                <?php
                if (isset($pagedata['our-vision'])) {
                    echo $pagedata['our-vision']['description'];
                }
                ?>
            </div>

        </div>
    </section><!-- End Services Section -->

    <!-- ======= Departments Section ======= -->
    <section id="departments" class="departments">
        <div class="container">

            <div class="section-title">
                <?php
                if (isset($pagedata['multi-speciality-clinics'])) {
                    echo $pagedata['multi-speciality-clinics']['description'];
                }
                ?>

            </div>

            <div class="row">
                <div class="col-lg-3">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#tab-1">Cardiology</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-2">Neurology</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-3">Hepatology</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-4">Pediatrics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-5">Eye Care</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-1">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Cardiology</h3>
                                    <p class="font-italic">Qui laudantium consequatur laborum sit qui ad sapiente dila
                                        parde sonata raqer a videna mareta paulona marka</p>
                                    <p>Et nobis maiores eius. Voluptatibus ut enim blanditiis atque harum sint. Laborum
                                        eos ipsum ipsa odit magni. Incidunt hic ut molestiae aut qui. Est repellat
                                        minima eveniet eius et quis magni nihil. Consequatur dolorem quaerat quos qui
                                        similique accusamus nostrum rem vero</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-1.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-2">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Et blanditiis nemo veritatis excepturi</h3>
                                    <p class="font-italic">Qui laudantium consequatur laborum sit qui ad sapiente dila
                                        parde sonata raqer a videna mareta paulona marka</p>
                                    <p>Ea ipsum voluptatem consequatur quis est. Illum error ullam omnis quia et
                                        reiciendis sunt sunt est. Non aliquid repellendus itaque accusamus eius et velit
                                        ipsa voluptates. Optio nesciunt eaque beatae accusamus lerode pakto madirna
                                        desera vafle de nideran pal</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-2.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-3">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Impedit facilis occaecati odio neque aperiam sit</h3>
                                    <p class="font-italic">Eos voluptatibus quo. Odio similique illum id quidem non enim
                                        fuga. Qui natus non sunt dicta dolor et. In asperiores velit quaerat perferendis
                                        aut</p>
                                    <p>Iure officiis odit rerum. Harum sequi eum illum corrupti culpa veritatis
                                        quisquam. Neque necessitatibus illo rerum eum ut. Commodi ipsam minima molestiae
                                        sed laboriosam a iste odio. Earum odit nesciunt fugiat sit ullam. Soluta et
                                        harum voluptatem optio quae</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-3.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-4">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Fuga dolores inventore laboriosam ut est accusamus laboriosam dolore</h3>
                                    <p class="font-italic">Totam aperiam accusamus. Repellat consequuntur iure voluptas
                                        iure porro quis delectus</p>
                                    <p>Eaque consequuntur consequuntur libero expedita in voluptas. Nostrum ipsam
                                        necessitatibus aliquam fugiat debitis quis velit. Eum ex maxime error in
                                        consequatur corporis atque. Eligendi asperiores sed qui veritatis aperiam quia a
                                        laborum inventore</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-4.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-5">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Est eveniet ipsam sindera pad rone matrelat sando reda</h3>
                                    <p class="font-italic">Omnis blanditiis saepe eos autem qui sunt debitis porro
                                        quia.</p>
                                    <p>Exercitationem nostrum omnis. Ut reiciendis repudiandae minus. Omnis recusandae
                                        ut non quam ut quod eius qui. Ipsum quia odit vero atque qui quibusdam amet.
                                        Occaecati sed est sint aut vitae molestiae voluptate vel</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-5.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Departments Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq">
        <div class="container">

            <div class="section-title">
                <?php
                if (isset($pagedata['frequently-asked-questions'])) {
                    echo $pagedata['frequently-asked-questions']['description'];
                }
                ?>
            </div>
            <?php
            //print_r($page_elements);
            ?>
            <div class="faq-list">
                <ul>

                    <?php    $i = 1;        foreach($page_elements as $pe_key=>$pe_val){ ?>
                    <li data-aos="fade-up">
                        <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse"
                                                                       href="#faq-list-<?php echo $i;?>"><?php echo $pe_val['element_name'];?>
                            <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-<?php echo $i; ?>" class="collapse" data-parent=".faq-list">
                            <p>
                                <?php echo $pe_val['element_value'];?>
                            </p>
                        </div>
                    </li>

                    <?php
                    $i++;
                    }            ?>

                </ul>
            </div>

        </div>
    </section> <!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact pt-0">
        <div class="container">

            <div class="section-title">
                <?php
                if (isset($pagedata['contact'])) {
                    echo $pagedata['contact']['description'];
                }
                ?>
            </div>
        </div>

        <div>
            <iframe style="border:0; width: 100%; height: 350px;"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                    frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="container">
            <div class="row mt-5">

                <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <i class="icofont-google-map"></i>
                            <h4>Location:</h4>
                            <p>A108 Adam Street, New York, NY 535022</p>
                        </div>

                        <div class="email">
                            <i class="icofont-envelope"></i>
                            <h4>Email:</h4>
                            <p>info@doctored.com</p>
                        </div>

                        <div class="phone">
                            <i class="icofont-phone"></i>
                            <h4>Call:</h4>
                            <p>+91 98XXXXXXXX</p>
                        </div>

                    </div>

                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

            <!-- <input type="hidden" value="{{ csrf_token() }}" id="pagecsrf">-->
                <div class="col-lg-8 mt-5 mt-lg-0">
                    <form id="post-form" method="post" action="javascript:void(0)">
                        @csrf

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" id="firstname" placeholder="First Name"
                                       name="firstname" value="">

                                <span class="text-danger p-1">{{ $errors->first('firstname') }}</span>

                            </div>

                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" id="lastname" placeholder="Last Name"
                                       name="lastname" value="">

                                <span class="text-danger p-1">{{ $errors->first('lastname') }}</span>

                            </div>


                        </div>
                        <div class="form-row">

                            <div class="col-md-6  form-group">
                                <input type="text" class="form-control" placeholder="Email" name="email" value="">

                                <span class="text-danger p-1">{{ $errors->first('email') }}</span>

                            </div>
                            <div class="col-md-2  form-group">
                                <select class="phonecode pc form-control" name="phonecode"> </select>


                            </div>
                            <div class="col-md-4  form-group">
                                <input type="text" name="phonenumber" id="phonenumber" class="form-control pc"
                                       placeholder="Phone number">
                                <input type="hidden" name="phone" class="phone" class="form-control"
                                       placeholder="Phone number">

                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="description" data-rule="required" rows="6"
                                      name="description" placeholder="Message"></textarea>
                            <span class="text-danger p-1">{{ $errors->first('description') }}</span>


                        </div>
                        <div class="mb-3">
                            <div class="alert alert-success d-none" id="msg_div">
                                <span id="res_message"></span>
                            </div>
                            <!--   <div class="loading">Loading</div>
                               <div class="error-message"></div>
                               <div class="sent-message">Your message has been sent. Thank you!</div>
                               -->
                        </div>
                        <div class="text-center">
                            <button class=" btn btn-success" id="send_form" type="submit">Send Message</button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .ui-autocomplete-category {
            font-weight: bold;
            padding: .2em .4em;
            margin: .8em 0 .2em;
            line-height: 1.5;
            font-family: "Open Sans", sans-serif;
            color: #214214;
            text-transform: capitalize;


        }

        .ui-menu-item-wrapper {
            font-size: 14px;
            font-family: "Open Sans", sans-serif;
            text-transform: capitalize;

        }

        .error {
            color: red;
            font-size: 12px;
            font-family: "Open Sans", sans-serif;
            text-transform: capitalize;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="/frontend/locate.js"></script>

    <script type="text/javascript">
        jQuery.validator.addMethod("lettersandnumbersonly", function (value, element) {
            return this.optional(element) || /^([a-zA-Z ]{3,16})+$/i.test(value);
        }, "Only letters,numbers and  spaces are allowed");
        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
        }, "Only letters and spaces are allowed");
        jQuery.validator.addMethod("numbersonly", function (value, element) {
            return this.optional(element) || /^([0-9])+$/i.test(value);
        }, "Only letters and spaces are allowed");
        if ($("#post-form").length > 0) {
            $("#post-form").validate({

                rules: {
                    firstname: {
                        required: true,
                        lettersandnumbersonly: true,
                        minlength: 3,
                        //regex: '/^([a-zA-Z]{3,16})$/'

                        maxlength: 10
                    },
                    lastname: {
                        lettersonly: true,
                        //regex: '/^([a-zA-Z]{3,16})$/'

                        maxlength: 10
                    },
                    description: {
                        required: true,
                        lettersandnumbersonly: true,
                        maxlength: 250
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phonenumber: {
                        required: true,
                        numbersonly: true,
                        minlength: 10,
                        maxlength: 12
                    }
                },
                messages: {
                    firstname: {
                        required: "Please Enter Name",
                        maxlength: "Your last name maxlength should be 50 characters long."
                    },
                    description: {
                        required: "Please Enter description",
                        maxlength: "Your last description maxlength should be 250 characters long."
                    },
                    email: {
                        required: "Please Enter Email",
                        email: "Your email format is invalid"
                    },
                    phonenumber: {
                        required: "Please Enter Phone numner",
                        numbersonly: "Phone number format is invalid",
                        minlength: "Phone number should be 10 numbers",
                        maxlength: "Phone number should be less than 12"
                    },
                },
                submitHandler: function (form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }
                    });
                    $('#send_form').html('Sending..');
                    $.ajax({
                        url: '/homecontactsave',
                        type: "POST",
                        data: $('#post-form').serialize(),
                        success: function (response) {
                            $('#send_form').html('Submit');
                            $('#res_message').show();
                            $('#res_message').html(response.msg);
                            $('#msg_div').removeClass('d-none');

                            document.getElementById("post-form").reset();
                            setTimeout(function () {
                                $('#res_message').hide();
                                $('#msg_div').hide();
                            }, 10000);
                        }
                    });
                }
            })
        }
        $(document).ready(function () {
            $('.phone').val("+" + $('.phonecode').val() + "-" + $('#phonenumber').val());
            $(".pc").on("change keyup paste blur", function () {
                var phonenumbess = "+" + $('.phonecode').val() + "-" + $('#phonenumber').val();
                $('.phone').val(phonenumbess);
                //$('.phonetext').html(phonenumbess);
            });
        });
    </script>




@endsection
