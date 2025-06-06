<!DOCTYPE html>
<html lang="fr" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMSP – Gestion des Séminaires</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs"  defer></script>
    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Configuration personnalisée Tailwind --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'soft-lavender': '#f0e6ff', 
                        'gentle-mint': '#e0f7e6',
                        'deep-lilac': '#8a4fff',
                        'misty-rose': '#fce4ec',
                        'soft-violet': '#d8c0ff',
                        'light-periwinkle': '#e6e6ff',
                        'soft-gray': '#f9f9fb',
                        'dark-purple': '#3a2e6d',
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 18px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f0e6ff 0%, #e0f7e6 100%);
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
            color: #4a4a6a;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 70;
            height: 70px;
            display: flex;
            align-items: center;
        }

        .nav-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: #8a4fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            color: #8a4fff;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            font-size: 1.4rem;
            color: #3a2e6d;
            padding: 8px;
            border-radius: 10px;
            background: rgba(138, 79, 255, 0.1);
            transition: var(--transition);
        }

        .hamburger:hover {
            background: rgba(138, 79, 255, 0.2);
        }

        /* User dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            border-radius: 14px;
            background: rgba(138, 79, 255, 0.1);
            color: #3a2e6d;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
        }

        .user-btn:hover {
            background: rgba(138, 79, 255, 0.2);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8a4fff 0%, #6c2fff 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .dropdown-menu {
            position: absolute;
            top: 120%;
            right: 0;
            min-width: 200px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            z-index: 80;
            opacity: 0;
            transform: translateY(10px);
            visibility: hidden;
            transition: var(--transition);
        }

        .dropdown-menu.active {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .dropdown-menu a, .dropdown-menu button {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #5a5a7a;
            font-weight: 500;
            transition: var(--transition);
            text-align: left;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
        }

        .dropdown-menu a:hover, .dropdown-menu button:hover {
            background: #f9f7ff;
            color: #8a4fff;
        }

        /* Sidebar */
        .sidebar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(224, 214, 255, 0.3);
            width: 260px;
            height: calc(100vh - 70px);
            position: fixed;
            top: 70px;
            left: 0;
            padding: 25px 15px;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            z-index: 60;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.03);
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            margin-bottom: 10px;
            border-radius: 14px;
            color: #5a5a7a;
            font-weight: 600;
            transition: var(--transition);
            background: transparent;
            text-decoration: none;
        }

        .sidebar nav a:hover {
            background: rgba(138, 79, 255, 0.1);
            color: #3a2e6d;
            transform: translateX(6px);
        }

        .sidebar nav a i {
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
            color: #8a4fff;
        }

        .sidebar nav a.active {
            background: linear-gradient(135deg, #8a4fff 0%, #6c2fff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(138, 79, 255, 0.3);
        }

        .sidebar nav a.active i {
            color: white;
        }

        /* Overlay mobile */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 50;
            backdrop-filter: blur(5px);
        }

        .overlay.active {
            display: block;
        }

        /* Main content */
        .content {
            margin-left: 260px;
            padding: 30px 40px;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }

        .content.full-width {
            margin-left: 0;
        }

        /* Decorations */
        .decoration {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
            opacity: 0.5;
            pointer-events: none;
        }

        .dec-1 {
            top: 10%;
            left: 5%;
            width: 120px;
            height: 120px;
            background: #fce4ec;
        }

        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 100px;
            height: 100px;
            background: #e6e6ff;
        }

        .dec-3 {
            top: 30%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: #d8c0ff;
        }

        .dec-4 {
            top: 60%;
            left: 8%;
            width: 60px;
            height: 60px;
            background: #fce4ec;
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .content {
                padding: 30px 20px;
            }
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
                z-index: 60;
                width: 280px;
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
            
            .logo span {
                display: none;
            }
            
            .logo i {
                font-size: 1.8rem;
            }
            
            .user-btn span {
                display: none;
            }
            
            .user-btn i {
                margin-right: 0;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 25px 15px;
            }
            
            .nav-container {
                padding: 0 15px;
            }
            
            .user-btn {
                padding: 8px 12px;
            }
            
            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>
    <div class="decoration dec-4"></div>

    {{-- ---------------------- --}}
    {{-- 1. NAVBAR --}}
    {{-- ---------------------- --}}
    <header class="navbar">
        <div class="nav-container">
            {{-- Bouton hamburger pour mobile --}}
            <button class="hamburger" @click="sidebarOpen = true">
                <i class="fas fa-bars"></i>
            </button>

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="logo">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>IMSP Séminaires</span>
            </a>

            @auth
                {{-- Dropdown utilisateur --}}
                <div class="user-dropdown" x-data="{ open: false }">
                    <button @click="open = !open" class="user-btn">
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform translate-y-2"
                         class="dropdown-menu" :class="{ 'active': open }">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3">
                            <i class="fas fa-user-circle"></i> Mon profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    {{-- ---------------------- --}}
    {{-- 2. SIDEBAR --}}
    {{-- ---------------------- --}}
    @auth
        <aside class="sidebar" :class="{ 'open': sidebarOpen, 'hidden': sidebarOpen }">
            <nav>
                @php $role = auth()->user()->role; @endphp
                {{-- Lien commun à tous les rôles --}}
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Tableau de bord
                </a>
                @if($role === 'presenter')
                    <a href="{{ route('seminars.presenter.index') }}" class="{{ request()->routeIs('seminars.presenter.index') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> Mes demandes
                    </a>
                    <a href="{{ route('seminars.presenter.create') }}" class="{{ request()->routeIs('seminars.presenter.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> Nouvelle demande
                    </a>
                        <a href="{{ route('seminars.presenter.submitSummaryList') }}"
                        class="{{ request()->routeIs('seminars.presenter.submitSummaryList') ? 'active' : '' }}">
                            <i class="fas fa-file-upload"></i> Soumettre un résumé
                        </a>

                @elseif($role === 'secretary')
                    <a href="{{ route('seminars.secretary.index') }}" class="{{ request()->routeIs('seminars.secretary.index') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Demandes en attente
                    </a>
                    <a href="{{ route('seminars.secretary.publish_list') }}" class="{{ request()->routeIs('seminars.secretary.publish_list') ? 'active' : '' }}">
                        <i class="fas fa-upload"></i> Séminaires à publier
                    </a>
                    <a href="{{ route('seminars.secretary.expired') }}"
                        class="{{ request()->routeIs('seminars.secretary.expired') ? 'active' : '' }}">
                        <i class="fas fa-times-circle"></i> Séminaires expirés
                    </a>
                @elseif($role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Gérer les utilisateurs
                    </a>



                @endif
                

            </nav>
        </aside>

        <div class="overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>
    @endauth

    {{-- ---------------------- --}}
    {{-- 3. CONTENU PRINCIPAL --}}
    {{-- ---------------------- --}}
    <main class="content" :class="{ 'full-width': sidebarOpen }">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </main>

    @stack('scripts')

    <script>
        // Gestion de la sidebar en mobile
        document.addEventListener('DOMContentLoaded', function() {
            // Fermer la sidebar lorsqu'un lien est cliqué (en mobile)
            document.querySelectorAll('.sidebar nav a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        sidebarOpen = false;
                    }
                });
            });

            // Mettre à jour l'état de la sidebar au redimensionnement
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebarOpen = false;
                }
            });
        });
    </script>
</body>
</html>