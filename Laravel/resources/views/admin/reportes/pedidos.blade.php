@extends('admin.layout.reportes')

@section('title', 'Reportes de Pedidos - MACUIN')

@section('sidebar-filters')
    <div class="glass-card p-6 rounded-2xl border border-slate-700/50">
        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Parámetros de Pedidos</h3>
        
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
            <p class="text-xs font-medium text-slate-300 mb-2">Categoría de Producto</p>
            <select class="w-full bg-slate-800 text-white border border-slate-700 px-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none">
                <option>Todas las Categorías</option>
                <option>Frenos</option>
                <option>Motor</option>
            </select>
        </div>
        
        <button class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-brand-500/25 transition-all transform hover:-translate-y-0.5 mt-2">
            Generar Reporte
        </button>
    </div>
@endsection

@section('report-body')
    <div class="mb-8 relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">Reportes de Pedidos</h1>
        <p class="text-slate-400 text-lg">Genera y exporta análisis detallados de los pedidos realizados.</p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 rounded-2xl border border-brand-500/30 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Total de Órdenes</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">1,245</h3>
                </div>
                <span class="bg-blue-500/10 text-blue-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-blue-500/20 uppercase">
                    + 24 Horas
                </span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-red-500/30 relative overflow-hidden group border-red-500/30">
            <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Pendiente de Cumplir</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">86</h3>
                </div>
                <span class="bg-red-500/10 text-red-500 font-bold text-[10px] px-2.5 py-1 rounded-md border border-red-500/20 uppercase">
                    Crítico
                </span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-emerald-500/30 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Valor Promedio de Orden</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">$85.45</h3>
                </div>
                <span class="bg-emerald-500/10 text-emerald-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-emerald-500/20 uppercase">
                    ↗ 4.1%
                </span>
            </div>
        </div>
    </div>

    <!-- Ticket List -->
    <div class="flex flex-col gap-4">
        
        <!-- Ticket 1 -->
        <div class="glass-card p-5 rounded-xl border border-slate-700/50 flex flex-col md:flex-row justify-between md:items-center gap-4 transition-all hover:bg-slate-800/30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
                <div>
                    <p class="text-base font-bold text-white mb-1 tracking-tight">#ORD-2938 <span class="text-xs text-slate-400 font-normal ml-2">Por: <strong class="text-slate-300">Juan Pérez</strong></span></p>
                    <p class="text-xs text-slate-400">Aceite de motor sintético 5W-30 (x2) &bull; <span class="text-slate-500">Procesado el 12 Ene, 2026</span></p>
                </div>
            </div>
            <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-auto">
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Monto de Orden</p>
                    <p class="text-lg font-bold text-emerald-400">$450.00</p>
                </div>
                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest whitespace-nowrap">Entregado</span>
                <button class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold transition-colors border border-slate-700 whitespace-nowrap">Gestionar <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></button>
            </div>
        </div>

        <!-- Ticket 2 -->
        <div class="glass-card p-5 rounded-xl border border-red-500/30 shadow-[0_0_15px_rgba(239,68,68,0.05)] flex flex-col md:flex-row justify-between md:items-center gap-4 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-500/10 text-red-500 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
                <div>
                    <p class="text-base font-bold text-white mb-1 tracking-tight">#ORD-2939 <span class="text-xs text-slate-400 font-normal ml-2">Por: <strong class="text-slate-300">María López</strong></span></p>
                    <p class="text-xs text-slate-400">Freno de Disco Hidráulico (x1) &bull; <span class="text-slate-500">Procesado el 13 Ene, 2026</span></p>
                </div>
            </div>
            <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-auto">
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Monto de Orden</p>
                    <p class="text-lg font-bold text-white">$1,200.00</p>
                </div>
                <span class="bg-red-500/10 text-red-500 border border-red-500/20 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest whitespace-nowrap">Cancelado</span>
                <button class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold transition-colors border border-slate-700 whitespace-nowrap">Gestionar <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></button>
            </div>
        </div>

        <!-- Ticket 3 -->
        <div class="glass-card p-5 rounded-xl border border-brand-500/50 shadow-[0_0_15px_rgba(59,130,246,0.1)] flex flex-col md:flex-row justify-between md:items-center gap-4 transition-all relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-500"></div>
            <div class="flex items-center gap-4 pl-2">
                <div class="w-12 h-12 bg-brand-500/10 text-brand-500 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
                <div>
                    <p class="text-base font-bold text-white mb-1 tracking-tight">#ORD-2940 <span class="text-xs text-slate-400 font-normal ml-2">Por: <strong class="text-slate-300">Carlos Estrada</strong></span></p>
                    <p class="text-xs text-slate-400">Filtro de Aire Alto Flujo (x4) &bull; <span class="text-slate-500">Hace 2 horas</span></p>
                </div>
            </div>
            <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-auto">
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Monto de Orden</p>
                    <p class="text-lg font-bold text-white">$850.50</p>
                </div>
                <span class="bg-amber-500/10 text-amber-500 border border-amber-500/20 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest whitespace-nowrap">Pendiente</span>
                <button class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2.5 rounded-xl text-xs font-semibold transition-colors shadow-lg shadow-brand-500/20 whitespace-nowrap">Procesar <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></button>
            </div>
        </div>
        
    </div>
@endsection