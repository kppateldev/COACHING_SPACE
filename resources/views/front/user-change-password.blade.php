@extends('front.app.index')
@section('css') @stop
@section('content')
@include('front.app.sidebar')
<section class="main-body-wrapper">
    <div class="topbar-main py-4">
      <div class="row align-items-center">
        <div class="col-md-12">
          <div class="topbar-col-left me-md-4">
            <h1 class="title-main-md mb-md-0">Change Password</h1>
        </div>
    </div>
</div>
</div>
<div class="content-inner-wrapper">
  <div class="row">
    <div class="col-lg-5">
      <div class="my-profile-form">
        @include('front.includes.flash-message')
        {!! Form::open(['url'=>url('user-change-password'), 'id'=>'user-change-password-form']) !!}
          <div class="form-group">
            <label class="form-label">Current Password</label>
            <div class="position-relative pass-view-box">
              <input type="password" class="form-control password" name="password" placeholder="Enter current password">
              <i class="fa-solid fa-eye-slash toggle-password position-absolute end-0 top-0 mt-3 me-4 lh-20"></i>
          </div>
      </div>
      <div class="form-group">
        <label class="form-label">New Password</label>
        <div class="position-relative pass-view-box">
          <input type="password" class="form-control password" name="new_password" id="new_password" placeholder="Enter new password">
          <i class="fa-solid fa-eye-slash toggle-password position-absolute end-0 top-0 mt-3 me-4 lh-20"></i>
      </div>
  </div>
  <div class="form-group">
    <label class="form-label">Confirm New Password</label>
    <div class="position-relative pass-view-box">
      <input type="password" class="form-control password" name="new_password_confirmation" placeholder="Enter confirm new password">
      <i class="fa-solid fa-eye-slash toggle-password position-absolute end-0 top-0 mt-3 me-4 lh-20"></i>
  </div>
</div>
<div class="">
    <button type="submit" class="btn btn-main-primary mw-btn-185">Submit</button>
</div>

</form>
</div>
</div>
</div>
</div>
</section>
@stop
@section('js')
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    $(function() {
      $.validator.addMethod("pwcheck", function(value) {
        return /^.*(?=.{9,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[-@_$!#%]).*$/.test(value) // consists of only these
        && /[a-z]/.test(value) // has a lowercase letter
        && /\d/.test(value) // has a digit
      });

        $("#user-change-password-form").validate({
            rules: {
                password: {
                    required: true
                },
                new_password: {
                    required: true,
                    pwcheck: true,
                },
                new_password_confirmation: {
                    required: true,
                    equalTo : "#new_password"
                },
            },
            messages: {
                password: {
                    required: "Please enter current password.",
                },
                new_password: {
                    required: "Please enter new password.",
                    pwcheck: "Password must contain at least 9 characters, including uppercase, lowercase, special character and numbers.",
                },
                new_password_confirmation: {
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
@stop