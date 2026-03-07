@extends('admin.layout.admin')

@section('title', 'Control de Pedidos')

@section('page-title', 'Control de Pedidos')
@section('page-subtitle', 'Gestiona y sigue las ordenes de los clientes.')

@push('styles')
<style>
    .filters-bar {
        display: flex; gap: 20px; padding: 0 0 30px; align-items: center;
    }
    .search-container { position: relative; flex: 1; max-width: 600px; }
    
    .search-input {
        width: 100%; background-color: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); 
        border-radius: 12px; padding: 14px 14px 14px 45px; color: white; font-family: var(--font-body);
    }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); opacity: 0.5; }

    .filter-select {
        background-color: #333; color: white; border: none; border-radius: 12px;
        padding: 14px 40px 14px 20px; font-family: var(--font-body);
        appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 15px center;
    }

    .table-card { background-color: var(--color-surface); border-radius: 20px; overflow: hidden; border: 1px solid var(--color-border); }
    .orders-table { width: 100%; border-collapse: collapse; text-align: left; }
    .orders-table th { 
        padding: 20px; font-family: var(--font-display); font-size: 13px; 
        color: var(--color-muted); border-bottom: 1px solid var(--color-border);
    }
    .orders-table td { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 14px; }
    .orders-table tr:hover { background-color: rgba(255,255,255,0.03); transition: 0.2s; }
    
    .order-id { color: var(--color-primary); font-weight: 600; text-decoration: none; }

    .status-pill {
        display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; 
        border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;
    }

    .status--surtido { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
    .status--pendiente { background: rgba(234, 179, 8, 0.2); color: #eab308; }
    .status--enviado { background: rgba(57, 116, 224, 0.2); color: #3974e0; }
    .status--cancelado { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

    .view-btn { 
        background: none; border: none; cursor: pointer; color: white; opacity: 0.7; transition: 0.2s; 
    }
    .view-btn:hover { opacity: 1; transform: scale(1.1); }
</style>
@endpush

@section('content')
    <section class="filters-bar">
        <div class="search-container">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" class="search-input" placeholder="Buscar Orden por ID, Nombre del cliente ...">
        </div>
        <select class="filter-select"><option>Status: Todos</option></select>
        <select class="filter-select"><option>Fecha: Esta Semana</option></select>
    </section>

    <div class="table-card">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Orden ID</th>
                    <th>Cliente</th>
                    <th>Fecha de compra</th>
                    <th>Monto</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="#" class="order-id">#ORD-2938</a></td>
                    <td>Juan Pérez</td>
                    <td>14 de Enero de 2026</td>
                    <td style="font-weight: 500;">$1,245.00</td>
                    <td><span class="status-pill status--surtido">Surtido ▾</span></td>
                    <td><button class="view-btn" title="Ver detalle"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button></td>
                </tr>
                {{-- Aquí irían más filas --}}
            </tbody>
        </table>

        <footer class="table-footer" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background-color: rgba(0,0,0,0.2);">
            <p class="pagination-text" style="font-size: 13px; color: var(--color-muted);">Mostrando <span>1 a 5</span> de <span>100</span> resultados</p>
            <div class="nav-arrows" style="display: flex; gap: 15px;">
                <button class="arrow-btn" style="cursor: pointer; opacity: 0.6; background: none; border: none;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                <button class="arrow-btn" style="cursor: pointer; opacity: 0.6; background: none; border: none;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
            </div>
        </footer>
    </div>
@endsection