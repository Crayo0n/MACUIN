@extends('admin.layout.reportes')

@section('title', 'Análisis de Ventas - MACUIN')

@section('sidebar-filters')
    <div class="glass-card p-6 rounded-2xl border border-slate-700/50">
        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Filtros de Venta</h3>
        
        <div class="mb-6">
            <div class="flex justify-between text-xs font-medium text-slate-300 mb-2">
                <span>Periodo Fiscal</span>
                <span class="text-brand-400">Marzo 2026</span>
            </div>
            <input type="range" class="w-full accent-brand-500">
            <div class="flex justify-between text-[10px] text-slate-500 mt-1 font-medium">
                <span>Feb</span>
                <span>Hoy</span>
            </div>
        </div>
        
        <div class="mb-6">
            <p class="text-xs font-medium text-slate-300 mb-2">Método de Pago</p>
            <select class="w-full bg-slate-800 text-white border border-slate-700 px-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none">
                <option>Todos los métodos</option>
                <option>Tarjeta Débito/Crédito</option>
                <option>Transferencia</option>
                <option>Efectivo</option>
            </select>
        </div>
        
        <button class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-brand-500/25 transition-all transform hover:-translate-y-0.5 mt-2">
            Actualizar Análisis
        </button>
    </div>
@endsection

@section('report-body')
    <div class="mb-8 relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">Análisis de Ventas</h1>
        <p class="text-slate-400 text-lg">Monitorea los ingresos y el rendimiento financiero de MACUIN.</p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 rounded-2xl border border-brand-500/30 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Ingresos Totales</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">$145,280</h3>
                </div>
                <span class="bg-emerald-500/10 text-emerald-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-emerald-500/20 uppercase">
                    + 12.5%
                </span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-slate-700/50 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Ticket Promedio</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">$1,162</h3>
                </div>
                <span class="bg-blue-500/10 text-blue-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-blue-500/20 uppercase">
                    Estable
                </span>
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-emerald-500/30 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Margen de Ganancia</p>
                    <h3 class="text-3xl font-bold text-white tracking-tight">34%</h3>
                </div>
                <span class="bg-emerald-500/10 text-emerald-400 font-bold text-[10px] px-2.5 py-1 rounded-md border border-emerald-500/20 uppercase">
                    ↗ Óptimo
                </span>
            </div>
        </div>
    </div>

    <!-- Chart Placeholder -->
    <div class="glass-card p-6 rounded-2xl border border-slate-700/50 mb-8 flex flex-col h-80 relative group overflow-hidden">
        <div class="absolute inset-0 bg-brand-500/5 opacity-50 z-0"></div>
        <div class="flex justify-between items-center mb-6 relative z-10">
            <p class="text-lg font-bold text-white tracking-tight">Evolución de Ingresos</p>
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span> Ventas Brutas
            </div>
        </div>
        <svg class="flex-grow w-full relative z-10" viewBox="0 0 500 150" preserveAspectRatio="none">
            <line x1="0" y1="30" x2="500" y2="30" stroke="rgba(255,255,255,0.05)" stroke-width="1" />
            <line x1="0" y1="75" x2="500" y2="75" stroke="rgba(255,255,255,0.05)" stroke-width="1" />
            <line x1="0" y1="120" x2="500" y2="120" stroke="rgba(255,255,255,0.05)" stroke-width="1" />
            <path d="M0,130 C40,120 70,60 120,70 C160,80 190,40 240,60 C280,70 320,20 370,50 C420,80 460,10 500,20" fill="none" stroke="#3b82f6" stroke-width="3" stroke-linecap="round" />
            <path d="M0,130 C40,120 70,60 120,70 C160,80 190,40 240,60 C280,70 320,20 370,50 C420,80 460,10 500,20 L500,150 L0,150 Z" fill="url(#gradientChart)" opacity="0.3"/>
            <defs>
                <linearGradient id="gradientChart" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0%" stop-color="#3b82f6"/>
                    <stop offset="100%" stop-color="transparent"/>
                </linearGradient>
            </defs>
            <circle cx="120" cy="70" r="4" fill="#3b82f6" stroke="#0f172a" stroke-width="2"/>
            <circle cx="240" cy="60" r="4" fill="#3b82f6" stroke="#0f172a" stroke-width="2"/>
            <circle cx="370" cy="50" r="4" fill="#3b82f6" stroke="#0f172a" stroke-width="2"/>
        </svg>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-2xl border border-slate-700/50 overflow-hidden">
        <div class="bg-dark-bg/50 px-6 py-4 border-b border-dark-border flex justify-between items-center text-sm font-semibold text-white tracking-wide">
            <span>Últimas Transacciones</span>
            <a href="#" class="text-brand-400 hover:text-brand-300 transition-colors text-xs">Ver todo <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <tbody class="divide-y divide-dark-border">
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-brand-400 font-bold whitespace-nowrap">#V-2026-001</td>
                        <td class="px-6 py-4 text-slate-400 text-sm whitespace-nowrap">Mar 05, 2026</td>
                        <td class="px-6 py-4 text-white font-medium whitespace-nowrap">Mauricio Rodríguez</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-slate-800 text-slate-300 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Tarjeta Débito</span>
                        </td>
                        <td class="px-6 py-4 text-right text-white font-bold whitespace-nowrap">$3,450.00</td>
                    </tr>
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-brand-400 font-bold whitespace-nowrap">#V-2026-002</td>
                        <td class="px-6 py-4 text-slate-400 text-sm whitespace-nowrap">Mar 05, 2026</td>
                        <td class="px-6 py-4 text-white font-medium whitespace-nowrap">Ana Martínez</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-amber-500/10 text-amber-500 border border-amber-500/20 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Efectivo</span>
                        </td>
                        <td class="px-6 py-4 text-right text-white font-bold whitespace-nowrap">$1,120.50</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection