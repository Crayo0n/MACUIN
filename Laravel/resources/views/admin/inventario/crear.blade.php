@extends('admin.layout.admin')

@section('title', 'Añadir nueva AutoParte')

@section('page-title', 'Añadir nueva AutoParte')
@section('page-subtitle', 'Llena los siguientes detalles para registrar una AutoParte al sistema')

@push('styles')
<style>
    .form-card {
        background-color: #111827;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.07);
        padding: 32px 40px 40px;
    }
    .field-label { display: block; font-size: 13px; font-weight: 600; color: #9CA3AF; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
    .input { width: 100%; background: rgba(31, 41, 55, 0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 12px; color: white; transition: 0.2s; }
    .input:focus { outline: none; border-color: #3b82f6; background: rgba(31, 41, 55, 0.8); }
    .sku-wrap { position: relative; }
    .sku-generate {
        position: absolute; right: 14px; top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: #3b82f6;
        background: none; border: none; cursor: pointer;
        font-weight: 800;
    }
</style>
@endpush

@section('content')
    <form action="/inventario/store" method="POST">
        @csrf
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 20px;">
            <a href="/inventario" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all border border-slate-700">Cancelar</a>
            <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white px-8 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Parte
            </button>
        </div>

        <div class="form-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="field-label" for="nombre">Nombre de Parte</label>
                    <input id="nombre" name="nombre" type="text" class="input" placeholder="e.g. Batería de 12 V" required>
                </div>

                <div>
                    <label class="field-label" for="sku">SKU código</label>
                    <div class="sku-wrap">
                        <input id="sku" name="sku" type="text" class="input" placeholder="e.g. SKU-384" required>
                        <button type="button" class="sku-generate" onclick="generateSKU()">GENERAR</button>
                    </div>
                </div>

                <div>
                    <label class="field-label" for="categoria">Categoría</label>
                    <select id="categoria" name="categoria_id" class="input">
                        <option value="1">Motor</option>
                        <option value="2">Frenos</option>
                        <option value="3">Eléctrico</option>
                        <option value="4">Filtros</option>
                    </select>
                </div>

                <div>
                    <label class="field-label" for="precio">Precio Unitario ($)</label>
                    <input id="precio" name="precio" type="number" step="0.01" class="input" placeholder="0.00" required>
                </div>

                <div>
                    <label class="field-label" for="stock">Stock Inicial</label>
                    <input id="stock" name="stock_disponible" type="number" class="input" placeholder="0" required>
                </div>

                <div class="md:col-span-2">
                    <label class="field-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="input" style="min-height: 110px;" placeholder="Escribe detalles sobre la autoparte..."></textarea>
                </div>
                
                <div>
                  <label class="field-label" for="marca">Marca</label>
                  <input id="marca" name="marca" type="text" class="input" placeholder="e.g. Bosch, Brembo...">
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        function generateSKU() {
            const random = Math.floor(Math.random() * 100000);
            document.getElementById('sku').value = 'AP-' + random;
        }
    </script>
    @endpush
@endsection