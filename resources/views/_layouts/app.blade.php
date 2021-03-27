<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="theme-color" content="{{ config('theme_color') }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{ config('theme_color') }}">
    <meta name="msapplication-navbutton-color" content="{{ config('theme_color') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title')</title>

    @include('_layouts.styles')

</head>

<body>

    <div id="body">

        @include('_layouts.header')
        @include('_layouts.sidebar')

        <div id="main">
            <div class="container">
                @section('container')
                    {{-- <pre> {{ print_r(session()->all()) }}</pre> --}}
                    @yield('content')
                @show
            </div>
        </div>

    </div>

    <div id="btn_log"
        style="position: absolute; z-index: 9999; bottom: 0; right: 0;height: 100%; top: 0; display: flex; align-items: center;">
        <button type="button" class="btn waves-effect blue" id="shell_exec"
            style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">
            <i class="material-icons">code</i>
        </button>
    </div>

    <div id="log"
        style="background: rgba(0, 0, 0, 0.8); width: 100%; height: 100px; border: 1px solid #ccc; position: absolute; fixed; bottom: 0;z-index: 9999; right: 0; color: #fff !important; display:none; overflow-y: scroll;">
        <div id="console" style="position: relative; overflow: hidden; padding: 15px;"></div>
    </div>

    @include('_layouts.scripts')

</body>

</html>
