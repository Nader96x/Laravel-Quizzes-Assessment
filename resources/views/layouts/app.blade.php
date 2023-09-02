<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css')}}" />
{{--    <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.13.6/css/dataTables.jqueryui.min.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css')}}" />--}}
    @stack('styles')

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="#">Quizzes App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item" @class([
                    'active' => request()->routeIs('exams.index')
                ])>
                    <a class="nav-link" href="{{route("exams.index")}}">Exams</a>
                </li>
                @role('admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{route("quizzes.index")}}">Quizzes</a>
                </li>
                @endrole

                <li class="nav-item">


                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link" >{{ __('Logout') }}</button>
                    </form>
                </li>
            </ul>
                    @else
                <ul class="navbar-nav ml-auto"> <!-- This ul is for right-aligned items -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("login") }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("register") }}">Register</a>
                    </li>
                </ul>
                     @endauth

        </div>
    </nav>
    <div id="app">
{{--           @include('partials.navbar')--}}
        <main class="py-4">
            @yield('content')
        </main>
    </div>


    @stack('scripts')
{{--    <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js')}}"></script>--}}
{{--    <script src="{{asset('https://cdn.datatables.net/1.13.6/js/dataTables.jqueryui.min.js')}}"></script>--}}
{{--    <script src="{{asset('https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js')}}"></script>--}}
{{--    <script src="{{asset('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js')}}"></script>--}}
{{--    <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js')}}"></script>--}}
</body>
</html>
