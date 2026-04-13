<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MACUIN Admin – @yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            500: '#3b82f6',
                            600: '#2563eb',
                            900: '#1e3a8a',
                        },
                        dark: {
                            bg: '#0f172a',
                            card: '#1e293b',
                            border: '#334155',
                            sidebar: '#0b1120'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-sidebar {
            background: rgba(11, 17, 32, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .text-gradient {
            background: linear-gradient(to right, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-dark-bg text-slate-200 min-h-screen flex selection:bg-brand-500 selection:text-white">

    <!-- Sidebar -->
    <aside class="glass-sidebar w-72 flex-shrink-0 flex flex-col h-screen sticky top-0">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-dark-border">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-purple-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                    <i class="fa-solid fa-car-side text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="font-bold text-xl tracking-tight text-white leading-tight">MACUIN</h1>
                    <p class="text-[0.65rem] uppercase tracking-widest text-brand-400 font-bold">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-grow py-6 px-4 space-y-1 overflow-y-auto">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Gestión</p>
            
            <a href="/inventario" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::is('*inventario*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-boxes-stacked w-5"></i>
                <span class="font-medium">Inventario</span>
            </a>
            
            <a href="/ordenes" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::is('*ordenes*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-clipboard-list w-5"></i>
                <span class="font-medium">Órdenes Activas</span>
                <span class="ml-auto bg-brand-500/20 text-brand-300 py-0.5 px-2 rounded-full text-xs font-bold border border-brand-500/30">5</span>
            </a>

            <div class="pt-6 pb-2">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reportes e Inteligencia</p>
            </div>

            <a href="/ventas" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::is('*ventas*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span class="font-medium">Reporte Ventas</span>
            </a>

            <a href="/pedidos" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::is('*pedidos*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-box-open w-5"></i>
                <span class="font-medium">Reporte Pedidos</span>
            </a>

            <a href="/usuarios" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ Request::is('*usuarios*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-users w-5"></i>
                <span class="font-medium">Control Usuarios</span>
            </a>
        </nav>

        <!-- User bottom -->
        <div class="h-20 border-t border-dark-border flex items-center px-6">
            <div class="flex items-center gap-3 w-full cursor-pointer hover:bg-slate-800/50 p-2 rounded-xl transition-colors -ml-2">
                <img class="h-10 w-10 rounded-full object-cover ring-2 ring-brand-500/50" src="https://i.pravatar.cc/150?u=admin" alt="Avatar">
                <div class="flex-grow overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">Mauricio R.</p>
                    <p class="text-xs text-brand-400 font-medium truncate">Director General</p>
                </div>
                <i class="fa-solid fa-right-from-bracket text-slate-500 hover:text-red-400 transition-colors"></i>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <main class="flex-grow flex flex-col min-w-0">
        <!-- Header -->
        <header class="h-20 border-b border-dark-border bg-dark-bg/80 backdrop-blur-md sticky top-0 z-40 px-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">@yield('page-title')</h1>
                <p class="text-sm text-slate-400">@yield('page-subtitle')</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-full border border-dark-border flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition-all relative">
                    <i class="fa-solid fa-bell"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500 border-2 border-dark-bg"></span>
                </button>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8 flex-grow overflow-y-auto">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>