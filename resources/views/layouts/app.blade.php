<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">

    <title>@yield('title')</title>

    @include('partials.links')
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
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

    @include('partials.scripts')
</body>

</html>
