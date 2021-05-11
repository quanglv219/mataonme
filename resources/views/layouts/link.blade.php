<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>{{ $user->name . ' (@' . $user->username . ') on ' . ($website->name ?? '') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!--<style>
        #app {
            background: -webkit-linear-gradient(to right, #334d50, #cbcaa5);
            background: linear-gradient(to right, #334d50, #cbcaa5);
            font-family: Roboto;
        }
    </style>-->
    @php
        $background = $user->customization->pageBackground;
        // Check if it is not a url
        if (! preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $background)) {
            $background = json_decode($user->customization->pageBackground)->colors;
            $firstColor = $background[0];
            $secondColor = $background[1];
            $background = "background: linear-gradient(45deg, " . $firstColor . ", " . $secondColor . ")";
        } else {
            $background = "background-image: url($background);background-size: cover;";
        }
    @endphp
    <style>
        #app {
            {{ $background }};
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div id="app">
        <v-app class="red">
            <v-main>
                <v-container fluid>
                    @yield('content')
                </v-container>
            </v-main>
        </v-app>
    </div>
</body>
</html>