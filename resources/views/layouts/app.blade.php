<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="{{asset('dist/icons/bootstrap-icons-1.4.0/bootstrap-icons.min.css')}}" type="text/css">
    <!-- Bootstrap Docs -->
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap-docs.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('dist/icons/font-awesome/css/font-awesome.min.css')}}" type="text/css">


    <!-- custom -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">


    <!-- Main style file -->
    <link rel="stylesheet" href="{{asset('dist/css/app.min.css')}}" type="text/css">

    @stack('style')
</head>

<body>

<!-- preloader -->
<div class="preloader">
    <img src="{{asset('/assets/images/loader.avif')}}" alt="logo">

    <div class="preloader-icon"></div>
</div>

<!-- layout-wrapper -->
<div class="layout-wrapper">

    <div class="alert alert-danger mt-3" role="alert" style="display: none;">

    </div>


    <!-- Alerts for success or error messages -->
    @if (session('error'))
        <div class="alert alert-danger mt-3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- header -->
    <div class="header">
        <div class="menu-toggle-btn">
            <!-- Menu close button for mobile devices -->
            <a href="#">
                <i class="bi bi-list"></i>
            </a>
        </div>
        <!-- Logo -->
        <a href="index.html" class="logo">
            <img width="100" src="../../assets/images/logo.svg" alt="logo">
        </a>
        <!-- ./ Logo -->
        <div class="page-title">{{$title ?? '--'}}</div>

        <div class="header-bar ms-auto">
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item">
                    @if($title == 'Puzzle')
                        <a href="{{ route('puzzle.leader') }}" class="nav-link">
                            <i class="bi bi-graph-up icon-lg">Leader Board</i>
                        </a>
                    @else
                        <a href="{{ route('dashboard.index') }}" class="nav-link">
                            <i class="bi bi-puzzle icon-lg">Puzzle</i>
                        </a>
                    @endif
                </li>
                <li>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                            <div class="avatar me-3">
                                @if(Auth::User()->profile_url)
                                    <img width="100" class="rounded-pill" src="{{asset(Auth::User()->profile_url)}}">
                                @else
                                    <img width="100" class="rounded-pill" src="{{asset('/assets/images/user.png')}}">
                                @endif
                            </div>
                            <div>
                                <div class="fw-bold">{{Auth::user()->name}}</div>
                                <small class="text-muted">{{Auth::user()->email}}</small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">

                            <a class="dropdown-item" href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i
                                        class="bi bi-box-arrow-right dropdown-item-icon"></i>{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
                @stack('action')
            </ul>
        </div>
        <!-- Header mobile buttons -->
        <div class="header-mobile-buttons">

        </div>
        <!-- ./ Header mobile buttons -->
    </div>
    <!-- ./ header -->
    <!-- content -->
    @yield('contents')
    <!-- ./ content -->
    <!-- content-footer -->
    @include('layouts.footer')
    <!-- ./ content-footer -->
</div>

<!-- ./ layout-wrapper -->

<!-- Bundle scripts -->
<script src="{{asset('lib/bundle.js')}}"></script>

<!-- Main Javascript file -->
<script src="{{asset('dist/js/app.min.js')}}"></script>


<!--  sweet alert -->
<script src="{{asset('dist/js/examples/sweetalert.min.js')}}"></script>

@stack('script')


</body>

</html>
