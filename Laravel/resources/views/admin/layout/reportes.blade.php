@extends('admin.layout.admin')

@section('title', 'Reportes Empresariales')

@push('styles')
<style>
    .report-container {
        display: flex;
        gap: 30px;
        margin-top: -10px; 
    }

    .report-sidebar {
        width: 300px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--color-border);
        border-radius: 15px;
        padding: 20px;
    }

    .sidebar-title {
        font-family: var(--font-display);
        font-size: 11px;
        color: var(--color-muted);
        text-transform: uppercase;
        margin-bottom: 15px;
        letter-spacing: 1px;
    }

    .report-nav-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 10px;
        color: white;
        margin-bottom: 8px;
        border: none;
        background: transparent;
        font-family: var(--font-display);
        font-size: 13px;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
    }

    .report-nav-btn.active {
        background: var(--color-primary);
    }

    .report-nav-btn:hover:not(.active) {
        background: rgba(255, 255, 255, 0.1);
    }

    .report-main {
        flex: 1;
    }

    .table-report-card {
        background: var(--color-surface);
        border-radius: 15px;
        border: 1px solid var(--color-border);
        overflow: hidden;
    }
</style>
@stack('report-styles')
@endpush

@section('content')
<div class="report-container">
    
    <aside class="report-sidebar">
        <div class="sidebar-card">
            <h3 class="sidebar-title">Seleccionar Reporte</h3>
            
            <a href="#" 
               class="report-nav-btn {{ Request::is('admin/reportes/pedidos') ? 'active' : '' }}">
                Pedidos
            </a>
            
            <a href="#" 
               class="report-nav-btn {{ Request::is('admin/reportes/ventas') ? 'active' : '' }}">
                Ventas
            </a>
            
            <a href="#" 
               class="report-nav-btn {{ Request::is('admin/reportes/usuarios') ? 'active' : '' }}">
                Clientes
            </a>
        </div>

        @yield('sidebar-filters')
    </aside>

    <main class="report-main">
        @yield('report-body')
    </main>

</div>
@endsection