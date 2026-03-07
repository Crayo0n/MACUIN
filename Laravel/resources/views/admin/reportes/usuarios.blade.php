@extends('admin.layout.reportes')

@section('title', 'Reporte de Clientes - MACUIN')

@push('report-styles')
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); border-radius: 15px; padding: 20px; position: relative; }
    .stat-label { font-family: var(--font-display); font-size: 12px; color: var(--color-muted); margin-bottom: 10px; }
    .stat-value { font-family: var(--font-display); font-size: 28px; color: #fff; }
    
    .stat-badge { position: absolute; top: 20px; right: 20px; padding: 4px 10px; border-radius: 6px; font-family: var(--font-display); font-size: 9px; }
    .badge--trend { background: rgba(57, 116, 224, 0.2); color: #3974e0; border: 1px solid #3974e0; }
    .badge--top { background: rgba(147, 51, 234, 0.2); color: #a855f7; border: 1px solid #a855f7; }
    .badge--stable { background: rgba(107, 114, 128, 0.2); color: #9ca3af; border: 1px solid #9ca3af; }

    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 9px; font-family: var(--font-display); background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid #22c55e; }

    .btn-generate { 
        width: 100%; background: var(--color-primary); color: white; border: none; padding: 15px; 
        border-radius: 30px; font-family: var(--font-display); font-size: 14px; cursor: pointer; margin-top: 10px;
        box-shadow: 0 4px 15px rgba(57, 116, 224, 0.3); transition: 0.3s;
    }
</style>
@endpush

@section('sidebar-filters')
    <div class="sidebar-card">
        <h3 class="sidebar-title">PARÁMETROS</h3>
        <div class="param-group" style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">
                <span>Rango de fecha</span>
                <span style="color: var(--color-primary);">Últimos 30 Días</span>
            </div>
            <input type="range" style="width: 100%; accent-color: var(--color-primary);">
            <div style="display: flex; justify-content: space-between; font-size: 10px; color: var(--color-subtle); font-family: var(--font-display); margin-top: 5px;">
                <span>1 Enero, 2026</span>
                <span>Hoy</span>
            </div>
        </div>
        <div class="param-group">
            <p style="font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">Categoría de Clientes</p>
            <select style="width:100%; background:#333; color:white; border:none; padding:12px; border-radius:8px; font-family: var(--font-body);">
                <option>Todos los Clientes</option>
                <option>Minoristas</option>
                <option>Distribuidores</option>
            </select>
        </div>
        <button class="btn-generate">Generar Reporte</button>
    </div>
@endsection

@section('report-body')
    <h1 class="page-header__title" style="font-size: 48px; margin-bottom: 8px;">Reportes Empresariales</h1>
    <p class="page-header__subtitle" style="margin-bottom: 30px;">Genera y exporta análisis detallados de ventas, pedidos y clientes.</p>

    <div class="stats-grid">
        <div class="stat-card">
            <p class="stat-label">Total de Clientes</p>
            <p class="stat-value">1,000</p>
            <span class="stat-badge badge--trend">📈 12.5%</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Vendedor TOP</p>
            <p class="stat-value" style="font-size: 24px;">Juan Pérez</p>
            <span class="stat-badge badge--top">TOP</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Usuarios Activos</p>
            <p class="stat-value">650</p>
            <span class="stat-badge badge--stable">➖ 0.2%</span>
        </div>
    </div>

    <div class="table-report-card">
        <div style="background: var(--color-card-head); padding: 20px; font-family: var(--font-display); font-size: 18px; border-bottom: 1px solid var(--color-border);">
            Vista Previa del Informe: Clientes
        </div>
        <table class="report-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">ID</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Email</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Nombre</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Fecha de registro</th>
                    <th style="padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);">Status</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 5; $i++)
                <tr>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight: 600;">{{ $i }}</td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--color-primary); font-weight: 600;">juanperez@gmail.com</td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight: 600;">Juan Pérez</td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05);">14 de Enero de 2026</td>
                    <td style="padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05);"><span class="status-pill">ACTIVE</span></td>
                </tr>
                @endfor
            </tbody>
        </table>
        
        <div style="padding: 20px; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.2);">
            <p style="font-size: 13px; color: var(--color-muted);">Mostrando <span>1 a 5</span> de <span>100</span> resultados</p>
            <div style="display: flex; gap: 10px;">
                <button style="background:none; border:none; cursor:pointer; opacity:0.6;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                <button style="background:none; border:none; cursor:pointer; opacity:0.6;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
            </div>
        </div>
    </div>
@endsection