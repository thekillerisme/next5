<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <b-navbar toggleable="md" :sticky="true" fixed="top" type="light" variant="default">
                <!-- Collapsed Hamburger -->
                <b-navbar-toggle target="app-navbar-collapse"></b-navbar-toggle>

                <!-- Branding Image -->
                <b-navbar-brand href="{{ url('/') }}"><h1>{{ config('app.name', 'Laravel') }}</h1></b-navbar-brand>

                <b-collapse is-nav id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <b-navbar-nav>&nbsp;</b-navbar-nav>

                    <!-- Right Side Of Navbar -->
                    <b-navbar-nav class="ml-auto"></b-navbar-nav>
                </b-collapse>
            </b-navbar>

            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/bootstrap.js') }}"></script>
        @yield('scripts')
    </body>
</html>
