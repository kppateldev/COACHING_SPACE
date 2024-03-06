<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ get_settings('favicon') ? asset('uploads/'.get_settings('favicon')) : asset('favicon.ico') }}"/>
  <title>{{get_settings('site_name') ?? 'Site Title'}}</title>
  <!-- =============== VENDOR STYLES ===============-->
  <!-- FONT AWESOME-->
  <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fa-brands.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fa-regular.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fa-solid.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fontawesome.css')}}">
  <!-- SIMPLE LINE ICONS-->
  <link rel="stylesheet" href="{{asset('vendor/simple-line-icons/css/simple-line-icons.css')}}">
  <!-- ANIMATE.CSS-->
  <link rel="stylesheet" href="{{asset('vendor/animate.css/animate.css')}}">
  <!-- WHIRL (spinners)-->
  <link rel="stylesheet" href="{{asset('vendor/whirl/dist/whirl.css')}}">
  <!-- =============== PAGE VENDOR STYLES ===============-->
  <!-- WEATHER ICONS-->
  <link rel="stylesheet" href="{{asset('vendor/weather-icons/css/weather-icons.css')}}">
  <!-- =============== BOOTSTRAP STYLES ===============-->
  <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.css')}}" id="bscss">
  <!-- =============== APP STYLES ===============-->
  <link rel="stylesheet" href="{{asset('assets/admin/css/app.css')}}" id="maincss">
  <link rel="stylesheet" href="{{asset('assets/admin/css/toastr.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">
  <input type="hidden" name="admin_url" value="{{ url('/admin') }}" id="admin_url">
  <style type="text/css">
    .success a {
      text-decoration: none;
    }
  </style>
  @yield('header_styles')

</head>
