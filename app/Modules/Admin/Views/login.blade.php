@extends('Admin::layouts.login')
@section('content')
<div class="page-login-main">
    <div class="brand hidden-md-up">
        <img class="brand-img" src="/material/base/assets/images/logo-colored@2x.png" alt="...">
        <h3 class="brand-text font-size-40">Remark</h3>
    </div>
    <h3 class="font-size-24">Sign In</h3>
    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p> -->
    <?php // echo "<pre>";print_R($errors->all());die; ?>
    @if($errors->any() && $errors->first() == 'Invalid Credentials')
    <div class="alert dark alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 clas="error">{{$errors->first()}}</h4> 
    </div>
    @endif

    <form method="post" action="/admin/login_submit">
        <!--@method('POST')-->
        <!--{{ csrf_field() }}-->
        <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="email" class="form-control empty" id="inputEmail" name="email">
            <label class="floating-label" for="inputEmail">Email</label>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="password" class="form-control empty" id="inputPassword" name="password">
            <label class="floating-label" for="inputPassword">Password</label>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group clearfix">
            <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
                <input type="checkbox" id="remember" name="checkbox">
                <label for="inputCheckbox">Remember me</label>
            </div>
            <a class="float-right" href="/admin/forgotpassword">Forgot password?</a>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
    </form>

          <!-- <p>No account? <a href="register-v2.html">Sign Up</a></p> -->

    <footer class="page-copyright">
      <!-- <p>WEBSITE BY Creation Studio</p> -->
        <p>© Doctored.</p>

    </footer>
</div>

</div>
@endsection