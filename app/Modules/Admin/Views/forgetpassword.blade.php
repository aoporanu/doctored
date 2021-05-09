@extends('Admin::layouts.login')
@section('content')




      

        <div class="page-login-main">
          <div class="brand hidden-md-up">
            <img class="brand-img" src="../material/base/assets/images/logo-colored@2x.png" alt="...">
            <h3 class="brand-text font-size-40">Remark</h3>
          </div>
          <h3 class="font-size-24">Forget Password</h3>
           @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
          
          <form method="post" action="{{ route('users.password.email') }}">
            <div class="form-group form-material floating" data-plugin="formMaterial">
              <input type="email" class="form-control empty" id="inputEmail" name="email">
              <label class="floating-label" for="inputEmail">Email</label>
            </div>
            <!-- <a class="float-right" href="/admin/login">Login</a> -->
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </form>

          <p><a class="float-right" href="/admin/login">Login</a></p>

          <footer class="page-copyright">
            <!-- <p>WEBSITE BY Creation Studio</p> -->
            <p>© Doctored.</p>
           
          </footer>
        </div>

      
@endsection