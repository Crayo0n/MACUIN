@extends('admin.layout.admin')

@section('title', 'Editar AutoParte')

@section('page-title', 'Editar AutoParte')
@section('page-subtitle', 'Actualiza especificaciones, precio e información de stock')

@push('styles')
<style>
    .edit-grid {
        display: grid;
        grid-template-columns: 1.8fr 1fr; 
        gap: 24px;
        align-items: start;
    }

    .form-section-card {
        background-color: #1e1e1e;
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
        border: 0.5px solid var(--color-border);
    }

    .section-title {
        font-family: var(--font-display);
        font-size: 20px;
        margin-bottom: 20px;
        color: white;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    .history-table th {
        text-align: left;
        color: var(--color-muted);
        padding: 8px;
        border-bottom: 1px solid var(--color-border);
    }
    .history-table td {
        padding: 12px 8px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .switch-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: var(--font-display);
        font-size: 13px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 22px;
    }

    .switch input { opacity: 0; width: 0; height: 0; }

    .slider {
        position: absolute; 
        cursor: pointer; 
        inset: 0;
        background-color: #333; 
        transition: .4s; 
        border-radius: 22px;
    }

    .slider:before {
        position: absolute; content: ""; 
        height: 16px; width: 16px;
        left: 3px; 
        bottom: 3px; 
        background-color: white; 
        transition: .4s; 
        border-radius: 50%;
    }

    input:checked + .slider { background-color: var(--color-primary); }
    input:checked + .slider:before { transform: translateX(22px); }
</style>
@endpush

@section('content')
    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 20px;">
        <button class="btn btn-secondary" style="border-radius: 25px; padding: 10px 30px;">Descartar Cambios</button>
        <button class="btn btn-primary" style="border-radius: 25px; padding: 10px 30px;">Actualizar Producto</button>
    </div>

    <div class="edit-grid">
        
        <div class="col-main">
            
            <div class="form-section-card">
                <h3 class="section-title">Información General</h3>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="field-label">Nombre de Parte</label>
                    <input type="text" class="input" value="Alternador remanufacturado duralast dl11385">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label class="field-label">SKU</label>
                        <input type="text" class="input" value="BP-F-2024-C">
                    </div>
                    <div>
                        <label class="field-label">Categoría</label>
                        <select class="input" style="appearance: none;">
                            <option selected>Alternadores</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="field-label">Descripción</label>
                    <textarea class="input" style="min-height: 100px; font-size: 12px; line-height: 1.5;">Los alternadores Duralast se remanufacturan para garantizar un rendimiento confiable, reemplazando todos los componentes de desgaste...</textarea>
                </div>
            </div>

            <div class="form-section-card">
                <h3 class="section-title">Precio e inventario</h3>
                
                <div style="margin-bottom: 30px;">
                    <label class="field-label">Precio Unitario</label>
                    <input type="text" class="input" value="$45.00" style="max-width: 300px;">
                </div>

                <hr style="border: none; border-top: 1px solid var(--color-border); margin-bottom: 25px;">

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; align-items: end;">
                    <div>
                        <label class="field-label">Stock Actual</label>
                        <input type="number" class="input" value="124">
                    </div>
                    <div>
                        <label class="field-label">Alerta de Stock Bajo</label>
                        <input type="number" class="input" value="20">
                    </div>
                    <div class="switch-wrap" style="padding-bottom: 12px;">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                        <span>Disponible para Venta</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-side">
            
            <div class="form-section-card" style="text-align: center;">
                <h3 class="section-title" style="text-align: left;">Imagen del Producto</h3>
                <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px;">
                    <img src="{{ asset('images/alternador.jpg') }}" alt="Alternador" style="width: 100%; height: auto; object-fit: contain;">
                </div>
                <p style="font-size: 10px; color: var(--color-muted); margin-bottom: 15px;">SVG, PNG, JPG (MAX 800 x 400 px)</p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button class="btn btn-primary" style="font-size: 11px; padding: 8px 20px;">Cambiar</button>
                    <button class="btn btn-danger" style="font-size: 11px; padding: 8px 20px;">Remover</button>
                </div>
            </div>

            <div class="form-section-card">
                <h3 class="section-title">Historial de Stock</h3>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Acción</th>
                            <th>Cambio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12 Enero de 2026, 9:30 AM</td>
                            <td><span class="badge badge-success">Restock</span></td>
                            <td style="color: #22c55e;">+50</td>
                        </tr>
                        <tr>
                            <td>12 Enero de 2026, 9:30 AM</td>
                            <td><span class="badge badge-warning">Corrección</span></td>
                            <td style="color: #eab308;">-3</td>
                        </tr>
                        <tr>
                            <td>12 Enero de 2026, 9:30 AM</td>
                            <td><span class="badge badge-info">Venta</span></td>
                            <td style="color: var(--color-primary);">-1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection