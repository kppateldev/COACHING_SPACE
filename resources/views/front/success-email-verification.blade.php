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
                    @include('front.includes.flash-message')
                    <div class="form-body text-center">
                        <h1 class="title-main-lg mb-1">Congratulations!</h1>
                        <p class="subtitle-main mb-4 login-subtitle">Your email address has been verified.</p>
                        <div class="form-group">
                            <a href="{{url('/login')}}" class="btn btn-main-primary w-100">Go to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop