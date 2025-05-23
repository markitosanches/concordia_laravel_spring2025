<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="d-flex flex-column min-vh-100">
    
    <header>
        @php $locale = session()->get('locale') @endphp
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample03">
                  
                    <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('task.index')}}">@lang('Tasks')</a>
                        </li>
                        @can('view-users')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.index')}}">@lang('Users')</a>
                        </li>
                        @endcan
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">@lang('Tasks')</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('task.create')}}">@lang('New Task')</a></li>
                                <li><a class="dropdown-item" href="{{ route('task.completed', 1)}}">@lang('Completed')</a></li>
                                <li><a class="dropdown-item" href="{{ route('task.completed', 0)}}">@lang('Unfinished')</a></li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                    
                    <ul class="navbar-nav  mb-2 mb-sm-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">@lang('Language') {{ $locale == '' ? '(en)' : "($locale)"}}</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('lang', 'en')}}">@lang('English')</a></li>
                                <li><a class="dropdown-item" href="{{ route('lang', 'fr')}}">@lang('French')</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            @guest
                            <a class="nav-link" href="{{route('login')}}">@lang('Login')</a>
                            @else
                            <a class="nav-link" href="{{route('logout')}}">@lang('Logout')</a>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container flex-grow-1">
        
        @auth
            <p>@lang('lang.text_welcome'), {{ Auth::user()->name }} @role('Admin') - Admin @endrole</p>
        @else
            <p>@lang('lang.text_login_msg')</p>
        @endauth

        @if(session('success'))
        <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </div>
    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            &copy; {{ date('Y') }} {{ config('app.name') }}. @lang('lang.text_copryright')
        </div>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
</html>