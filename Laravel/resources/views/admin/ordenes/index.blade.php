@extends('admin.layout.admin')

@section('title', 'Control de Pedidos')

@section('page-title', 'Control de Pedidos')
@section('page-subtitle', 'Gestiona y sigue las órdenes de los clientes.')

@section('content')
<div class="glass-card rounded-2xl border border-slate-700/50 flex flex-col">
    @if(session('success'))
        <div class="m-6 mb-0 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="m-6 mb-0 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation"></i>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Toolbar -->
    <form action="/ordenes" method="GET" class="p-6 border-b border-dark-border flex flex-col md:flex-row md:items-center justify-between gap-4 bg-dark-bg/50 rounded-t-2xl">
        <div class="relative w-full md:w-96">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ID Orden, Nombre cliente..." 
                   class="w-full bg-slate-800 border-none rounded-xl pl-11 pr-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium placeholder-slate-500">
        </div>
        
        <div class="flex items-center gap-3">
            <a href="/admin/reportes/pedidos" title="Ir a reportes detallados" class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all border border-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-chart-line"></i> Reportes
            </a>
            <div class="w-px h-8 bg-slate-700/50 mx-1"></div>
            
            <select name="estatus" onchange="this.form.submit()" 
                    class="bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none font-medium">
                <option value="todos" {{ request('estatus') == 'todos' ? 'selected' : '' }}>Status: Todos</option>
                <option value="pendiente" {{ request('estatus') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="surtido" {{ request('estatus') == 'surtido' ? 'selected' : '' }}>Surtido</option>
                <option value="enviado" {{ request('estatus') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="entregado" {{ request('estatus') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ request('estatus') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>

            <select name="fecha" onchange="this.form.submit()"
                    class="bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none font-medium">
                <option value="todos" {{ request('fecha') == 'todos' ? 'selected' : '' }}>Fecha: Todo</option>
                <option value="hoy" {{ request('fecha') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                <option value="semana" {{ request('fecha') == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                <option value="mes" {{ request('fecha') == 'mes' ? 'selected' : '' }}>Este Mes</option>
            </select>

            @if(request()->anyFilled(['search', 'estatus', 'fecha']))
                <a href="/ordenes" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all border border-red-500/20" title="Limpiar Filtros">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
        </div>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto rounded-b-2xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-dark-card/50 border-b border-dark-border text-xs uppercase tracking-wider text-slate-400 font-bold">
                    <th class="px-6 py-4">Orden ID</th>
                    <th class="px-6 py-4">Cliente (ID)</th>
                    <th class="px-6 py-4">Fecha de compra</th>
                    <th class="px-6 py-4">Monto</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-border">
                @forelse ($pedidos as $pedido)
                        @php
                            $rawEstatus = is_array($pedido['estatus']) ? ($pedido['estatus']['value'] ?? $pedido['estatus']) : $pedido['estatus'];
                            $estatus = strtolower(str_replace('PedidoStatusEnum.', '', $rawEstatus));
                            
                            // Determinar los colores según el estatus
                            if ($estatus === 'surtido') {
                                $colorClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                            } elseif ($estatus === 'enviado' || $estatus === 'entregado') {
                                $colorClass = 'bg-blue-500/10 text-blue-400 border-blue-500/20';
                            } elseif ($estatus === 'cancelado') {
                                $colorClass = 'bg-red-500/10 text-red-400 border-red-500/20';
                            } else {
                                $colorClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                            }
                        @endphp
                        <tr class="hover:bg-slate-800/30 transition-colors group">
                            <td class="px-6 py-4">
                                <a href="#" class="text-brand-400 font-bold hover:text-brand-300 transition-colors">#ORD-{{ str_pad($pedido['id'], 4, '0', STR_PAD_LEFT) }}</a>
                            </td>
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $usuariosMap[$pedido['usuario_id']] ?? 'Cliente' }} 
                                <span class="block text-xs font-normal text-slate-500">ID: {{ $pedido['usuario_id'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-400 text-sm">{{ \Carbon\Carbon::parse($pedido['fecha_creacion'])->format('d M, Y') }}</td>
                            <td class="px-6 py-4 font-bold text-white">${{ number_format($pedido['total'], 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="{{ $colorClass }} font-bold text-xs px-3 py-1.5 rounded-lg border uppercase">
                                    {{ $estatus }}
                                </span>
                            </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="/ordenes/update-status/{{ $pedido['id'] }}" method="POST" class="flex items-center gap-2 m-0 p-0">
                                    @csrf
                                    @method('PUT')
                                    <select name="estatus" class="bg-slate-800 border border-slate-700 rounded-lg px-2 py-1.5 text-xs text-white focus:outline-none focus:border-brand-500">
                                        <option value="pendiente" {{ $estatus === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="surtido" {{ $estatus === 'surtido' ? 'selected' : '' }}>Surtido</option>
                                        <option value="enviado" {{ $estatus === 'enviado' ? 'selected' : '' }}>Enviado</option>
                                        <option value="entregado" {{ $estatus === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                        <option value="cancelado" {{ $estatus === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-colors inline-flex items-center justify-center tooltip-trigger" title="Actualizar Status">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <button onclick="showOrderDetails({{ $pedido['id'] }})" class="w-8 h-8 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-brand-600 transition-colors inline-flex items-center justify-center tooltip-trigger" title="Ver detalle">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                            <i class="fa-solid fa-box-open text-2xl mb-2 opacity-50 block"></i>
                            No hay órdenes activas en el sistema.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="p-4 border-t border-dark-border flex items-center justify-between text-sm text-slate-400 bg-dark-bg/50 rounded-b-2xl">
        <p>Mostrando {{ count($pedidos) }} resultados</p>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 rounded-lg border border-slate-700 hover:bg-slate-700 hover:text-white transition-colors disabled:opacity-50" disabled>Anterior</button>
            <button class="px-3 py-1.5 rounded-lg border border-slate-700 hover:bg-slate-700 hover:text-white transition-colors disabled:opacity-50" disabled>Siguiente</button>
        </div>
    </div>
</div>

<!-- MODAL DE DETALLES (GLASSMORPHISM) -->
<div id="detailsModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="closeDetailsModal()"></div>
    
    <!-- Contenido del Modal -->
    <div class="relative w-full max-w-2xl bg-slate-900/90 border border-slate-700 rounded-3xl shadow-2xl overflow-hidden transform transition-all">
        <div class="p-6 border-b border-slate-700 flex items-center justify-between bg-gradient-to-r from-brand-600/10 to-transparent">
            <div>
                <h3 class="text-xl font-black text-white" id="modalTitle">Orden #ORD-0000</h3>
                <p class="text-xs text-slate-400" id="modalSubtitle">Cargando detalles...</p>
            </div>
            <button onclick="closeDetailsModal()" class="w-10 h-10 rounded-xl bg-slate-800 text-slate-400 hover:text-white hover:bg-red-500/20 transition-all flex items-center justify-center">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <div class="p-6">
            <div id="loadingState" class="py-20 text-center">
                <i class="fa-solid fa-circle-notch fa-spin text-4xl text-brand-500 mb-4"></i>
                <p class="text-slate-500 font-medium">Buscando en la base de datos...</p>
            </div>

            <div id="modalBody" class="hidden space-y-6">
                <!-- Info de Envío -->
                <div class="bg-slate-800/40 p-4 rounded-2xl border border-slate-700/50">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 font-black">Dirección de Envío</p>
                    <p class="text-sm text-slate-300" id="modalAddress">Calle Principal 123...</p>
                </div>

                <!-- Tabla de Productos -->
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 ml-1 font-black">Productos Solicitados</p>
                    <div class="overflow-hidden rounded-2xl border border-slate-800">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-800 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Cant.</th>
                                    <th class="px-4 py-3">Precio Unit.</th>
                                    <th class="px-4 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="itemsList" class="divide-y divide-slate-800 text-slate-300 bg-slate-900/40">
                                <!-- Se llena vía JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                    <span class="text-slate-400 font-medium italic">Total de la Orden</span>
                    <span class="text-2xl font-black text-white" id="modalTotal">$0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showOrderDetails(orderId) {
    const modal = document.getElementById('detailsModal');
    const modalBody = document.getElementById('modalBody');
    const loadingState = document.getElementById('loadingState');
    const itemsList = document.getElementById('itemsList');
    
    // Reset Modal
    modal.classList.remove('hidden');
    modalBody.classList.add('hidden');
    loadingState.classList.remove('hidden');
    document.getElementById('modalTitle').textContent = `#ORD-${orderId.toString().padStart(4, '0')}`;
    itemsList.innerHTML = '';

    fetch(`/ordenes/${orderId}/detalles`)
        .then(res => res.json())
        .then(data => {
            if(data.error) throw new Error(data.error);
            
            // Llenar datos
            document.getElementById('modalSubtitle').textContent = `Realizada el ${new Date(data.fecha_creacion).toLocaleDateString()}`;
            document.getElementById('modalAddress').textContent = data.direccion_envio;
            document.getElementById('modalTotal').textContent = `$${parseFloat(data.total).toLocaleString(undefined, {minimumFractionDigits: 2})}`;

            // Llenar productos
            data.detalles.forEach(item => {
                const nombreProducto = item.autoparte ? item.autoparte.nombre : `ID: ${item.autoparte_id}`;
                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-800/30 transition-colors";
                tr.innerHTML = `
                    <td class="px-4 py-3 font-medium">${nombreProducto}</td>
                    <td class="px-4 py-3">x${item.cantidad}</td>
                    <td class="px-4 py-3">$${item.precio_unitario.toFixed(2)}</td>
                    <td class="px-4 py-3 text-right font-bold text-white">$${(item.cantidad * item.precio_unitario).toFixed(2)}</td>
                `;
                itemsList.appendChild(tr);
            });

            loadingState.classList.add('hidden');
            modalBody.classList.remove('hidden');
        })
        .catch(err => {
            console.error(err);
            loadingState.innerHTML = `<p class="text-red-400">Error al cargar datos.</p>`;
        });
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.add('hidden');
}
</script>
@endpush