<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <title> @yield('title') | Mini-CRM</title>

    @vite(['resources/css/dashlite.css', 'resources/css/theme.css', 'resources/js/bundle.js', 'resources/js/scripts.js'])
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
</body>

</html>
