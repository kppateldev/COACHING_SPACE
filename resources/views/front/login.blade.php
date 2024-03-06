  @extends('front.app.index')
  @section('css') @stop
  @section('content')
  <div class="main-body-content position-relative pb-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-left">
          <div class="body-col-left text-center">
            <img src="{{ url('front_assets/images/login.png') }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="body-col-right mt-5 mt-lg-0">
            <div class="form-body">
              <h1 class="title-main-lg mb-1 text-center">Login</h1>
              @include('front.includes.flash-message')
              <p class="subtitle-main mb-4 login-subtitle">Enter your credentials to access your account.</p>
              {!! Form::open(['url'=>url('login'), 'id'=>'loginForm']) !!}
              <div class="form-group">
                <!-- <label class="form-label">Email Address</label> -->
                <div class="position-relative pass-view-box">
                  <input type="email" name="email" class="form-control password" placeholder="Email Address" value="<?php if(isset($_COOKIE["cs_email"])) { echo $_COOKIE["cs_email"]; } ?>{{ old('email') }}">
                </div>  
              </div>
              <div class="form-group mb-2">
                <div class="position-relative pass-view-box">
                  <input type="password" name="password" class="form-control password" placeholder="Enter Password" value="<?php if(isset($_COOKIE["cs_password"])) { echo $_COOKIE["cs_password"]; } ?>">
                  <i class="fa-solid fa-eye-slash toggle-password position-absolute end-0 top-0 mt-3 me-4 lh-20"></i>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="mb-1 form-check p-0 d-inline-block">
                  <input type="checkbox" name="remember" class="form-check-input m-0 me-2" id="exampleCheck1" value="1" <?php if(isset($_COOKIE["cs_remember"])) { ?> checked <?php } ?>>
                  <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>
                <div class="mb-1"><a href="{{ url('forgotpassword') }}" class="forgot-pwd-link">Forgot Password?</a></div>
              </div>
              <div class="mt-3">
                <button type="submit" class="btn btn-main-primary w-100">Login</button>
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @stop
  @section('js')
  <script>
    $(".toggle-password").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      input = $(this).parent().find("input");
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
  <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
  <script type="text/javascript">
    $(function() {
      jQuery.validator.addMethod("noHTML", function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_!@"#$%&'()*+,-./]+)$/.test(value);
      }, "No HTML tags are allowed!");
      $("#loginForm").validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            noHTML:true
          },
        },
        messages: {
          email: {
            required: "Please enter a email address.",
            email: "Please enter a valid email address."
          },
          password: {
            required: "Please enter a password.",
          },
        },
        submitHandler: function(form) {
          form.submit();
          $('.sub-loader').show();
        }
      });
    });
  </script>
  @stop