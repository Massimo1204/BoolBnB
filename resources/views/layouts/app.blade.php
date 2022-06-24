<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="user-id" content="{{ Auth::user()->id }}">
    @endauth
    @guest
        <meta name="user-id" content="{{ null }}">
    @endguest

    <title>BoolBnb</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="{{ asset('js/front.js') }}" defer></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.13.0/maps/maps.css'>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li>

                            @if (!Auth::check())
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    BoolBnB
                                </a>
                            @else
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    BoolBnB
                                </a>
                            @endif
                                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                    <span class="navbar-toggler-icon"></span>
                                </button> --}}

                        </li>


                    </ul>

                    <!-- Center Side Of Navbar -->
                    <ul class="navbar-nav">
                        <li>
                            {{-- <div class="input-group">
                                <div class="form-outline">
                                    <input id="search-focus" type="search" id="form1" class="form-control" />
                                </div>
                                <button type="button" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                                </button>
                            </div> --}}
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle border border-light rounded-pill my-2 shadow"
                                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Area Riservata
                                </a>

                                <div class="dropdown-menu dropdown-menu-end border-0 shadow pt-3 position-absolute"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        {{ __('Registrati') }}
                                    </a>
                                </div>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle border border-light rounded-circle my-2 shadow myNav-dropdown p-0"
                                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{-- @dd(Auth::user()->profile_picture) --}}
                                    @if (str_starts_with(Auth::user()->profile_picture, 'https://') || str_starts_with(Auth::user()->profile_picture, 'http://'))
                                        <div class="PF-container rounded-circle">
                                            <img class="rounded-circle" src="{{Auth::user()->profile_picture}}" alt="{{  ucfirst(Auth::user()->first_name) . ' ' . ucfirst(Auth::user()->last_name) }}">
                                        </div>
                                    @else
                                        <div class="PF-container">
                                            <img class="rounded-circle" src="{{ asset('/storage') . '/' . Auth::user()->profile_picture }}" alt="{{  ucfirst(Auth::user()->first_name) . ' ' . ucfirst(Auth::user()->last_name) }}">
                                        </div>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end border-0 shadow pt-3"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{url('/apartment/messages/1')}}">
                                        {{ __('Messaggi') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('apartment.index') }}">
                                        {{ __('Gestisci gli annunci') }}
                                    </a>
                                    <hr>
                                    <a class="dropdown-item" href="{{ route('user.edit', Auth::id()) }}">
                                        {{ __('Account') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Esci') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    @yield('footer-scripts')

</body>

</html>
