@extends('admin.layout.admin')

@section('title', 'Inventario')
@section('page-title', 'Inventario de Autopartes')
@section('page-subtitle', 'Gestiona productos, stock y alertas de reabastecimiento.')

@section('content')
<!-- KPIs -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-6 rounded-2xl border border-brand-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Autopartes</p>
                <h3 class="text-3xl font-bold text-white tracking-tight">1,204</h3>
            </div>
            <div class="w-12 h-12 bg-brand-500/20 rounded-xl flex items-center justify-center text-brand-400 border border-brand-500/30">
                <i class="fa-solid fa-boxes-stacked text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-card p-6 rounded-2xl border border-emerald-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Valor Inventario</p>
                <h3 class="text-3xl font-bold text-white tracking-tight">$854K</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400 border border-emerald-500/30">
                <i class="fa-solid fa-dollar-sign text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 rounded-2xl border border-red-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Stock Crítico</p>
                <h3 class="text-3xl font-bold text-red-400 tracking-tight">28</h3>
            </div>
            <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center text-red-400 border border-red-500/30">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 rounded-2xl border border-purple-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Categorías</p>
                <h3 class="text-3xl font-bold text-white tracking-tight">12</h3>
            </div>
            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400 border border-purple-500/30">
                <i class="fa-solid fa-tags text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Inventario Table Container -->
<div class="glass-card rounded-2xl border border-slate-700/50 flex flex-col">
    <!-- Toolbar -->
    <div class="p-6 border-b border-dark-border flex flex-col md:flex-row md:items-center justify-between gap-4 bg-dark-bg/50 rounded-t-2xl">
        <div class="relative w-full md:w-96">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
            <input type="text" placeholder="Buscar por SKU, Nombre o Marca..." class="w-full bg-slate-800 border-none rounded-xl pl-11 pr-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium placeholder-slate-500">
        </div>
        
        <div class="flex items-center gap-3">
            <button class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors border border-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-filter"></i> Filtros
            </button>
            <a href="/inventario/crear" class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus left"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-b-2xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-dark-card/50 border-b border-dark-border text-xs uppercase tracking-wider text-slate-400 font-bold">
                    <th class="px-6 py-4">Producto / SKU</th>
                    <th class="px-6 py-4">Categoría</th>
                    <th class="px-6 py-4">Marca</th>
                    <th class="px-6 py-4 text-center">Stock</th>
                    <th class="px-6 py-4">Precio Act.</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-border">
                <!-- Fila 1 -->
                <tr class="hover:bg-slate-800/30 transition-colors group cursor-pointer">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-white font-semibold">Kit de Discos Brembo MAX</span>
                            <span class="text-slate-500 text-xs">BRM-2309-MAX</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-slate-800 text-slate-300 text-xs px-2.5 py-1 rounded-md border border-slate-700">Frenos</span>
                    </td>
                    <td class="px-6 py-4 text-slate-300 font-medium">Brembo</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-emerald-500/10 text-emerald-400 font-bold text-sm px-3 py-1 rounded-lg border border-emerald-500/20">45 uds</span>
                    </td>
                    <td class="px-6 py-4 text-brand-400 font-bold">$2,850.00</td>
                    <td class="px-6 py-4 text-right">
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center mr-1 tooltip-trigger">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-red-600 transition-colors inline-flex items-center justify-center">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>

                <!-- Fila 2 -->
                <tr class="hover:bg-slate-800/30 transition-colors group cursor-pointer">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-white font-semibold">Filtro de Aceite Bosch Premium</span>
                            <span class="text-slate-500 text-xs">BCH-FLT-098</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-slate-800 text-slate-300 text-xs px-2.5 py-1 rounded-md border border-slate-700">Filtros</span>
                    </td>
                    <td class="px-6 py-4 text-slate-300 font-medium">Bosch</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-red-500/10 text-red-500 font-bold text-sm px-3 py-1 rounded-lg border border-red-500/20">3 uds</span>
                    </td>
                    <td class="px-6 py-4 text-brand-400 font-bold">$450.00</td>
                    <td class="px-6 py-4 text-right">
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center mr-1">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-red-600 transition-colors inline-flex items-center justify-center">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- Fila 3 -->
                <tr class="hover:bg-slate-800/30 transition-colors group cursor-pointer">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-white font-semibold">Batería LTH AGM Start-Stop</span>
                            <span class="text-slate-500 text-xs">LTH-BATT-AGM</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-slate-800 text-slate-300 text-xs px-2.5 py-1 rounded-md border border-slate-700">Eléctrico</span>
                    </td>
                    <td class="px-6 py-4 text-slate-300 font-medium">LTH</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-amber-500/10 text-amber-500 font-bold text-sm px-3 py-1 rounded-lg border border-amber-500/20">12 uds</span>
                    </td>
                    <td class="px-6 py-4 text-brand-400 font-bold">$4,150.00</td>
                    <td class="px-6 py-4 text-right">
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center mr-1">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-red-600 transition-colors inline-flex items-center justify-center">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="p-4 border-t border-dark-border flex items-center justify-between text-sm text-slate-400 bg-dark-bg/50 rounded-b-2xl">
        <p>Mostrando 3 de 1,204 productos</p>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 rounded-lg border border-slate-700 hover:bg-slate-700 hover:text-white transition-colors disabled:opacity-50" disabled>Anterior</button>
            <button class="px-3 py-1.5 rounded-lg border border-slate-700 hover:bg-slate-700 hover:text-white transition-colors">Siguiente</button>
        </div>
    </div>
</div>
@endsection