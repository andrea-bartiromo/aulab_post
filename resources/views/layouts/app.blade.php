<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, #007bff, #6610f2);
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: white !important;
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
        }

        .dropdown-menu {
            background-color: #343a40;
        }

        .dropdown-menu .dropdown-item {
            color: white !important;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #007bff !important;
        }

        .alert {
            border-radius: 8px;
        }

        .footer {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-newspaper"></i> {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- Link Generali -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('articles.index') }}">
                            <i class="fas fa-book"></i> Articoli
                        </a>
                    </li>

                    <!-- Sezione per Utenti Autenticati -->
                    @auth
                        <!-- Se l'utente è un WRITER -->
                        @if(Auth::user()->is_writer)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('articles.create') }}">
                                    <i class="fas fa-pencil-alt"></i> Scrivi Articolo
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->is_writer)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('work.with.us') }}">
                                <i class="fas fa-briefcase"></i> Lavora con noi
                            </a>
                        </li>
                    @endif

                        <!-- Se l'utente è un REVISORE -->
                        @if(Auth::user()->is_revisor)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('revisor.dashboard') }}">
                                    <i class="fas fa-check-circle"></i> Revisione Articoli
                                </a>
                            </li>
                        @endif

                        <!-- Se l'utente è un ADMIN -->
                        @if(Auth::user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-user-shield"></i> Admin
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.jobApplications') }}">
                                    <i class="fas fa-file-alt"></i> Candidature
                                </a>
                            </li>
                        @endif

                        <!-- Se l'utente è un OWNER -->
                        @if(Auth::user()->is_owner)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('owner.dashboard') }}">
                                    <i class="fas fa-user-tie"></i> Proprietario
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('owner.jobApplications') }}">
                                    <i class="fas fa-file-alt"></i> Candidature
                                </a>
                            </li>
                        @endif

                        <!-- Dropdown Profilo Utente -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @else
                        <!-- Se l'utente NON è autenticato -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Registrati
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">

            <!-- Messaggi di Successo -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Messaggi di Errore -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Si sono verificati alcuni errori:
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} {{ config('app.name', 'Laravel') }} - Tutti i diritti riservati</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
