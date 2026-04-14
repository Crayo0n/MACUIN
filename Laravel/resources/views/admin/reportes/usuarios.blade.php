@extends('admin.layout.admin')

@section('title', 'Reporte de Clientes')
@section('page-title', 'Inteligencia de Clientes')
@section('page-subtitle', 'Analiza la lealtad y el comportamiento de compra de tus usuarios registrados.')

@section('content')
<div class="space-y-8">
    
    <!-- Filtros y KPIs -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar de Acción -->
        <div class="lg:col-span-1 space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-purple-500/20">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-users-gear text-purple-400"></i> Acciones de Cliente
                </h3>
                
                <div class="space-y-4">
                    <button onclick="openUserModal()" class="w-full bg-purple-600 hover:bg-purple-500 text-white py-3.5 rounded-2xl font-black transition-all shadow-lg shadow-purple-500/20 flex items-center justify-center gap-2 mb-4">
                        <i class="fa-solid fa-plus-circle"></i> + Registrar Nuevo
                    </button>

                    <form action="/admin/reportes/usuarios" method="GET" class="space-y-2 mb-6">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Filtrar por Rol</label>
                        <div class="relative">
                            <select name="rol" onchange="this.form.submit()" 
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all cursor-pointer appearance-none font-medium">
                                <option value="todos" {{ request('rol') == 'todos' ? 'selected' : '' }}>Todos los Roles</option>
                                <option value="cliente" {{ request('rol') == 'cliente' ? 'selected' : '' }}>Clientes</option>
                                <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administradores</option>
                                <option value="ventas" {{ request('rol') == 'ventas' ? 'selected' : '' }}>Ventas</option>
                                <option value="almacen" {{ request('rol') == 'almacen' ? 'selected' : '' }}>Almacén</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none text-xs"></i>
                        </div>
                    </form>
                    
                    <div class="border-t border-slate-700/50 pt-4">
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mb-3 ml-1">Exportar Base de Datos</p>
                        <div class="flex gap-2">
                            <button onclick="exportToPDF()" class="flex-1 py-2 rounded-lg bg-slate-900/50 border border-slate-800 hover:bg-slate-800 text-slate-500 hover:text-white transition-all text-[10px] font-bold">
                                PDF
                            </button>
                            <button onclick="exportToExcel()" class="flex-1 py-2 rounded-lg bg-slate-900/50 border border-slate-800 hover:bg-slate-800 text-slate-500 hover:text-white transition-all text-[10px] font-bold">
                                XLSX
                            </button>
                            <button onclick="exportToWord()" class="flex-1 py-2 rounded-lg bg-slate-900/50 border border-slate-800 hover:bg-slate-800 text-slate-500 hover:text-white transition-all text-[10px] font-bold">
                                DOCX
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="lg:col-span-3 space-y-6">
            
            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $totalClientes = count($clientes);
                    $clientesConCompras = collect($clientes)->where('total_ordenes', '>', 0)->count();
                    $granTotalInvertido = collect($clientes)->sum('total_invertido');
                @endphp
                
                <div class="glass-card p-6 rounded-3xl border border-slate-700/50">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Registrados</p>
                    <h3 class="text-3xl font-black text-white">{{ $totalClientes }}</h3>
                </div>
            </div>

            <!-- Tabla -->
            <div class="glass-card rounded-3xl overflow-hidden border border-slate-700/30">
                <div class="px-8 py-6 border-b border-slate-700/50 bg-slate-800/20">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-users text-purple-400"></i> Análisis de Valor por Cliente
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-slate-500 font-bold border-b border-slate-700/30">
                                <th class="px-8 py-4">Cliente</th>
                                <th class="px-8 py-4 text-center">Rol</th>
                                <th class="px-8 py-4 text-center">Órdenes</th>
                                <th class="px-8 py-4 text-right">Inversión</th>
                                <th class="px-8 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/30 text-sm">
                            @forelse($clientes as $c)
                            <tr class="hover:bg-purple-500/[0.03] transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-purple-400">
                                            {{ strtoupper(substr($c['nombre'], 0, 2)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-white font-bold">{{ $c['nombre'] }}</span>
                                            <span class="text-[10px] text-slate-500">{{ $c['correo'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-full uppercase border {{ $c['rol'] == 'admin' ? 'bg-purple-500/10 text-purple-400 border-purple-500/20' : 'bg-blue-500/10 text-blue-400 border-blue-500/20' }}">
                                        {{ $c['rol'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center font-bold text-slate-300">
                                    {{ $c['total_ordenes'] }}
                                </td>
                                <td class="px-8 py-5 text-right font-black text-emerald-400">
                                    ${{ number_format($c['total_invertido'], 2) }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 text-center">
                                        <button type="button" 
                                                onclick="openDeleteModal({{ $c['id'] }}, '{{ $c['nombre'] }}')"
                                                class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all inline-flex items-center justify-center">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-slate-500 italic">
                                    No hay clientes registrados en el sistema.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Usuario -->
<div id="userModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="closeUserModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
        <div class="bg-slate-900 border border-slate-700 rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-8 border-b border-slate-800 flex justify-between items-center bg-slate-800/50">
                <div>
                    <h2 class="text-xl font-black text-white">Nuevo Usuario</h2>
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-1">Acceso Administrativo / Cliente</p>
                </div>
                <button onclick="closeUserModal()" class="w-10 h-10 rounded-full hover:bg-slate-700 transition-colors flex items-center justify-center text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <form action="/admin/reportes/usuarios" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Nombre Completo</label>
                        <input type="text" name="nombre" required placeholder="Ej. Mauricio Admin"
                               class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Correo Electrónico</label>
                        <input type="email" name="email" required placeholder="correo@ejemplo.com"
                               class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all font-medium">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Contraseña</label>
                            <input type="password" name="password" required placeholder="••••••••"
                                   class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Rol</label>
                            <select name="rol" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all cursor-pointer appearance-none font-medium">
                                <option value="cliente">Cliente</option>
                                <option value="admin">Administrador</option>
                                <option value="director">Director</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeUserModal()" class="flex-1 bg-slate-800 hover:bg-slate-700 text-slate-300 py-4 rounded-2xl font-bold transition-all border border-slate-700">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white py-4 rounded-2xl font-black transition-all shadow-lg shadow-purple-500/30">
                        Crear Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteConfirmModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="glass-card w-full max-w-sm rounded-[2.5rem] border border-red-500/20 shadow-2xl relative overflow-hidden text-white">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-500/10 rounded-full blur-3xl"></div>
            
            <div class="p-8 text-center relative">
                <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-500/30">
                    <i class="fa-solid fa-triangle-exclamation text-2xl text-red-400"></i>
                </div>
                
                <h3 class="text-xl font-black mb-2">¿Confirmar Eliminación?</h3>
                <p class="text-xs text-slate-400 leading-relaxed mb-8">
                    Estás a punto de eliminar permanentemente a <br>
                    <strong id="deleteUserName" class="text-red-400"></strong>.<br>
                    Esta acción no se puede deshacer.
                </p>

                <form id="deleteForm" method="POST" class="flex flex-col gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white py-4 rounded-2xl font-black transition-all shadow-lg shadow-red-500/30">
                        Sí, Eliminar Registro
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="w-full bg-slate-800/50 hover:bg-slate-800 text-slate-400 py-3 rounded-2xl font-bold transition-all border border-slate-700">
                        Cancelar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openUserModal() {
        document.getElementById('userModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openDeleteModal(userId, userName) {
        const modal = document.getElementById('deleteConfirmModal');
        const form = document.getElementById('deleteForm');
        const nameSpan = document.getElementById('deleteUserName');
        
        nameSpan.innerText = userName;
        form.action = `/admin/reportes/usuarios/${userId}`;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Cerrar con escape
    document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') {
            closeUserModal();
            closeDeleteModal();
        }
    });

    // Función auxiliar para obtener fecha limpia
    function getExportDate() {
        return new Date().toISOString().split('T')[0];
    }

    // 1. Exportación a PDF (jsPDF + AutoTable)
    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        const exportDate = getExportDate();
        
        doc.setFontSize(22);
        doc.setTextColor(30, 41, 59);
        doc.text("MACUIN - Reporte de Clientes", 14, 22);
        
        doc.setFontSize(10);
        doc.setTextColor(100);
        doc.text(`Generado el: ${new Date().toLocaleString()}`, 14, 30);

        // Mapeo manual de datos
        const rows = [];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const cols = tr.querySelectorAll('td');
            if (cols.length >= 4) {
                const nombreItem = cols[0].querySelector('.text-white');
                const nombre = nombreItem ? nombreItem.innerText.trim() : 'N/A';
                const correoItem = cols[0].querySelector('.text-slate-500');
                const correo = correoItem ? correoItem.innerText.trim() : 'N/A';
                const rol = cols[1].innerText.trim();
                const ordenes = cols[2].innerText.trim();
                const inversion = cols[3].innerText.trim();
                
                rows.push([`${nombre} (${correo})`, rol, ordenes, inversion]);
            }
        });

        doc.autoTable({ 
            head: [['Cliente', 'Rol', 'Órdenes', 'Inversión Total']],
            body: rows,
            startY: 40,
            theme: 'grid',
            headStyles: { fillColor: [126, 34, 206], fontSize: 10 }, // Purple-700
            styles: { fontSize: 9 },
            columnStyles: { 3: { halign: 'right' } }
        });
        
        doc.save(`Reporte_Clientes_${exportDate}.pdf`);
    }

    // 2. Exportación a Excel
    function exportToExcel() {
        const rows = [['Cliente', 'Correo', 'Rol', 'Órdenes', 'Inversión Total']];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const cols = tr.querySelectorAll('td');
            if (cols.length >= 4) {
                const nombreItem = cols[0].querySelector('.text-white');
                const nombre = nombreItem ? nombreItem.innerText.trim() : 'N/A';
                const correoItem = cols[0].querySelector('.text-slate-500');
                const correo = correoItem ? correoItem.innerText.trim() : 'N/A';
                const rol = cols[1].innerText.trim();
                const ordenes = cols[2].innerText.trim();
                const inversion = cols[3].innerText.trim();
                rows.push([nombre, correo, rol, ordenes, inversion]);
            }
        });

        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(rows);
        XLSX.utils.book_append_sheet(wb, ws, "Clientes");
        XLSX.writeFile(wb, `Reporte_Clientes_${getExportDate()}.xlsx`);
    }

    // 3. Exportación a Word (Blob para estabilidad)
    function exportToWord() {
        const tableHtml = document.querySelector('table').outerHTML;
        const header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                       "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                       "xmlns='http://www.w3.org/TR/REC-html40'>"+
                       "<head><meta charset='utf-8'><title>Reporte Clientes</title><style>"+
                       "body { font-family: sans-serif; padding: 20px; } table { border-collapse: collapse; width: 100%; border: 1px solid #000; } "+
                       "th, td { border: 1px solid #000; padding: 10px; text-align: left; } "+
                       "th { background-color: #7e22ce; color: white; }</style></head><body>";
        const footer = "</body></html>";
        const body = "<h1>MACUIN - Reporte de Inteligencia de Clientes</h1>" + 
                     "<p>Generado el: " + new Date().toLocaleString() + "</p>" +
                     tableHtml;
                     
        const sourceHTML = header + body + footer;
        const blob = new Blob(['\ufeff', sourceHTML], { type: 'application/msword' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = `Reporte_Clientes_${getExportDate()}.doc`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }
</script>
@endpush
@endsection