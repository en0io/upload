<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/app.css">

    <title>en0 Upload</title>

    <link href="/fonts/font.css" rel="stylesheet">

    <style>
        .container {
            padding: 4em;
        }

        html, body {
            background-color: #343a40;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 85vh;
            margin: 0;
        }

        .card {
            background-color: #1A1F24;
        }

        .heightcontainer {
            height: 60vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .subtitle {
            font-size: 42px;
        }

        .links > a {
            color: #fff;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .copylink {
            cursor: pointer;
            color: dodgerblue;
        }

    </style>
    @yield('style')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">
        en0 Upload
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        {{--        <ul class="navbar-nav mr-auto">--}}
        {{--            <li class="nav-item">--}}
        {{--                <a class="nav-link" href="/index.php">Home</a>--}}
        {{--            </li>--}}
        {{--        </ul>--}}
        @auth

            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        @endauth

    </div>
</nav>

<div class="container">

    @yield('content')

    <hr>
    <footer class="flex-center">
        <a class="text-muted" href="mailto:contact@en0.io">contact@en0.io</a>
    </footer>
</div>



<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
@auth
    <script src="/js/filemanager.js"></script>
@endauth
</body>
</html>
