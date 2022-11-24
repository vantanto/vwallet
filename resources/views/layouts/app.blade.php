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
    <meta name="url-current" content="{{ url()->current() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link href="{{ asset("Tabler/dist/css/tabler.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("Tabler/dist/css/tabler-flags.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("Tabler/dist/css/tabler-vendors.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("Tabler/dist/css/demo.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("assets/css/custom.css") }}" rel="stylesheet" />
    @yield('style')
</head>

<body>
    <script src="{{ asset("Tabler/dist/js/demo-theme.min.js?1668287865") }}"></script>
    <div class="page">
        @include('layouts.navigation')
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page Heading -->
                @if (isset($header))
                <div class="page-header d-print-none">
                    <div class="row align-items-center">
                        {{ $header }}
                    </div>
                </div>
                @endif

                {{-- Session Alert --}}
                <x-session-alert />
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.10/dist/sweetalert2.all.min.js" integrity="sha256-JnFqDPNKmYEQ94Z89eewUGw4ms17pi7g2QuwV2DpJRY=" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Tabler Core -->
    <script src="{{ asset("Tabler/dist/js/tabler.min.js") }}"></script>
    <script src="{{ asset("assets/js/custom.js") }}"></script>
    
    <script>
        const settingsTomSelect = {
            copyClassesToDropdown: false,
    		dropdownClass: 'dropdown-menu ts-dropdown',
    		optionClass:'dropdown-item',
    		controlInput: '<input>',
    		render:{
    			item: function(data,escape) {
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    			option: function(data,escape){
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    		},
    	};
    </script>
    @yield('script')
</body>

</html>