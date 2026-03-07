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

    <div class="table-report-card">
        <div style="background: var(--color-card-head); padding: 20px; font-family: var(--font-display); font-size: 18px; border-bottom: 1px solid var(--color-border);">
            Desglose de Ventas Recientes
        </div>
        <table class="report-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Folio</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Fecha</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Cliente</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Método</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); color:var(--color-primary); font-weight:600;">#V-2026-001</td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05);">Marzo 05, 2026</td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight:600;">Mauricio Rodríguez</td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05);"><span style="font-size: 11px; color: var(--color-muted);">TARJETA DÉBITO</span></td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight:600; color: #fff;">$3,450.00</td>
                </tr>
            </tbody>
        </table>
        
        <div style="padding: 20px; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.15);">
            <p style="font-size: 13px; color: var(--color-muted);">Mostrando ingresos del periodo actual</p>
            <div style="display: flex; gap: 10px;">
                <button style="background:none; border:none; cursor:pointer; opacity:0.6;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                <button style="background:none; border:none; cursor:pointer; opacity:0.6;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
            </div>
        </div>
    </div>
@endsection