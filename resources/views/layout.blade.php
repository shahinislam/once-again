<!doctype html>
<html lang="en">
<head>
    <title>@yield('title','Learning Laravel 5.8')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>

    <div class="container">
        @include('nav')

        @if(session()->has('message'))
            <div class="alert alert-success" role="alert">
                <strong>Success</strong> {{ session()->get('message') }}
            </div>
        @endif

        @yield('content')
    </div>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>