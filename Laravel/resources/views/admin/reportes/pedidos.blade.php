@extends('admin.layout.reportes')

@section('title', 'Reportes de Pedidos - MACUIN')

@push('report-styles')
<style>
    .status-tag { padding: 4px 12px; border-radius: 20px; font-size: 9px; font-family: var(--font-display); text-transform: uppercase; }
    .status--entregado { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
    .status--cancelado { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); border-radius: 15px; padding: 20px; position: relative; }
    .stat-label { font-family: var(--font-display); font-size: 12px; color: var(--color-muted); margin-bottom: 10px; }
    .stat-value { font-family: var(--font-display); font-size: 32px; }
    .stat-badge { position: absolute; top: 20px; right: 20px; padding: 4px 10px; border-radius: 6px; font-family: var(--font-display); font-size: 9px; }
    .badge--blue { background: rgba(57, 116, 224, 0.2); color: #3974e0; border: 1px solid #3974e0; }
    .badge--red { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444; }
    .badge--green { background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid #22c55e; }

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
        <h3 class="sidebar-title">PARÁMETROS DE PEDIDOS</h3>
        <div class="param-group" style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">
                <span>Rango de fecha</span>
                <span style="color: var(--color-primary);">Últimos 30 Días</span>
            </div>
            <input type="range" style="width: 100%; accent-color: var(--color-primary);">
            <div style="display: flex; justify-content: space-between; font-size: 10px; color: var(--color-subtle); font-family: var(--font-display); margin-top: 5px;">
                <span>1 Ene, 2026</span>
                <span>Hoy</span>
            </div>
        </div>
        <div class="param-group">
            <p style="font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">Categoría de Producto</p>
            <select style="width:100%; background:#333; color:white; border:none; padding:12px; border-radius:8px; font-family: var(--font-body);">
                <option>Todas las Categorías</option>
                <option>Frenos</option>
                <option>Motor</option>
            </select>
        </div>
        <button class="btn-generate">Generar Reporte</button>
    </div>
@endsection

@section('report-body')
    <h1 class="page-header__title" style="font-size: 48px; margin-bottom: 8px;">Reportes de Pedidos</h1>
    <p class="page-header__subtitle" style="margin-bottom: 30px;">Genera y exporta análisis detallados de los pedidos realizados.</p>

    <div class="stats-grid">
        <div class="stat-card">
            <p class="stat-label">Total de Ordenes</p>
            <p class="stat-value">1,245</p>
            <span class="stat-badge badge--blue">+ 24 Horas</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Pendiente de Cumplir</p>
            <p class="stat-value">86</p>
            <span class="stat-badge badge--red">Crítico</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Valor Promedio de Orden</p>
            <p class="stat-value">$85.45</p>
            <span class="stat-badge badge--green">↗ 4.1%</span>
        </div>
    </div>

    <div class="ticket-list" style="display: flex; flex-direction: column; gap: 15px;">
        <!-- Ticket 1 -->
        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-border); border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; transition: 0.2s;">
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="width: 50px; height: 50px; background: rgba(34, 197, 94, 0.1); color: #22c55e; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div>
                    <p style="font-family: var(--font-display); font-size: 16px; font-weight: bold; color: #fff; margin-bottom: 4px;">#ORD-2938 <span style="font-size: 13px; color: var(--color-muted); font-weight: normal; margin-left: 10px;">Por: <strong>Juan Pérez</strong></span></p>
                    <p style="font-size: 13px; color: var(--color-muted);">Aceite de motor sintético 5W-30 (x2) • <span style="color:#aaa;">Procesado el 12 Ene, 2026</span></p>
                </div>
            </div>
            <div style="display: flex; gap: 24px; align-items: center;">
                <div style="text-align: right;">
                    <p style="font-size: 11px; color: var(--color-muted); margin-bottom: 2px;">Monto de Orden</p>
                    <p style="font-family: var(--font-display); font-size: 18px; font-weight: bold; color: #fff;">$450.00</p>
                </div>
                <span class="status-tag status--entregado" style="font-size: 11px; padding: 6px 14px;">Entregado</span>
                <button style="background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); padding: 10px 18px; border-radius: 8px; color: #fff; cursor: pointer; font-size: 13px; transition: 0.2s;">Gestionar ↗</button>
            </div>
        </div>

        <!-- Ticket 2 -->
        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 0 15px rgba(239, 68, 68, 0.05);">
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="width: 50px; height: 50px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div>
                    <p style="font-family: var(--font-display); font-size: 16px; font-weight: bold; color: #fff; margin-bottom: 4px;">#ORD-2939 <span style="font-size: 13px; color: var(--color-muted); font-weight: normal; margin-left: 10px;">Por: <strong>María López</strong></span></p>
                    <p style="font-size: 13px; color: var(--color-muted);">Freno de Disco Hidráulico (x1) • <span style="color:#aaa;">Procesado el 13 Ene, 2026</span></p>
                </div>
            </div>
            <div style="display: flex; gap: 24px; align-items: center;">
                <div style="text-align: right;">
                    <p style="font-size: 11px; color: var(--color-muted); margin-bottom: 2px;">Monto de Orden</p>
                    <p style="font-family: var(--font-display); font-size: 18px; font-weight: bold; color: #fff;">$1,200.00</p>
                </div>
                <span class="status-tag status--cancelado" style="font-size: 11px; padding: 6px 14px;">Cancelado</span>
                <button style="background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); padding: 10px 18px; border-radius: 8px; color: #fff; cursor: pointer; font-size: 13px; transition: 0.2s;">Gestionar ↗</button>
            </div>
        </div>

        <!-- Ticket 3 -->
        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-primary); border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden;">
            <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--color-primary);"></div>
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="width: 50px; height: 50px; background: rgba(57, 116, 224, 0.1); color: var(--color-primary); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div>
                    <p style="font-family: var(--font-display); font-size: 16px; font-weight: bold; color: #fff; margin-bottom: 4px;">#ORD-2940 <span style="font-size: 13px; color: var(--color-muted); font-weight: normal; margin-left: 10px;">Por: <strong>Carlos Estrada</strong></span></p>
                    <p style="font-size: 13px; color: var(--color-muted);">Filtro de Aire Alto Flujo (x4) • <span style="color:#aaa;">Hace 2 horas</span></p>
                </div>
            </div>
            <div style="display: flex; gap: 24px; align-items: center;">
                <div style="text-align: right;">
                    <p style="font-size: 11px; color: var(--color-muted); margin-bottom: 2px;">Monto de Orden</p>
                    <p style="font-family: var(--font-display); font-size: 18px; font-weight: bold; color: #fff;">$850.50</p>
                </div>
                <span class="status-tag" style="background: rgba(234, 179, 8, 0.2); color: #eab308; font-size: 11px; padding: 6px 14px;">Pendiente</span>
                <button style="background: var(--color-primary); border: none; padding: 11px 19px; border-radius: 8px; color: #fff; cursor: pointer; font-size: 13px; transition: 0.2s; font-weight: 500;">Procesar ↗</button>
            </div>
        </div>
        
    </div>
@endsection