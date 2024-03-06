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
          <div class="form-body col-lg-5 thank-you-box col-md-6">
            <h1 class="title-main-lg mb-1 text-center">Page Not Found</h1>
            @include('front.includes.flash-message')
            <h2>Oops,</h2>
            <p class="subtitle-main mb-4 login-subtitle">Sorry, the page you are looking for could not be found.</p>
            <div class="text-center mt-4">
              <a href="{{ url('login')}}"><button class="btn btn-main-primary w-100">Go to Login</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop