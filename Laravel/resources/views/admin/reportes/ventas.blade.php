@extends('admin.layout.admin')

@section('title', 'Reporte de Ventas')
@section('page-title', 'Reporte de Ventas (Ingresos)')
@section('page-subtitle', 'Consulte el flujo de caja real basado en pedidos completados y confirmados.')

@section('content')
<div class="space-y-8">
    
    <!-- Filtros y KPIs -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar de Filtros -->
        <div class="lg:col-span-1 space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-indigo-500/20">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-money-bill-trend-up text-indigo-400"></i> Filtro Financiero
                </h3>
                
                <form action="/admin/reportes/ventas" method="GET" class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-500 ml-1">Periodo Inicial</label>
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-500 ml-1">Periodo Final</label>
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-3 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-500/20 mt-4 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-sync"></i> Actualizar Reporte
                    </button>
                    
                    @if(request()->anyFilled(['fecha_inicio', 'fecha_fin']))
                        <a href="/admin/reportes/ventas" class="block text-center text-xs text-slate-500 hover:text-white transition-colors py-2">
                            Restablecer fecha
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
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group bg-indigo-600/5 border-indigo-500/20">
                    <div class="absolute -right-4 -top-4 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl"></div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Ingresos Reales Netos</p>
                    <h4 class="text-4xl font-black text-white">${{ number_format($kpis['total_ingresos'], 2) }}</h4>
                </div>
            </div>

            <div class="glass-card rounded-3xl overflow-hidden border border-slate-700/30">
                <div class="px-8 py-6 border-b border-slate-700/50 flex justify-between items-center bg-slate-800/20">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice text-indigo-400"></i> Desglose de Ventas Cerradas
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-slate-500 font-bold border-b border-slate-700/30">
                                <th class="px-8 py-4">Ref. Órden</th>
                                <th class="px-8 py-4">Fecha Venta</th>
                                <th class="px-8 py-4 text-center">Estado de Pago</th>
                                <th class="px-8 py-4 text-right">Importe</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/30">
                            @forelse($ventas as $v)
                            <tr class="hover:bg-indigo-500/[0.03] transition-colors">
                                <td class="px-8 py-5">
                                    <span class="text-white font-bold tracking-tight">#F-{{ str_pad($v['id'], 6, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-8 py-5 text-slate-300 text-sm">
                                    {{ \Carbon\Carbon::parse($v['fecha_creacion'])->format('d M, Y') }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase">
                                        Confirmado
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-white text-sm">
                                    ${{ number_format($v['total'], 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-500">
                                    No hay ventas cerradas registradas en este periodo.
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
    // Toggle para el menú de descargas
    function toggleDownloadMenu() {
        const menu = document.getElementById('downloadMenu');
        menu.classList.toggle('hidden');
        
        // Cerrar al hacer clic fuera
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('button');
            if (!btn || (!btn.onclick && !btn.getAttribute('onclick')?.includes('toggleDownloadMenu'))) {
                menu.classList.add('hidden');
            }
        }, { once: true, capture: true });
    }

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
        doc.setTextColor(30, 41, 59); // Slate-800
        doc.text("MACUIN - Reporte de Ventas", 14, 22);
        
        doc.setFontSize(10);
        doc.setTextColor(100);
        doc.text(`Fecha de generación: ${new Date().toLocaleString()}`, 14, 30);
        
        // Cuadro de Resumen (KPI)
        const ingresosText = document.querySelector('h4').innerText;
        doc.setFillColor(248, 250, 252); // Slate-50
        doc.roundedRect(14, 35, 180, 15, 3, 3, 'F');
        doc.setTextColor(79, 70, 229); // Indigo-600
        doc.setFont(undefined, 'bold');
        doc.text(`INGRESOS REALES NETOS: ${ingresosText}`, 20, 45);
        
        // Mapeo manual de datos para evitar "cosas raras" del HTML
        const rows = [];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const cols = tr.querySelectorAll('td');
            if (cols.length >= 4) {
                rows.push([
                    cols[0].innerText.trim(),
                    cols[1].innerText.trim(),
                    "Confirmado",
                    cols[3].innerText.trim()
                ]);
            }
        });

        doc.autoTable({ 
            head: [['Ref. Orden', 'Fecha Venta', 'Estado', 'Importe']],
            body: rows,
            startY: 55,
            theme: 'grid',
            headStyles: { fillColor: [79, 70, 229], fontSize: 10, halign: 'center' },
            styles: { fontSize: 9 },
            columnStyles: { 3: { halign: 'right' } }
        });
        
        doc.save(`Reporte_Ventas_${exportDate}.pdf`);
    }

    // 2. Exportación a Excel (SheetJS)
    function exportToExcel() {
        const rows = [['Ref. Orden', 'Fecha Venta', 'Estado', 'Importe']];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const cols = tr.querySelectorAll('td');
            if (cols.length >= 4) {
                rows.push([
                    cols[0].innerText.trim(),
                    cols[1].innerText.trim(),
                    "Confirmado",
                    cols[3].innerText.trim()
                ]);
            }
        });
        
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(rows);
        XLSX.utils.book_append_sheet(wb, ws, "Ventas");
        XLSX.writeFile(wb, `Reporte_Ventas_${getExportDate()}.xlsx`);
    }

    // 3. Exportación a Word (Blob para estabilidad)
    function exportToWord() {
        const ingresos = document.querySelector('h4').innerText;
        const tableHtml = document.querySelector('table').outerHTML;
        
        const header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                       "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                       "xmlns='http://www.w3.org/TR/REC-html40'>"+
                       "<head><meta charset='utf-8'><title>Reporte Ventas</title><style>"+
                       "body { font-family: sans-serif; padding: 20px; } "+
                       "table { border-collapse: collapse; width: 100%; border: 1px solid #000; } "+
                       "th, td { border: 1px solid #000; padding: 10px; text-align: left; } "+
                       "th { background-color: #4f46e5; color: white; }"+
                       ".kpi { padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 20px; }"+
                       "</style></head><body>";
        
        const footer = "</body></html>";
        const body = "<h1>MACUIN - Reporte de Ventas</h1>" +
                     "<p>Generado el: " + new Date().toLocaleString() + "</p>" +
                     "<div class='kpi'><strong>TOTAL INGRESOS: " + ingresos + "</strong></div>" + 
                     tableHtml;
                     
        const sourceHTML = header + body + footer;
        const blob = new Blob(['\ufeff', sourceHTML], { type: 'application/msword' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = `Reporte_Ventas_${getExportDate()}.doc`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    };
</script>

<style>
    @media print {
        aside, header, form, .bg-indigo-500\/5, .relative.group {
            display: none !important;
        }
        main {
            margin: 0 !important;
            padding: 0 !important;
        }
        .glass-card {
            border: 1px solid #ddd !important;
            background: white !important;
            color: black !important;
        }
        .text-white, .text-slate-300 { color: black !important; }
        .text-slate-400, .text-slate-500 { color: #555 !important; }
        body { background: white !important; }
    }
</style>
@endpush
@endsection