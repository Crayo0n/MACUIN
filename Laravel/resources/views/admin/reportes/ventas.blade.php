@extends('admin.layout.reportes')

@section('title', 'Análisis de Ventas - MACUIN')

@push('report-styles')
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); border-radius: 15px; padding: 20px; position: relative; }
    .stat-label { font-family: var(--font-display); font-size: 12px; color: var(--color-muted); margin-bottom: 10px; }
    .stat-value { font-family: var(--font-display); font-size: 32px; color: #fff; }
    .stat-badge { position: absolute; top: 20px; right: 20px; padding: 4px 10px; border-radius: 6px; font-family: var(--font-display); font-size: 9px; }

    .badge--success { background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid #22c55e; }
    .badge--neutral { background: rgba(57, 116, 224, 0.2); color: #3974e0; border: 1px solid #3974e0; }

    .btn-generate { 
        width: 100%; background: var(--color-primary); color: white; border: none; padding: 15px; 
        border-radius: 30px; font-family: var(--font-display); font-size: 14px; cursor: pointer; margin-top: 10px;
        box-shadow: 0 4px 15px rgba(57, 116, 224, 0.3); transition: 0.3s;
    }
    .btn-generate:hover { transform: translateY(-2px); opacity: 0.9; }
</style>
@endpush

@section('sidebar-filters')
    <div class="sidebar-card">
        <h3 class="sidebar-title">FILTROS DE VENTA</h3>
        <div class="param-group" style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">
                <span>Periodo Fiscal</span>
                <span style="color: var(--color-primary);">Marzo 2026</span>
            </div>
            <input type="range" style="width: 100%; accent-color: var(--color-primary);">
            <div style="display: flex; justify-content: space-between; font-size: 10px; color: var(--color-subtle); font-family: var(--font-display); margin-top: 5px;">
                <span>Feb</span>
                <span>Hoy</span>
            </div>
        </div>
        <div class="param-group">
            <p style="font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">Método de Pago</p>
            <select style="width:100%; background:#333; color:white; border:none; padding:12px; border-radius:8px; font-family: var(--font-body);">
                <option>Todos los métodos</option>
                <option>Tarjeta Débito/Crédito</option>
                <option>Transferencia</option>
                <option>Efectivo</option>
            </select>
        </div>
        <button class="btn-generate">Actualizar Análisis</button>
    </div>
@endsection

@section('report-body')
    <h1 class="page-header__title" style="font-size: 48px; margin-bottom: 8px;">Análisis de Ventas</h1>
    <p class="page-header__subtitle" style="margin-bottom: 30px;">Monitorea los ingresos y el rendimiento financiero de MACUIN.</p>

    <div class="stats-grid">
        <div class="stat-card">
            <p class="stat-label">Ingresos Totales</p>
            <p class="stat-value">$145,280</p>
            <span class="stat-badge badge--success">+ 12.5%</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Ticket Promedio</p>
            <p class="stat-value">$1,162</p>
            <span class="stat-badge badge--neutral">Estable</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Margen de Ganancia</p>
            <p class="stat-value">34%</p>
            <span class="stat-badge badge--success">↗ Óptimo</span>
        </div>
    </div>

    <div class="chart-container" style="background: rgba(255,255,255,0.02); border: 1px solid var(--color-border); border-radius: 15px; padding: 20px; margin-bottom: 30px; display: flex; flex-direction: column; height: 320px; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <p style="font-family: var(--font-display); font-size: 18px; color: #fff;">Evolución de Ingresos</p>
            <div style="display: flex; gap: 10px;">
                <span style="font-size: 12px; color: var(--color-muted); display: flex; align-items: center; gap: 5px;"><span style="display:block; width:10px; height:10px; border-radius:50%; background:var(--color-primary);"></span> Ventas Brutas</span>
            </div>
        </div>
        <!-- Simulated Chart Line -->
        <svg style="flex: 1;" width="100%" height="100%" viewBox="0 0 500 150" preserveAspectRatio="none">
            <!-- Grid lines -->
            <line x1="0" y1="30" x2="500" y2="30" stroke="rgba(255,255,255,0.05)" stroke-width="1" />
            <line x1="0" y1="75" x2="500" y2="75" stroke="rgba(255,255,255,0.05)" stroke-width="1" />
            <line x1="0" y1="120" x2="500" y2="120" stroke="rgba(255,255,255,0.05)" stroke-width="1" />
            <!-- Path -->
            <path d="M0,130 C40,120 70,60 120,70 C160,80 190,40 240,60 C280,70 320,20 370,50 C420,80 460,10 500,20" fill="none" stroke="var(--color-primary)" stroke-width="3" stroke-linecap="round" />
            <path d="M0,130 C40,120 70,60 120,70 C160,80 190,40 240,60 C280,70 320,20 370,50 C420,80 460,10 500,20 L500,150 L0,150 Z" fill="url(#gradientChart)" opacity="0.15"/>
            <defs>
                <linearGradient id="gradientChart" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0%" stop-color="var(--color-primary)"/>
                    <stop offset="100%" stop-color="transparent"/>
                </linearGradient>
            </defs>
            <!-- Data points -->
            <circle cx="120" cy="70" r="4" fill="var(--color-primary)" stroke="#111827" stroke-width="2"/>
            <circle cx="240" cy="60" r="4" fill="var(--color-primary)" stroke="#111827" stroke-width="2"/>
            <circle cx="370" cy="50" r="4" fill="var(--color-primary)" stroke="#111827" stroke-width="2"/>
        </svg>
    </div>

    <div class="table-report-card" style="margin-top: 30px; border: 1px solid var(--color-border); border-radius: 15px; overflow: hidden;">
        <div style="background: rgba(0,0,0,0.15); padding: 15px 20px; font-family: var(--font-display); font-size: 15px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between;">
            <span>Últimas Transacciones</span>
            <a href="#" style="color: var(--color-primary); font-size: 13px; text-decoration: none;">Ver todo</a>
        </div>
        <table class="report-table" style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); color:var(--color-primary); font-weight:600; width: 120px;">#V-2026-001</td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--color-muted);">Mar 05, 2026</td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight:500;">Mauricio Rodríguez</td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05);"><span style="background: rgba(255,255,255,0.1); padding: 3px 8px; border-radius: 4px; font-size: 10px;">TARJETA DÉBITO</span></td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight:600; color: #fff; text-align: right;">$3,450.00</td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); color:var(--color-primary); font-weight:600; width: 120px;">#V-2026-002</td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--color-muted);">Mar 05, 2026</td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight:500;">Ana Martínez</td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05);"><span style="background: rgba(255,255,255,0.1); padding: 3px 8px; border-radius: 4px; font-size: 10px;">EFECTIVO</span></td>
                    <td style="padding: 15px 20px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight:600; color: #fff; text-align: right;">$1,120.50</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection