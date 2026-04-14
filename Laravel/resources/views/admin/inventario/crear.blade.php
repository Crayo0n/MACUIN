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
    <form action="/inventario/store" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 20px;">
            <a href="/inventario" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all border border-slate-700">Cancelar</a>
            <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white px-8 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Parte
            </button>
        </div>

        <div class="form-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Image Upload Section -->
                <div class="md:col-span-2">
                    <label class="field-label">Imagen del Producto</label>
                    <div class="flex flex-col md:flex-row gap-6 items-center bg-slate-800/30 p-6 rounded-2xl border border-dashed border-slate-700">
                        <div id="image-preview-container" class="w-32 h-32 rounded-xl bg-slate-900 border border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <i id="placeholder-icon" class="fa-solid fa-image text-3xl text-slate-700"></i>
                            <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                        </div>
                        <div class="flex-grow">
                            <p class="text-xs text-slate-400 mb-3">Sube una imagen clara de la pieza para facilitar su identificación en el inventario. Formatos aceptados: JPG, PNG, WEBP.</p>
                            <input type="file" name="imagen_file" id="imagen_input" class="hidden" accept="image/*" onchange="previewImage(this)">
                            <button type="button" onclick="document.getElementById('imagen_input').click()" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-xs font-bold border border-slate-600 transition-colors">
                                <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Seleccionar Imagen
                            </button>
                        </div>
                    </div>
                </div>

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
                        @foreach($categorias as $cat)
                            <option value="{{ $cat['id'] }}">{{ $cat['nombre'] }}</option>
                        @endforeach
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

        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const icon = document.getElementById('placeholder-icon');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
@endsection