<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">

    <title>@yield('title')</title>

    @include('partials.links')
    {{-- @vite(['resources/css/dashlite.min.css', 'resources/js/jquery.js', 'resources/js/bundle.js', 'resources/js/scripts.js', 'resources/js/custom.js', 'resources/js/datatable-btns.js']) --}}
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    {{-- <div id="preloader">
        <img src="{{ asset('images/preloader.gif') }}" alt="loading">
    </div> --}}
    <div class="nk-app-root">
        <div class="nk-main ">
            @include('partials.sidebar')

            <div class="nk-wrap ">
                @include('partials.header')

                @yield('page-content')

                @include('partials.footer')
            </div>
        </div>
    </div>

    @yield('modals')

    {{-- Generate random password modal --}}
    <div class="modal fade" tabindex="-1" id="generate-password-modal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Password</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="get-random-password" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary" id="generate-password">Generate Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')
</body>

</html>
