@extends('admin.layout.admin')

@section('title', 'Reportes Empresariales')

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    
    <!-- Sidebar -->
    <aside class="w-full lg:w-80 flex-shrink-0 flex flex-col gap-6">
        <div class="glass-card p-6 rounded-2xl border border-slate-700/50">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Seleccionar Reporte</h3>
            
            <a href="/admin/reportes/pedidos" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-2 {{ Request::is('*pedidos*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-box-open w-5 text-center"></i>
                <span class="font-medium">Pedidos</span>
            </a>
            
            <a href="/admin/reportes/ventas" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-2 {{ Request::is('*ventas*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                <span class="font-medium">Ventas</span>
            </a>
            
            <a href="/admin/reportes/usuarios" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('*usuarios*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span class="font-medium">Clientes</span>
            </a>
        </div>

        @yield('sidebar-filters')
    </aside>

    <!-- Main Content -->
    <main class="flex-grow min-w-0">
        @yield('report-body')
    </main>

</div>
@endsection