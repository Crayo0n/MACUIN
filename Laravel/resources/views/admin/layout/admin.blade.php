<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MACUIN – @yield('title', 'Panel de Control')</title>

    @vite(['resources/css/macuin.css'])

    @stack('styles')
</head>
<body>
    <nav class="navbar">
        {{-- Logo --}}
        <a href="#" class="navbar__logo">
            <div class="navbar__logo-icon">M</div>
            <div class="navbar__logo-text">
                <span>MACUIN</span>
                <span>Autopartes Dist.</span>
            </div>
        </a>

        <div class="navbar__nav">
            <a href="#" 
               class="navbar__nav-item {{ Request::is('admin/inventario*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/>
                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
                </svg>
                Inventario
            </a>

            <a href="#" 
               class="navbar__nav-item {{ Request::is('admin/ordenes*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="2"/>
                </svg>
                Ordenes
            </a>

            <a href="#" 
               class="navbar__nav-item {{ Request::is('admin/reportes*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                Reportes
            </a>
        </div>

        <div class="navbar__spacer"></div>

        <div class="navbar__right">
            <button class="navbar__bell" title="Notificaciones">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
            </button>

            <div class="navbar__divider"></div>

            <div class="navbar__user">
                <div class="navbar__user-info">
                    <div class="navbar__user-name">Mauricio Rodriguez</div>
                    <div class="navbar__user-role">Gerente General</div>
                </div>
                <div class="navbar__avatar">
                    MR
                </div>
            </div>
        </div>
    </nav>

    <main class="main-wrapper">
        <div class="page-header">
            <h1 class="page-header__title">@yield('page-title')</h1>
            <p class="page-header__subtitle">@yield('page-subtitle')</p>
        </div>

        <div class="page-content">
            @yield('content')
        </div>
    </main>

    @stack('scripts')

</body>
</html>