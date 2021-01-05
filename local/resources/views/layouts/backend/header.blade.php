<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ \App\Models\Setting::getName() ? \App\Models\Setting::getName() :config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{asset('backend/assets/images/icon/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/slicknav.min.css')}}">
    <!-- others css -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/responsive.css')}}">
    @yield('style')
    <!-- modernizr css -->
    <script src="{{asset('backend/assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @php($favicon = \App\Models\Setting::getFavicon())
    @if($favicon)
    <link rel="shortcut icon" type="image/png" href="{{asset('images/'.$favicon)}}">
    @else
    <link rel="shortcut icon" type="image/png" href="{{asset('/backend/assets/images/icon/favicon.png')}}">
    @endif

</head>

<body>

    @include('layouts.backend.preloader')