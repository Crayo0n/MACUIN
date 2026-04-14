@extends('admin.layout.admin')

@section('title', 'Vista General - Dashboard')
@section('page-title', 'Dashboard Operativo')
@section('page-subtitle', 'Resumen en tiempo real del taller y almacén')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-6 rounded-2xl border border-blue-500/20">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center">
                <i class="fa-solid fa-clipboard-list text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Órdenes Hoy</p>
                <h3 class="text-2xl font-bold text-white">12</h3>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 rounded-2xl border border-emerald-500/20">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                <i class="fa-solid fa-dollar-sign text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ventas Hoy</p>
                <h3 class="text-2xl font-bold text-white">$4,520</h3>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 rounded-2xl border border-amber-500/20">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Stock Bajo</p>
                <h3 class="text-2xl font-bold text-white">3</h3>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 rounded-2xl border border-purple-500/20">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Clientes</p>
                <h3 class="text-2xl font-bold text-white">48</h3>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 glass-card rounded-2xl p-6 border border-slate-700/50">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-white">Estado de la Operación</h2>
            <span class="text-xs text-brand-400 font-bold bg-brand-500/10 px-3 py-1 rounded-full uppercase tracking-widest border border-brand-500/20">En Línea</span>
        </div>
        <div class="space-y-6">
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-400">Capacidad de Taller</span>
                    <span class="text-white font-bold">75%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-brand-500 h-full rounded-full" style="width: 75%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-400">Eficiencia de Entregas</span>
                    <span class="text-white font-bold">92%</span>
                </div>
                <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: 92%"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 pt-6 border-t border-slate-700/50">
                <div class="p-4 bg-slate-800/50 rounded-xl border border-slate-700">
                    <p class="text-slate-500 text-xs font-bold uppercase mb-1">Próxima Salida</p>
                    <p class="text-white font-medium">AutoTransportes MX - 14:00</p>
                </div>
                <div class="p-4 bg-slate-800/50 rounded-xl border border-slate-700">
                    <p class="text-slate-500 text-xs font-bold uppercase mb-1">Pendiente de Revisión</p>
                    <p class="text-white font-medium">3 Piezas de Almacén</p>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 border border-slate-700/50">
        <h2 class="text-lg font-bold text-white mb-4">Acceso Rápido</h2>
        <div class="space-y-3">
            <a href="/inventario/crear" class="flex items-center gap-3 p-3 bg-brand-600/10 hover:bg-brand-600/20 border border-brand-600/30 text-brand-400 rounded-xl transition-all group">
                <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
                <span class="font-bold text-sm">Registrar Autoparte</span>
            </a>
            <a href="/ordenes" class="flex items-center gap-3 p-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 rounded-xl transition-all">
                <i class="fa-solid fa-list-check"></i>
                <span class="font-bold text-sm">Gestionar Pedidos</span>
            </a>
            <p class="pt-4 text-[10px] text-slate-500 uppercase tracking-widest font-bold">Ayuda y Soporte</p>
            <div class="p-4 bg-indigo-500/5 border border-indigo-500/10 rounded-xl text-xs text-indigo-300">
                <p>¿Problemas con el stock? Contacta con el equipo técnico de MACUIN.</p>
            </div>
        </div>
    </div>
</div>
@endsection
