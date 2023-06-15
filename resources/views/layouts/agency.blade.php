<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booker - Agency</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @stack('css')
    <style>
        /* Custom styles */
        body {
            background-color: #f8f9fa;
        }
        .side-nav {
            min-height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: #fff;
        }
        .side-nav .nav-link {
            padding: 10px 20px;
            color: #dee2e6;
        }
        .side-nav .nav-link:hover,
        .side-nav .nav-link:focus {
            background-color: #343a40;
            color: #fff;
        }
        .content {
            padding: 20px;
        }
        .navbar-brand {
            color: #343a40;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: #343a40;
        }
        .dropdown-menu {
            background-color: #fff;
        }
        .dropdown-item {
            color: #343a40;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Side Navigation -->
        <div class="col-lg-2 side-nav">
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agency.main_page') }}">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('show-applications')}}">Applications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('create-post') }}">New Post</a>
                </li>
                <li class="nav-item">
                    <hr class="dropdown-divider">
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col">
            <nav class="navbar navbar-expand-lg navbar-light bg-gray-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('agency.main_page') }}">Booker</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('agency.profile') }}">Profile</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@stack('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
