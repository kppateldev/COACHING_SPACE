    @extends('front.app.index')
    @section('css') @stop
    @section('content')
    <header class="header-main-two header-before position-relative">
      <div class="container">
        <div class="site-logo"><a href="#"><img src="{{ url('front_assets/images/logo.png') }}"></a></div>
      </div>
    </header>
    <div class="main-body-content position-relative pb-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 col-left">
            <div class="body-col-left text-center">
              <img src="{{ url('front_assets/images/login-bg.png') }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="body-col-right mt-5 mt-lg-0">
              <div class="form-body">
                <h1 class="title-main-lg mb-1">Change Password</h1>
                @include('front.includes.flash-message')
                <p class="subtitle-main mb-4">You need to change the password when you login to website for first time .</p>
                {!! Form::open(['url'=>url('update-change-password'), 'id'=>'chagepasswordForm']) !!}
                  <div class="form-group">
                    <label class="form-label">New Password</label>
                    <div class="position-relative pass-view-box">
                      <input type="password" class="form-control password" name="password" id="password" placeholder="Enter new password">
                      <i class="fa-solid fa-eye-slash toggle-password position-absolute end-0 top-0 mt-3 me-4 lh-20"></i>
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <div class="position-relative pass-view-box">
                      <input type="password" class="form-control password" name="confirmpassword" placeholder="Enter connfirm new password">
                      <i class="fa-solid fa-eye-slash toggle-password position-absolute end-0 top-0 mt-3 me-4 lh-20"></i>
                      <!-- <span class="position-absolute end-0 top-0 mt-3 me-4 lh-26"><i class="fa-solid fa-eye-slash eye"></i></span> -->
                    </div>
                  </div>
                  <div class="mt-4">
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
    $.validator.addMethod("pwcheck", function(value) {
        return /^.*(?=.{9,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[-@_$!#%]).*$/.test(value) // consists of only these
        && /[a-z]/.test(value) // has a lowercase letter
        && /\d/.test(value) // has a digit
    });
    jQuery.validator.addMethod("noHTML", function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_!@"#$%&'()*+,-./]+)$/.test(value);
      }, "No HTML tags are allowed!");
    $("#chagepasswordForm").validate({
      rules: {
        password: {
          required: true,
          pwcheck: true,
          noHTML:true
        },
        confirmpassword: {
          required:true,
          equalTo : "#password",
          noHTML:true
        },
      },
      messages: {
        password: {
          required: "Please enter new password.",
          pwcheck: "Password must contain at least 9 characters, including uppercase, lowercase, special character and numbers.",
        },
        confirmpassword: {
          required: "Please enter confirm new password.",
          pwcheck: "Password must contain at least 9 characters, including uppercase, lowercase, special character and numbers.",
          equalTo: "Please retype same as new password."
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