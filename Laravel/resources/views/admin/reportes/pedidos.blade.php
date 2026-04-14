@extends('admin.layout.admin')

@section('title', 'Reporte de Pedidos')
@section('page-title', 'Historial de Pedidos')
@section('page-subtitle', 'Consulte el histórico completo de todas las órdenes en el sistema.')

@section('content')
<div class="space-y-8">
    
    <!-- Filtros y KPIs -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar de Filtros -->
        <div class="lg:col-span-1 space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-slate-700/50">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-filter text-brand-500"></i> Filtros de Historial
                </h3>
                
                <form action="/admin/reportes/pedidos" method="GET" class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-500 ml-1">Desde</label>
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-500 ml-1">Hasta</label>
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all">
                    </div>

                    <div class="border-t border-slate-700/50 my-2"></div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-500 ml-1 font-bold">Estado del Pedido</label>
                        <select name="estatus" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer appearance-none">
                            <option value="todos" {{ request('estatus') == 'todos' ? 'selected' : '' }}>Mostrar Todos</option>
                            <option value="pendiente" {{ request('estatus') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="recibido" {{ request('estatus') == 'recibido' ? 'selected' : '' }}>Recibido</option>
                            <option value="surtido" {{ request('estatus') == 'surtido' ? 'selected' : '' }}>Surtido</option>
                            <option value="enviado" {{ request('estatus') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                            <option value="entregado" {{ request('estatus') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            <option value="cancelado" {{ request('estatus') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white py-3 rounded-2xl font-bold transition-all shadow-lg shadow-brand-500/20 mt-4 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-sync"></i> Actualizar Reporte
                    </button>
                    
                    @if(request()->anyFilled(['fecha_inicio', 'fecha_fin', 'estatus']))
                        <a href="/admin/reportes/pedidos" class="block text-center text-xs text-slate-500 hover:text-white transition-colors py-2">
                            Limpiar filtros
                        </a>
                    @endif

                    <div class="pt-4 border-t border-slate-700/50">
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mb-3 ml-1">Exportar Reporte</p>
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
                </form>
            </div>
        </div>

        <!-- KPIs y Tabla -->
        <div class="lg:col-span-3 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-3xl relative overflow-hidden group">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Volumen Total Pedidos</p>
                    <h4 class="text-3xl font-black text-white">{{ $kpis['total_pedidos'] }}</h4>
                    <p class="text-[10px] text-slate-400 mt-2 uppercase">Órdenes encontradas en el sistema</p>
                </div>
            </div>

            <div class="glass-card rounded-3xl overflow-hidden border border-slate-700/30">
                <div class="px-8 py-5 border-b border-slate-700/50 flex justify-between items-center bg-slate-800/20">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-database text-brand-400"></i> Registro de Historial
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-slate-500 font-bold border-b border-slate-700/30">
                                <th class="px-8 py-4">ID Pedido / Fecha</th>
                                <th class="px-8 py-4">Usuario</th>
                                <th class="px-8 py-4 text-center">Estatus</th>
                                <th class="px-8 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/30">
                            @forelse($pedidos as $p)
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-white font-bold">#ORD-{{ str_pad($p['id'], 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-[10px] text-slate-500">{{ \Carbon\Carbon::parse($p['fecha_creacion'])->format('d M, Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-xs text-slate-300 font-medium italic">ID de Usuario: {{ $p['usuario_id'] }}</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="text-[10px] uppercase font-black px-3 py-1 rounded-full border border-slate-700 text-slate-400 bg-slate-800/50">
                                        {{ $p['estatus'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-white text-sm">
                                    ${{ number_format($p['total'], 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-500 italic">
                                    No hay registros de pedidos en este periodo.
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

@push('scripts')
<script>
    // Función auxiliar para obtener fecha limpia
    function getExportDate() {
        return new Date().toISOString().split('T')[0];
    }

    // 1. Exportación a PDF (jsPDF + AutoTable)
    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4'); // Horizontal para mayor espacio
        const exportDate = getExportDate();
        
        doc.setFontSize(22);
        doc.setTextColor(30, 41, 59);
        doc.text("MACUIN - Reporte Histórico de Pedidos", 14, 22);
        
        doc.setFontSize(10);
        doc.setTextColor(100);
        doc.text(`Generado el: ${new Date().toLocaleString()}`, 14, 30);

        // Cuadro de Resumen
        const totalPedidos = document.querySelector('h4').innerText;
        doc.setFillColor(239, 246, 255); // Blue-50
        doc.roundedRect(14, 35, 270, 15, 3, 3, 'F');
        doc.setTextColor(37, 99, 235); // Blue-600
        doc.setFont(undefined, 'bold');
        doc.text(`TOTAL DE ÓRDENES ENCONTRADAS: ${totalPedidos}`, 20, 45);
        
        // Mapeo manual de datos
        const rows = [];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const cols = tr.querySelectorAll('td');
            if (cols.length >= 4) {
                const idRef = cols[0].querySelector('a') ? cols[0].querySelector('a').innerText.trim() : cols[0].innerText.trim();
                const fecha = cols[0].querySelector('span') ? cols[0].querySelector('span').innerText.trim() : '';
                const usuario = cols[1].innerText.trim().replace('ID de Usuario:', 'ID:');
                const estatus = cols[2].innerText.trim();
                const total = cols[3].innerText.trim();
                rows.push([idRef, fecha, usuario, estatus, total]);
            }
        });

        doc.autoTable({ 
            head: [['ID Orden', 'Fecha', 'Usuario', 'Estatus', 'Total']],
            body: rows,
            startY: 55,
            theme: 'grid',
            headStyles: { fillColor: [37, 99, 235], fontSize: 10 },
            styles: { fontSize: 8 }
        });
        
        doc.save(`Reporte_Pedidos_${exportDate}.pdf`);
    }

    // 2. Exportación a Excel
    function exportToExcel() {
        const rows = [['ID Orden', 'Fecha', 'Usuario', 'Estatus', 'Total']];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const cols = tr.querySelectorAll('td');
            if (cols.length >= 4) {
                const idRef = cols[0].querySelector('a') ? cols[0].querySelector('a').innerText.trim() : cols[0].innerText.trim();
                const fecha = cols[0].querySelector('span') ? cols[0].querySelector('span').innerText.trim() : '';
                const usuario = cols[1].innerText.trim();
                const estatus = cols[2].innerText.trim();
                const total = cols[3].innerText.trim();
                rows.push([idRef, fecha, usuario, estatus, total]);
            }
        });

        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(rows);
        XLSX.utils.book_append_sheet(wb, ws, "Historial");
        XLSX.writeFile(wb, `Reporte_Pedidos_${getExportDate()}.xlsx`);
    }

    // 3. Exportación a Word (Blob para estabilidad)
    function exportToWord() {
        const totalCount = document.querySelector('h4').innerText;
        const tableHtml = document.querySelector('table').outerHTML;
        
        const header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                       "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                       "xmlns='http://www.w3.org/TR/REC-html40'>"+
                       "<head><meta charset='utf-8'><title>Reporte Historial</title><style>"+
                       "body { font-family: sans-serif; padding: 20px; } "+
                       "table { border-collapse: collapse; width: 100%; border: 1px solid #000; } "+
                       "th, td { border: 1px solid #000; padding: 8px; text-align: left; } "+
                       "th { background-color: #2563eb; color: white; }"+
                       ".kpi { padding: 15px; background: #eff6ff; border: 1px solid #bfdbfe; margin-bottom: 20px; }"+
                       "</style></head><body>";
        const footer = "</body></html>";
        const body = "<h1>MACUIN - Reporte Histórico de Pedidos</h1>" + 
                     "<p>Generado el: " + new Date().toLocaleString() + "</p>" +
                     "<div class='kpi'><strong>VOLUMEN TOTAL: " + totalCount + " Pedidos</strong></div>" +
                     tableHtml;
                     
        const sourceHTML = header + body + footer;
        const blob = new Blob(['\ufeff', sourceHTML], { type: 'application/msword' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `Reporte_Pedidos_${getExportDate()}.doc`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }
</script>
@endpush
@endsection