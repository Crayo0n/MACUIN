@extends('admin.layout.admin')

@section('title', 'Control de Pedidos')

@section('page-title', 'Control de Pedidos')
@section('page-subtitle', 'Gestiona y sigue las órdenes de los clientes.')

@section('content')
<div class="glass-card rounded-2xl border border-slate-700/50 flex flex-col">
    <!-- Toolbar -->
    <div class="p-6 border-b border-dark-border flex flex-col md:flex-row md:items-center justify-between gap-4 bg-dark-bg/50 rounded-t-2xl">
        <div class="relative w-full md:w-96">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
            <input type="text" placeholder="Buscar Orden por ID, Nombre del cliente..." class="w-full bg-slate-800 border-none rounded-xl pl-11 pr-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium placeholder-slate-500">
        </div>
        
        <div class="flex items-center gap-3">
            <select class="bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none">
                <option>Status: Todos</option>
                <option>Surtido</option>
                <option>Pendiente</option>
                <option>Enviado</option>
            </select>
            <select class="bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none">
                <option>Fecha: Esta Semana</option>
                <option>Este Mes</option>
            </select>
            <button class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors border border-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-filter"></i>
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-b-2xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-dark-card/50 border-b border-dark-border text-xs uppercase tracking-wider text-slate-400 font-bold">
                    <th class="px-6 py-4">Orden ID</th>
                    <th class="px-6 py-4">Cliente</th>
                    <th class="px-6 py-4">Fecha de compra</th>
                    <th class="px-6 py-4">Monto</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-border">
                <tr class="hover:bg-slate-800/30 transition-colors group">
                    <td class="px-6 py-4">
                        <a href="#" class="text-brand-400 font-bold hover:text-brand-300 transition-colors">#ORD-2938</a>
                    </td>
                    <td class="px-6 py-4 text-white font-medium">Juan Pérez</td>
                    <td class="px-6 py-4 text-slate-400 text-sm">14 de Enero de 2026</td>
                    <td class="px-6 py-4 font-bold text-white">$1,245.00</td>
                    <td class="px-6 py-4">
                        <span class="bg-emerald-500/10 text-emerald-400 font-bold text-xs px-3 py-1.5 rounded-lg border border-emerald-500/20 uppercase inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-circle text-[8px]"></i> Surtido
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center tooltip-trigger" title="Ver detalle">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-800/30 transition-colors group">
                    <td class="px-6 py-4">
                        <a href="#" class="text-brand-400 font-bold hover:text-brand-300 transition-colors">#ORD-2939</a>
                    </td>
                    <td class="px-6 py-4 text-white font-medium">María González</td>
                    <td class="px-6 py-4 text-slate-400 text-sm">15 de Enero de 2026</td>
                    <td class="px-6 py-4 font-bold text-white">$3,550.00</td>
                    <td class="px-6 py-4">
                        <span class="bg-amber-500/10 text-amber-400 font-bold text-xs px-3 py-1.5 rounded-lg border border-amber-500/20 uppercase inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-[10px]"></i> Pendiente
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center tooltip-trigger" title="Ver detalle">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-800/30 transition-colors group">
                    <td class="px-6 py-4">
                        <a href="#" class="text-brand-400 font-bold hover:text-brand-300 transition-colors">#ORD-2940</a>
                    </td>
                    <td class="px-6 py-4 text-white font-medium">AutoTransportes MX</td>
                    <td class="px-6 py-4 text-slate-400 text-sm">16 de Enero de 2026</td>
                    <td class="px-6 py-4 font-bold text-white">$12,400.00</td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-500/10 text-blue-400 font-bold text-xs px-3 py-1.5 rounded-lg border border-blue-500/20 uppercase inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-truck-fast text-[11px]"></i> Enviado
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center tooltip-trigger" title="Ver detalle">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="p-4 border-t border-dark-border flex items-center justify-between text-sm text-slate-400 bg-dark-bg/50 rounded-b-2xl">
        <p>Mostrando 3 de 100 resultados</p>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 rounded-lg border border-slate-700 hover:bg-slate-700 hover:text-white transition-colors disabled:opacity-50" disabled>Anterior</button>
            <button class="px-3 py-1.5 rounded-lg border border-slate-700 hover:bg-slate-700 hover:text-white transition-colors">Siguiente</button>
        </div>
    </div>
</div>
@endsection