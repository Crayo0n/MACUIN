@extends('admin.layout.admin')

@section('title', 'Gestión de Inventario')

@section('page-title', 'Gestión de Inventario')
@section('page-subtitle', 'Gestiona el stock de autopartes y actualiza precios')

@push('styles')
<style>
    .toolbar {
        display: flex; 
        align-items: center; 
        gap: 10px;
        margin-bottom: 16px; 
        flex-wrap: wrap;
    }

    .search-wrap { 
        position: relative; 
        flex: 1; 
        min-width: 240px; 
    }

    .search-wrap svg {
        position: absolute;
        left: 13px;
        top: 50%; 
        transform: translateY(-50%);
        width: 17px; 
        height: 17px; 
        stroke: var(--color-subtle); 
        pointer-events: none;
    }

    .filter-group { 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        flex-wrap: wrap; 
    }
    
    .filter-chip {
        display: inline-flex; 
        align-items: center; 
        gap: 5px;
        font-family: var(--font-display); 
        font-size: 11px;
        padding: 7px 14px; 
        border-radius: 35px; 
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .filter-chip.active { background-color: var(--color-primary); color: #fff; border: none; }
    .filter-chip.inactive {
        background-color: rgba(170,173,182,0.1);
        border: 1px solid rgba(170,173,182,0.35); color: var(--color-muted);
    }

    .stock-alert {
        background-color: rgba(255,0,0,0.08);
        border: 1px solid rgba(255,0,0,0.25);
        border-radius: var(--radius-sm);
        padding: 8px 16px; display: flex; align-items: center; gap: 10px;
    }
    .stock-alert__count { font-family: var(--font-display); font-size: 18px; color: var(--color-danger); }

    .inv-table-wrap {
        background-color: #111827;
        border-radius: var(--radius-lg);
        border: 1px solid rgba(255,255,255,0.07);
        overflow: hidden;
    }
    .inv-table { width: 100%; border-collapse: collapse; }
    .inv-table th {
        font-family: var(--font-display); font-size: 12px;
        color: var(--color-muted); padding: 16px 18px; text-align: left;
        text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .inv-table td { padding: 14px 18px; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .inv-table tbody tr:hover { background-color: rgba(57,116,224,0.04); }

    .product-thumb {
        width: 44px; height: 44px; border-radius: 8px;
        background-color: rgba(255,255,255,0.04);
        display: flex; align-items: center; justify-content: center;
    }
</style>
@endpush

@section('content')
    <div class="toolbar">
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" class="input" style="padding-left: 40px;" placeholder="Buscar autopartes...">
        </div>

        <div class="filter-group">
            <button class="filter-chip active">Todas las Categorías</button>
            <button class="filter-chip inactive">Frenos</button>
            <button class="filter-chip inactive">Eléctrico</button>
        </div>

        <div class="stock-alert">
            <div class="stock-alert__label" style="font-family:var(--font-display); font-size:10px; color:var(--color-danger);">STOCK BAJO</div>
            <div class="stock-alert__count">23</div>
        </div>

        <a href="#" class="btn btn-primary" style="border-radius: var(--radius-sm);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Añadir nueva Autoparte
        </a>
    </div>

    <div class="inv-table-wrap">
        <table class="inv-table">
            <thead>
                <tr>
                    <th>ID / SKU</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="color:var(--color-primary); font-family:var(--font-display);">#SKU-5457</td>
                    <td>
                        <div class="product-thumb">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-subtle)"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                    </td>
                    <td>Freno de Disco</td>
                    <td><span style="color:var(--color-primary); font-size:11px; font-family:var(--font-display);">FRENOS</span></td>
                    <td>$450.00</td>
                    <td>124 unidades</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="#" class="btn btn-secondary" style="padding: 6px 12px;">Editar</a>
                            <button class="btn btn-danger" style="padding: 6px 12px; background:rgba(239,68,68,0.1);">Eliminar</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination" style="display: flex; justify-content: space-between; padding: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
            <p style="font-size: 13px; color: var(--color-muted);">Mostrando <b>1 a 7</b> de <b>100</b> resultados</p>
            <div style="display: flex; gap: 8px;">
                <button class="btn btn-secondary" style="padding: 5px 10px;"><</button>
                <button class="btn btn-secondary" style="padding: 5px 10px;">></button>
            </div>
        </div>
    </div>
@endsection