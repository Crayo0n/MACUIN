<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class ReportesController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://server_api:8080');
    }

    /**
     * Reporte de Pedidos (Historial Total)
     * Incluye TODOS los pedidos sin importar el estatus.
     */
    public function indexPedidos(Request $request)
    {
        $pedidos = [];
        $kpis = ['total_pedidos' => 0, 'total_monto' => 0];

        try {
            $response = Http::get($this->apiUrl . '/v1/pedidos/');
            if ($response->successful()) {
                $all = collect($response->json());
                
                $filtered = $all->filter(function($p) use ($request) {
                    if ($request->fecha_inicio && Carbon::parse($p['fecha_creacion'])->lt(Carbon::parse($request->fecha_inicio)->startOfDay())) return false;
                    if ($request->fecha_fin && Carbon::parse($p['fecha_creacion'])->gt(Carbon::parse($request->fecha_fin)->endOfDay())) return false;
                    
                    // Nuevo filtro por estatus
                    if ($request->estatus && $request->estatus !== 'todos') {
                        if (strtolower($p['estatus']) !== strtolower($request->estatus)) return false;
                    }
                    
                    return true;
                });

                $pedidos = $filtered->sortByDesc('fecha_creacion')->values()->all();
                $kpis['total_pedidos'] = count($pedidos);
                $kpis['total_monto'] = collect($pedidos)->sum('total');
            }
        } catch (\Exception $e) {}

        return view('admin.reportes.pedidos', compact('pedidos', 'kpis'));
    }

    /**
     * Reporte de Ventas (Solo lo Pagado/Cerrado)
     */
    public function indexVentas(Request $request)
    {
        $ventas = [];
        $kpis = ['total_ingresos' => 0, 'recuento_ventas' => 0];

        try {
            $response = Http::get($this->apiUrl . '/v1/pedidos/');
            if ($response->successful()) {
                $all = collect($response->json());
                
                // Filtrar por estados que representan VENTA REAL (Pagado/Enviado)
                $filtered = $all->filter(function($p) use ($request) {
                    if (in_array($p['estatus'], ['pendiente', 'cancelado'])) return false;
                    
                    if ($request->fecha_inicio && Carbon::parse($p['fecha_creacion'])->lt(Carbon::parse($request->fecha_inicio)->startOfDay())) return false;
                    if ($request->fecha_fin && Carbon::parse($p['fecha_creacion'])->gt(Carbon::parse($request->fecha_fin)->endOfDay())) return false;
                    return true;
                });

                $ventas = $filtered->sortByDesc('fecha_creacion')->values()->all();
                $kpis['recuento_ventas'] = count($ventas);
                $kpis['total_ingresos'] = collect($ventas)->sum('total');
            }
        } catch (\Exception $e) {}

        return view('admin.reportes.ventas', compact('ventas', 'kpis'));
    }

    /**
     * Reporte de Clientes (Análisis de Actividad)
     */
    public function indexUsuarios(Request $request)
    {
        $clientes = [];
        try {
            $resUsers = Http::get($this->apiUrl . '/v1/usuarios/');
            $resPedidos = Http::get($this->apiUrl . '/v1/pedidos/');
            
            if ($resUsers->successful() && $resPedidos->successful()) {
                $allUsers = collect($resUsers->json());
                $pedidos = collect($resPedidos->json());

                // Filtrar por rol (siempre excluir admins por seguridad)
                $filteredUsers = $allUsers->filter(function($u) use ($request) {
                    if (strtolower($u['rol'] ?? '') === 'admin') return false;
                    
                    if ($request->rol && $request->rol !== 'todos') {
                        return strtolower($u['rol']) === strtolower($request->rol);
                    }
                    return true;
                });

                foreach ($filteredUsers as $u) {
                    $userPedidos = $pedidos->where('usuario_id', $u['id']);
                    $clientes[] = [
                        'id' => $u['id'],
                        'nombre' => $u['nombre'],
                        'correo' => $u['email'],
                        'rol' => $u['rol'],
                        'total_ordenes' => $userPedidos->count(),
                        'total_invertido' => $userPedidos->sum('total'),
                        'ultima_compra' => $userPedidos->max('fecha_creacion')
                    ];
                }
            }
        } catch (\Exception $e) {}

        return view('admin.reportes.usuarios', compact('clientes'));
    }
}
