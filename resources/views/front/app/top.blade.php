<base href="{{ url('/') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{ url('front_assets/images/sidebar-logo.png') }}">
<link rel="icon" type="image/png" href="{{ url('front_assets/images/logo.png') }}">
@php
$SITE_NAME = config('app.name');
@endphp
@if( isset( $_meta_title ) && $_meta_title )
<title>{{$_meta_title}} :: {{$SITE_NAME}}</title>
@else
<title>@yield('title', $SITE_NAME)</title>
@endif  
@if( isset( $_meta_keyword ) && $_meta_keyword )
<meta name="keywords" content="{{$_meta_keyword}}">
@endif
@if( isset( $_meta_desc ) && $_meta_desc )
<meta name="description" content="{{$_meta_desc}}">
@endif 

<link rel="stylesheet" href="{{ url('front_assets/css/font-awesome-all.min.css') }}" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="{{ url('front_assets/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link  rel="stylesheet" href="{{ url('front_assets/font/stylesheet.css') }}">
<link  rel="stylesheet" href="{{ url('front_assets/font/icons/style.css') }}">
<link rel="stylesheet" href="{{ url('front_assets/css/style.css') }}">