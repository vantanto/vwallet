<!DOCTYPE html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta5
* @link https://tabler.io
* Copyright 2018-2022 The Tabler Authors
* Copyright 2018-2022 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS files -->
    <link href="{{ asset("Tabler/dist/css/tabler.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("Tabler/dist/css/tabler-flags.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("Tabler/dist/css/tabler-payments.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("Tabler/dist/css/tabler-vendors.min.css") }}" rel="stylesheet" />
    @yield('style')
</head>

<body class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="/" class="navbar-brand navbar-brand-autodark">
                    {{ config('app.name') }}
                    {{-- <img src="./static/logo.svg" height="36" alt=""> --}}
                </a>
            </div>
            {{ $slot }}
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset("Tabler/dist/js/tabler.min.js") }}"></script>
    @yield('script')
</body>

</html>