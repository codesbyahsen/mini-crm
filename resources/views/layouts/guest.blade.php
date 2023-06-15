<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <title> @yield('title') | Mini-CRM</title>

    <link rel="stylesheet" href="{{ asset('css/dashlite.min.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main -->
        <div class="nk-main ">
            <!-- wrap -->
            <div class="nk-wrap nk-wrap-nosidebar">
                @yield('page-content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
