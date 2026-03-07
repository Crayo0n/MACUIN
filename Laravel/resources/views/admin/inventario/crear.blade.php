@extends('admin.layout.admin')

@section('title', 'Añadir nueva AutoParte')

@section('page-title', 'Añadir nueva AutoParte')
@section('page-subtitle', 'Llena los siguientes detalles para registrar una AutoParte al sistema')

@push('styles')
<style>
    .form-card {
        background-color: #111827;
        border-radius: var(--radius-lg);
        border: 1px solid rgba(255,255,255,0.07);
        padding: 32px 40px 40px;
    }

    .form-row { display: grid; gap: 28px; }
    .form-row--full { grid-template-columns: 1fr; }
    .form-row--half { grid-template-columns: 1fr 1fr; }

    .form-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.06);
        margin: 28px 0;
    }

    .sku-wrap { position: relative; }
    .sku-wrap .field-input { padding-right: 90px; }

    .sku-generate {
        position: absolute; right: 14px; top: 50%;
        transform: translateY(-50%);
        font-family: var(--font-display); font-size: 11px;
        color: var(--color-primary);
        background: none; border: none; cursor: pointer;
        letter-spacing: 0.06em;
    }

    .upload-zone {
        border: 1.5px dashed rgba(255,255,255,0.18);
        border-radius: var(--radius-lg);
        background-color: rgba(255,255,255,0.02);
        padding: 40px 20px;
        display: flex; flex-direction: column; align-items: center; gap: 10px;
        cursor: pointer; transition: 0.2s;
    }

    .upload-zone:hover {
        border-color: var(--color-primary);
        background-color: rgba(57,116,224,0.04);
    }
</style>
@endpush

@section('content')
    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 20px;">
        <a href="#" class="btn btn-secondary">Cancelar</a>
        <button class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
            </svg>
            Guardar Parte
        </button>
    </div>

    <div class="form-card">
        <form action="#" method="POST">
            @csrf

            <div class="form-row form-row--full">
                <div>
                    <label class="field-label" for="nombre">Nombre de Parte</label>
                    <input id="nombre" type="text" class="input" placeholder="e.g. Batería de 12 V">
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-row form-row--half">
                <div>
                    <label class="field-label" for="sku">SKU código</label>
                    <div class="sku-wrap">
                        <input id="sku" type="text" class="input" placeholder="e.g. SKU-384">
                        <button type="button" class="sku-generate">GENERAR</button>
                    </div>
                </div>
                <div>
                    <label class="field-label" for="categoria">Categoría</label>
                    <select id="categoria" class="input" style="appearance: none;">
                        <option value="" disabled selected>Selecciona una Categoría</option>
                        <option value="frenos">Frenos</option>
                        <option value="motor">Motor</option>
                    </select>
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-row form-row--half">
                <div>
                    <label class="field-label" for="precio">Precio Unitario</label>
                    <input id="precio" type="text" class="input" placeholder="$0.00">
                </div>
                <div>
                    <label class="field-label" for="stock">Stock Inicial</label>
                    <input id="stock" type="number" class="input" placeholder="0">
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-row form-row--full">
                <div>
                    <label class="field-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" class="input" style="min-height: 110px;" placeholder="Escribe detalles..."></textarea>
                </div>
            </div>

            <hr class="form-divider">

            <div>
                <label class="field-label">Imagen</label>
                <div class="upload-zone">
                    <div style="width: 46px; height: 46px; background: var(--color-logo-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/>
                        </svg>
                    </div>
                    <p style="font-family: var(--font-display); font-size: 14px; color: #fff;">Click para subir</p>
                    <p style="font-family: var(--font-display); font-size: 11px; color: var(--color-subtle);">SVG, PNG, JPG (MAX 800 x 400 px)</p>
                </div>
            </div>
        </form>
    </div>
@endsection