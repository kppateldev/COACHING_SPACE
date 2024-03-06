  @extends('front.app.index')
  @section('css') @stop
  @section('content')
  <!-- Header only if user not logged in -->
  <header class="header-main-two header-before position-relative">
    <div class="container">
      <div class="site-logo"><a href="{{ url('login')}}"><img src="{{ url('front_assets/images/logo_final.png')}}"></a></div>
    </div>
  </header>
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
              <h1 class="title-main-lg mb-1 text-center">Login Verification</h1>
              @include('front.includes.flash-message')
              <p class="subtitle-main mb-4 login-subtitle">Enter your verification code to access your account.</p>
              {!! Form::open(['url'=>url('post-verification'), 'id'=>'loginForm']) !!}
              <input type="hidden" name="user_id" value="{{ $user_id }}">
              <div class="form-group">
                <!-- <label class="form-label">Email Address</label> -->
                <div class="position-relative pass-view-box">
                  <input type="text" name="otp" class="form-control" placeholder="Verification Code" maxlength="6">
                </div>  
              </div>
              <div class="mt-3">
                <button type="submit" class="btn btn-main-primary w-100">Submit</button>
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
  <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
  <script type="text/javascript">
    $(function() {
      $("#loginForm").validate({
        rules: {
          otp: {
            required: true,
            digits:true,
          },
        },
        messages: {
          otp: {
            required: "Please enter a verification code."
          }
        },
        submitHandler: function(form) {
          form.submit();
          $('.sub-loader').show();
        }
      });
    });
  </script>
  @stop