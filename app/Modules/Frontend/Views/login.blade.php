@extends('Frontend::layouts.frontend')
@section('content')
    <section class="inner-page">
        <div class="container">
            <div class="user-ragistration">
                <div class="container register">
                    <div class="row">
                        <div class="col-md-3 register-left">
                            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                            <h3>Welcome</h3>
                            <p>You are 30 seconds away to start your journey with us!</p>
                        </div>
                        <div class="col-md-9 register-right">
                            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                       aria-controls="home" aria-selected="true">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab"
                                       href="#profile" role="tab" aria-controls="profile"
                                       aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <h3 class="register-heading">Already Member, Please Login</h3>
                                    <div class="row register-form d-flex justify-content-center">
                                        <div class="col-md-6">
                                            <div class="col-12 d-flex justify-content-center">
                                                <?php
                                                $se = '';
                                                if (session()->get('tab_name_log') != '') {
                                                    $se = session()->get('tab_name_log');
                                                }
                                                ?>
                                                @if(Session::has('success'))
                                                    <div
                                                        class="alert alert-success"> {{ Session::get('success') }} </div> @endif

                                            </div>
                                            <form action="{{'/loginsubmit'}}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    @if(Session::has('error'))
                                                        <div
                                                            class="alert alert-danger">{{ Session::get('error') }}</div>
                                                    @endif
                                                    <div class="radiobuttons">
                                                        <div class="rdio rdio-primary radio-inline">

                                                            <input type="radio" name="Logintype" value="patient"
                                                                   id="Consultation" <?php  if ($se == 'pat_log' || $se == '') {
                                                                echo "checked";
                                                            }?>>

                                                            <label for="Consultation">Consultation</label>
                                                        </div>
                                                        <div class="rdio rdio-primary radio-inline">
                                                            <input type="radio" name="Logintype" value="doctor"
                                                                   id="Doctor" <?php if ($se == 'doc_log') {
                                                                echo "checked";
                                                            } ?>>

                                                            <label for="Doctor">Doctor</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" id="email_address" placeholder="Your Email *"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           name="email">
                                                    @error('email') <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" id="password" placeholder="Password *"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           name="password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <a href="forgot-password" class="small-text">Forgot Password?</a>
                                                </div>
                                                <div class="form-group text-center">
                                                    <input type="submit" class="btnRegister" value="Login"/>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="profile" role="tabpanel"
                                     aria-labelledby="profile-tab">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
