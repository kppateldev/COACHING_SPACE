@extends('front.app.index')
@section('css') @stop
@section('content')
<div class="main-body-content position-relative pb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 col-left">
        <div class="body-col-left text-center">
            <img src="{{ url('front_assets/images/forgot-password.png') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="body-col-right mt-5 mt-lg-0">
          <div class="form-body">
            <h1 class="title-main-lg mb-1">Reset Password</h1>
            @include('front.includes.flash-message')

            {!! Form::open(['url'=>url('confirm-new-password'), 'id'=>'reset-password-form']) !!}
            <input type="hidden" name="id" value="{{$id ?? '0'}}">
            <div class="form-group">
                <label class="form-label">New Password</label>
                <div class="position-relative pass-view-box">
                    <input id="password" name="password" type="password" class="form-control form-rounded" placeholder="Enter your password">
                </div>  
            </div>
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="position-relative pass-view-box">
                    <input id="password_confirmation" name="confirmpassword" type="password" class="form-control form-rounded" placeholder="Enter your password">
                </div>  
            </div>
            <div class="mt-4">
              <button type="submit" class="btn btn-main-primary w-100">Update</button>
          </div>
          {!! Form::close() !!}

          <p class="mt-4">Already have an account?<a href="{{ url('login') }}" class="color-F46853"> Login</a></p>
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

        $.validator.addMethod("pwcheck", function(value) {
            return /^.*(?=.{9,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[-@_$]).*$/.test(value) // consists of only these
            && /[a-z]/.test(value) // has a lowercase letter
            && /\d/.test(value) // has a digit
        });

        $("#reset-password-form").validate({
            rules: {
                password: {
                    required: true,
                    pwcheck: true,
                },
                confirmpassword: {
                    required: true,
                    equalTo : "#password"
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
                    equalTo: "Please enter the same value again."
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