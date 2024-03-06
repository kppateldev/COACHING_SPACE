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
            <h1 class="title-main-lg mb-1">Forgot Password</h1>
            @include('front.includes.flash-message')
            <p class="subtitle-main mb-4">Enter your email and we'll send you a link to reset your password</p>
            {!! Form::open(['url'=>url('forgotpassword'), 'id'=>'forgot-password-form']) !!}
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="position-relative pass-view-box">
                  <input name="email" type="email" class="form-control form-rounded" placeholder="Enter Email">
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
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $("#forgot-password-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                email: {
                    required: "Please enter an email address.",
                    email: "Please enter a valid email address."
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