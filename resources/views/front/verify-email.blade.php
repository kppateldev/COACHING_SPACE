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
                        <h1 class="title-main-lg mb-1 text-center">Verify Email</h1>
                        @include('front.includes.flash-message')
                        <p class="subtitle-main mb-4 login-subtitle">We Have Sent An Email To Your Email Address! <br>Please Check Your Email In Order To Proceed</p>
                        {!! Form::open(['url'=>url('resend-email'), 'id'=>'resend_email']) !!}
                        <div class="form-group">
                            <input type="hidden" name="token" id="token" value="{{ $token }}">
                            <button type="submit" class="btn btn-main-primary w-100" id="resend_email_btn">Resend email </button>
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
    $(function() {
        $("#resend_email").submit(function(e){
            $(".main-loader").show();
        });
    })
</script>
@stop