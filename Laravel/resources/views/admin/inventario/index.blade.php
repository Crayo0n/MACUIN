@extends('admin.layout.admin')

@section('title', 'Inventario')
@section('page-title', 'Inventario de Autopartes')
@section('page-subtitle', 'Gestiona productos, stock y alertas de reabastecimiento.')

@section('content')
<!-- KPIs -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-6 rounded-2xl border border-brand-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Autopartes</p>
                <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($kpis['total']) }}</h3>
            </div>
            <div class="w-12 h-12 bg-brand-500/20 rounded-xl flex items-center justify-center text-brand-400 border border-brand-500/30">
                <i class="fa-solid fa-boxes-stacked text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-card p-6 rounded-2xl border border-emerald-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Valor Inventario</p>
                <h3 class="text-3xl font-bold text-white tracking-tight">${{ number_format($kpis['valor_total'] / 1000, 1) }}K</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400 border border-emerald-500/30">
                <i class="fa-solid fa-dollar-sign text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 rounded-2xl border border-red-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Stock Crítico</p>
                <h3 class="text-3xl font-bold text-red-400 tracking-tight">{{ $kpis['stock_critico'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center text-red-400 border border-red-500/30">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 rounded-2xl border border-purple-500/30 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between z-10 relative">
            <div>
                <p class="text-sm font-medium text-slate-400 mb-1">Categorías</p>
                <h3 class="text-3xl font-bold text-white tracking-tight">{{ $kpis['categorias'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400 border border-purple-500/30">
                <i class="fa-solid fa-tags text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Inventario Table Container -->
<div class="glass-card rounded-2xl border border-slate-700/50 flex flex-col">
    <!-- Toolbar -->
    <div class="p-6 border-b border-dark-border flex flex-col md:flex-row md:items-center justify-between gap-4 bg-dark-bg/50 rounded-t-2xl">
        <div class="relative w-full md:w-96">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
            <input type="text" id="inventorySearch" placeholder="Buscar por SKU, Nombre o Marca..." class="w-full bg-slate-800 border-none rounded-xl pl-11 pr-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium placeholder-slate-500">
        </div>
        
    <div class="flex items-center gap-3">
            <button onclick="toggleCategoryModal()" class="bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all border border-slate-700 flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-tags"></i> Categorías
            </button>
            <a href="/inventario/crear" class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-brand-500/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-b-2xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-dark-card/50 border-b border-dark-border text-xs uppercase tracking-wider text-slate-400 font-bold">
                    <th class="px-6 py-4">Img</th>
                    <th class="px-6 py-4">Producto / SKU</th>
                    <th class="px-6 py-4">Categoría</th>
                    <th class="px-6 py-4">Marca</th>
                    <th class="px-6 py-4 text-center">Stock</th>
                    <th class="px-6 py-4">Precio Act.</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-border" id="inventoryTable">
                @forelse($autopartes as $ap)
                <tr class="hover:bg-slate-800/30 transition-colors group cursor-pointer inventory-row" data-search="{{ strtolower($ap['nombre'] . ' ' . $ap['sku']) }}">
                    <td class="px-6 py-4">
                        <div class="w-12 h-12 rounded-lg bg-slate-900 border border-slate-700 overflow-hidden flex items-center justify-center">
                            @if(!empty($ap['imagen']))
                                <img src="{{ asset('images/autopartes/' . $ap['imagen']) }}" alt="Part" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-slate-700 text-lg"></i>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-white font-semibold">{{ $ap['nombre'] }}</span>
                            <span class="text-slate-500 text-xs">{{ $ap['sku'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $catName = collect($categoriasList)->firstWhere('id', $ap['categoria_id'])['nombre'] ?? 'ID: ' . $ap['categoria_id'];
                        @endphp
                        <span class="bg-slate-800 text-slate-300 text-[10px] uppercase font-bold px-2.5 py-1 rounded-md border border-slate-700">{{ $catName }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-300 font-medium">{{ $ap['marca'] ?? 'Generico' }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($ap['stock_disponible'] <= 10)
                            <span class="bg-red-500/10 text-red-500 font-bold text-sm px-3 py-1 rounded-lg border border-red-500/20">{{ $ap['stock_disponible'] }} uds</span>
                        @else
                            <span class="bg-emerald-500/10 text-emerald-400 font-bold text-sm px-3 py-1 rounded-lg border border-emerald-500/20">{{ $ap['stock_disponible'] }} uds</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-brand-400 font-bold">${{ number_format($ap['precio'], 2) }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="/inventario/editar/{{ $ap['id'] }}" class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <button onclick="confirmDelete({{ $ap['id'] }}, '{{ $ap['nombre'] }}')" class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-red-600 transition-colors inline-flex items-center justify-center">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                        <i class="fa-solid fa-box-open text-4xl mb-4 block opacity-20"></i>
                        No hay productos registrados en el inventario.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="p-4 border-t border-dark-border flex items-center justify-between text-sm text-slate-400 bg-dark-bg/50 rounded-b-2xl">
        <p>Total: {{ count($autopartes) }} productos</p>
    </div>
</div>

<!-- Category Modal -->
<div id="categoryModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="toggleCategoryModal()"></div>
    <div class="absolute inset-x-0 bottom-0 md:inset-auto md:top-1/2 md:left-1/2 md:-translate-x-1/2 md:-translate-y-1/2 w-full md:w-[450px] max-h-[90vh] flex flex-col">
        <div class="glass-card bg-slate-900 border border-slate-700/50 rounded-t-3xl md:rounded-3xl shadow-2xl overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-700/50 flex items-center justify-between bg-slate-800/50">
                <h3 class="text-white font-bold text-lg">Gestionar Categorías</h3>
                <button onclick="toggleCategoryModal()" class="w-8 h-8 rounded-full hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[400px]">
                <!-- Add New Category Form -->
                <form action="/inventario/categorias" method="POST" class="mb-8">
                    @csrf
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 block">Nueva Categoría</label>
                    <div class="flex gap-2">
                        <input type="text" name="nombre" placeholder="Ej. Motor, Frenos, Iluminación..." required
                            class="flex-grow bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all">
                        <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-lg shadow-brand-500/20">
                            Añadir
                        </button>
                    </div>
                </form>

                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4 block">Categorías Existentes</label>
                <div class="space-y-2">
                    @foreach($categoriasList as $cat)
                    <div class="flex items-center justify-between bg-slate-800/50 p-3 rounded-xl border border-slate-700/50 group">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded bg-slate-700 text-[10px] text-slate-400 flex items-center justify-center">#{{ $cat['id'] }}</span>
                            <span class="text-sm text-slate-200 font-medium">{{ $cat['nombre'] }}</span>
                        </div>
                        <span class="text-[10px] text-slate-500 italic opacity-0 group-hover:opacity-100 transition-opacity">ID: {{ $cat['id'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-dark-card border border-red-500/20 w-full max-w-md rounded-3xl shadow-2xl shadow-red-500/10 transform transition-all overflow-hidden">
            <!-- Header/Icon -->
            <div class="pt-8 pb-4 flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center mb-4 animate-pulse">
                    <i class="fa-solid fa-trash-can text-3xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-bold text-white">¿Eliminar Producto?</h3>
            </div>
            
            <!-- Body -->
            <div class="px-8 pb-8 text-center">
                <p class="text-slate-400 mb-6 leading-relaxed">
                    Estás a punto de eliminar <span id="deleteItemName" class="text-white font-bold"></span>.<br>
                    Esta acción es permanente y no se puede deshacer.
                </p>
                
                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white py-3 rounded-2xl font-bold transition-all border border-slate-700">
                        Cancelar
                    </button>
                    <button id="confirmDeleteBtn" class="flex-1 bg-red-600 hover:bg-red-500 text-white py-3 rounded-2xl font-bold transition-all shadow-lg shadow-red-600/20">
                        Sí, Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Buscador en tiempo real
    document.getElementById('inventorySearch').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('.inventory-row');
        
        rows.forEach(row => {
            const searchText = row.getAttribute('data-search');
            row.style.display = searchText.includes(value) ? '' : 'none';
        });
    });

    // Modal de Categorías
    function toggleCategoryModal() {
        const modal = document.getElementById('categoryModal');
        modal.classList.toggle('hidden');
        if(!modal.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    // Modal de Eliminación Personalizado
    let currentDeleteId = null;

    function confirmDelete(id, name) {
        currentDeleteId = id;
        document.getElementById('deleteItemName').innerText = `"${name}"`;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Vincular acción de borrado
        document.getElementById('confirmDeleteBtn').onclick = executeDelete;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteId = null;
    }

    function executeDelete() {
        if(!currentDeleteId) return;

        const btn = document.getElementById('confirmDeleteBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin"></i>';

        fetch(`/inventario/destroy/${currentDeleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                window.location.reload();
            } else {
                alert('Error al eliminar el producto');
                closeDeleteModal();
                btn.disabled = false;
                btn.innerText = 'Sí, Eliminar';
            }
        });
    }
</script>
@endpush
@endsection