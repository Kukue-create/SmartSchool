<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartSchool Zimbabwe') · Seke 1 High School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-ssz sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ auth()->check() || session('is_system_admin') ? url('/dashboard') : url('/') }}">
            🎓 SmartSchool Zimbabwe
            <small>Seke 1 High School</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navSSZ">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navSSZ">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('notices.index') }}">Notices</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('timetables.index') }}">Timetables</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('library.index') }}">Library</a></li>

                    @if(auth()->user()->isStudent())
                        <li class="nav-item"><a class="nav-link" href="{{ route('results.mine') }}">My Results</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fees.mine') }}">My Fees</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('attendance.mine') }}">My Attendance</a></li>
                    @endif

                    @if(auth()->user()->isTeacher())
                        <li class="nav-item"><a class="nav-link" href="{{ route('results.manage') }}">Marks</a></li>
                        @if(auth()->user()->teacher?->is_class_teacher)
                            <li class="nav-item"><a class="nav-link" href="{{ route('attendance.manage') }}">Attendance</a></li>
                        @endif
                    @endif

                    @if(auth()->user()->isSchoolAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Admin</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('directory.students') }}">Students</a></li>
                                <li><a class="dropdown-item" href="{{ route('directory.teachers') }}">Teachers</a></li>
                                <li><a class="dropdown-item" href="{{ route('fees.manage') }}">Fees</a></li>
                                <li><a class="dropdown-item" href="{{ route('enrollment.index') }}">Enrollment</a></li>
                                <li><a class="dropdown-item" href="{{ route('results.all') }}">All Results</a></li>
                            </ul>
                        </li>
                    @endif

                    <li class="nav-item ms-lg-2">
                        <span class="pill-ssz">{{ ucfirst(str_replace('_',' ',auth()->user()->role)) }}: {{ auth()->user()->full_name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="ms-lg-2">
                            @csrf
                            <button class="btn btn-ssz-accent btn-sm">Logout</button>
                        </form>
                    </li>
                @elseif(session('is_system_admin'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('system-admin.dashboard') }}">Owner Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('system-admin.users.index') }}">Manage Users</a></li>
                    <li class="nav-item">
                        <form action="{{ route('system-admin.logout') }}" method="POST" class="ms-lg-2">
                            @csrf
                            <button class="btn btn-ssz-accent btn-sm">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    @if(session('status'))
        <div class="alert alert-success shadow-sm">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Please fix the following:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<footer class="footer-ssz text-center">
    <div class="container">
        <p class="mb-2">
            <a href="{{ route('about') }}" class="text-ssz-footer-link me-3">About</a>
            <a href="{{ route('contact') }}" class="text-ssz-footer-link me-3">Contact</a>
            <a href="{{ route('enrollment.create') }}" class="text-ssz-footer-link">Apply Online</a>
        </p>
        <p class="mb-0">SmartSchool Zimbabwe &middot; Seke 1 High School &copy; {{ date('Y') }}</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
