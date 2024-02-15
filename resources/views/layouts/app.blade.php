<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/js/app.js'])

    @yield('css')
</head>
<body>
<div id="app">
    {{--    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('schedules.index') }}">{{ __('Schedules') }}</a>
                        </li>
                    @endauth
                    <x-admin-routes/>
                    <x-passenger-routes/>
                    <x-guest-routes/>
                    @hasanyrole('driver|conductor')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('my-schedule') }}">
                            My schedule
                        </a>
                    </li>
                    @endhasanyrole
                    <x-about-us-routes/>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact-us') }}">
                            Contact Us
                        </a>
                    </li>
                    <x-logout-route/>
                </ul>
            </div>
        </div>
    </nav>

    <noscript>
        <x-noscript/>
    </noscript>

    <main class="py-4">
        {{ $slot }}
    </main>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

@jquery
@yield('javascript')
</body>
</html>
