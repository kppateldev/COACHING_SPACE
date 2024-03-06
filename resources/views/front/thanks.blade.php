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
            <h1 class="title-main-lg mb-1">Coaching Space</h1>
            @include('front.includes.flash-message')
        </div>
    </div>
</div>
</div>
</div>
</div>
@stop