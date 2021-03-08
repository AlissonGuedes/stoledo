<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="theme-color" content="<?= config('theme_color') ?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="<?= config('theme_color') ?>">
    <meta name="msapplication-navbutton-color" content="<?= config('theme_color') ?>">

    <title>@yield('title')</title>

    @include('layouts/styles')

</head>

<body>

    <div id="body">

		@include('layouts/header')

        @include('layouts/sidebar')

        <div id="main">
            @section('container')
                @yield('content')
            @show
        </div>

    </div>

    @include('layouts/scripts')

</body>

</html>
