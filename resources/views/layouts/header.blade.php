<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{url('js/jquery-3.1.0.min.js')}}"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="justify-content-center navbar navbar-expand-md navbar-light shadow-sm">
        <a class="navbar-brand text-light" href="{{ url('/') }}">
            Qr Code Processor
        </a>
    </nav>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-black-50 fs-5">
                            <a class="text-decoration-none text-black-50" href="{{route('home')}}">Generate Qr Code </a>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <a class="text-decoration-none text-black-50" href="{{route('scan')}}">Scan Qr Code </a>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
