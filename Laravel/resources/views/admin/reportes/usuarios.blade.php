@extends('admin.layout.reportes')

@section('title', 'Reporte de Clientes - MACUIN')

@section('sidebar-filters')
    <div class="glass-card p-6 rounded-2xl border border-slate-700/50">
        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Parámetros</h3>
        
        <div class="mb-6">
            <div class="flex justify-between text-xs font-medium text-slate-300 mb-2">
                <span>Rango de fecha</span>
                <span class="text-brand-400">Últimos 30 Días</span>
            </div>
            <input type="range" class="w-full accent-brand-500">
            <div class="flex justify-between text-[10px] text-slate-500 mt-1 font-medium">
                <span>1 Ene, 2026</span>
                <span>Hoy</span>
            </div>
        </div>
        
        <div class="mb-6">
            <p class="text-xs font-medium text-slate-300 mb-2">Categoría de Clientes</p>
            <select class="w-full bg-slate-800 text-white border border-slate-700 px-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none">
                <option>Todos los Clientes</option>
                <option>Minoristas</option>
                <option>Distribuidores</option>
            </select>
        </div>
        
        <button class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-brand-500/25 transition-all transform hover:-translate-y-0.5 mt-2">
            Generar Reporte
        </button>
    </div>
@endsection

@section('report-body')
    <div class="mb-8 relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">Directorio de Clientes</h1>
        <p class="text-slate-400 text-lg">Añade y gestiona directamente los clientes en MACUIN.</p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 rounded-2xl border border-brand-500/30 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Total de Clientes</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">1,000</h3>
                </div>
                <span class="bg-blue-500/10 text-blue-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-blue-500/20 tracking-wider">
                    <i class="fa-solid fa-arrow-trend-up mr-1 text-[10px]"></i> 12.5%
                </span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-purple-500/30 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Vendedor TOP</p>
                    <h3 class="text-2xl font-bold text-white tracking-tight mt-1">Juan Pérez</h3>
                </div>
                <span class="bg-purple-500/10 text-purple-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-purple-500/20 uppercase tracking-wider">
                    TOP
                </span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-slate-600/30 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Usuarios Activos</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">650</h3>
                </div>
                <span class="bg-slate-500/10 text-slate-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-slate-500/20 tracking-wider flex items-center">
                    <i class="fa-solid fa-minus mr-1 text-[10px]"></i> 0.2%
                </span>
            </div>
        </div>
    </div>

    <!-- Header & Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white tracking-tight">Directorio</h2>
        <a href="/admin/reportes/usuarios_crear" class="bg-brand-600 hover:bg-brand-500 text-white font-medium py-2 px-4 rounded-xl shadow-lg shadow-brand-500/25 transition-all flex items-center gap-2 text-sm">
            <i class="fa-solid fa-user-plus"></i> Nuevo Cliente
        </a>
    </div>

    <!-- Customer Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @php
            $users = [
                ['name' => 'Juan Pérez', 'email' => 'juanperez@gmail.com', 'initials' => 'JP', 'date' => '14 Ene, 2026', 'status' => 'ACTIVE', 'statusColor' => 'emerald', 'avatarColor' => 'brand'],
                ['name' => 'María López', 'email' => 'm.lopez@empresa.com', 'initials' => 'ML', 'date' => '22 Feb, 2026', 'status' => 'ACTIVE', 'statusColor' => 'emerald', 'avatarColor' => 'purple'],
                ['name' => 'Carlos Estrada', 'email' => 'carlos.e@outlook.com', 'initials' => 'CE', 'date' => '05 Mar, 2026', 'status' => 'INACTIVE', 'statusColor' => 'red', 'avatarColor' => 'red'],
                ['name' => 'Ana Martínez', 'email' => 'ana.martinez@gmail.com', 'initials' => 'AM', 'date' => '10 Mar, 2026', 'status' => 'ACTIVE', 'statusColor' => 'emerald', 'avatarColor' => 'emerald'],
                ['name' => 'Empresa XYZ', 'email' => 'compras@xyz.com', 'initials' => 'EX', 'date' => '15 Mar, 2026', 'status' => 'PENDING', 'statusColor' => 'amber', 'avatarColor' => 'amber']
            ];
        @endphp

        @foreach($users as $user)
        <div class="glass-card border border-slate-700/50 rounded-2xl p-6 text-center relative transition-all duration-300 hover:-translate-y-1 hover:border-{{ $user['avatarColor'] }}-500/50 group cursor-pointer">
            <span class="absolute top-4 right-4 bg-{{ $user['statusColor'] }}-500/10 text-{{ $user['statusColor'] }}-400 border border-{{ $user['statusColor'] }}-500/20 px-2 py-1 rounded text-[9px] font-bold uppercase tracking-wider">
                {{ $user['status'] }}
            </span>
            
            <div class="w-16 h-16 mx-auto mb-4 bg-{{ $user['avatarColor'] }}-500/10 text-{{ $user['avatarColor'] }}-500 rounded-full flex items-center justify-center text-xl font-bold shadow-inner border border-{{ $user['avatarColor'] }}-500/20">
                {{ $user['initials'] }}
            </div>
            
            <h3 class="text-lg font-bold text-white mb-1 group-hover:text-{{ $user['avatarColor'] }}-400 transition-colors">{{ $user['name'] }}</h3>
            <p class="text-xs text-{{ $user['avatarColor'] }}-400 font-medium mb-3">{{ $user['email'] }}</p>
            <p class="text-[11px] text-slate-500 mb-4 flex items-center justify-center gap-1.5"><i class="fa-regular fa-calendar-days"></i> Registrado {{ $user['date'] }}</p>
            
            <div class="flex gap-2 pt-4 border-t border-slate-700/50 mt-auto">
                <button class="flex-1 bg-slate-800 hover:bg-slate-700 text-white py-2 px-3 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors border border-slate-700">Perfil</button>
                <button class="flex-1 bg-brand-500/10 hover:bg-brand-500/20 text-brand-400 border border-brand-500/30 py-2 px-3 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">Mensaje</button>
            </div>
        </div>
        @endforeach
    </div>
@endsection