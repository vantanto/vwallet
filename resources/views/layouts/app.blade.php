<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta5
* @link https://tabler.io
* Copyright 2018-2022 The Tabler Authors
* Copyright 2018-2022 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<!DOCTYPE html>
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
    <link href="{{ asset("Tabler/dist/css/demo.min.css") }}" rel="stylesheet" />
    @yield('style')
</head>

<body>
    <div class="wrapper">
        @include('layouts.navigation')
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page Heading -->
                @if (isset($header))
                <div class="page-header d-print-none">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                {{ $header }}
                            </h2>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <!-- Content here -->
                    {{ $slot }}
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset("Tabler/dist/js/tabler.min.js") }}"></script>
    @yield('script')
</body>

</html>