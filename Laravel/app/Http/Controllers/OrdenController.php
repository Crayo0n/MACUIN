<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrdenController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://server_api:8080');
    }

    public function index(Request $request)
    {
        $pedidos = [];
        $usuariosMap = [];
        try {
            $response = Http::timeout(5)->get($this->apiUrl . '/v1/pedidos/');
            if ($response->successful()) {
                $allPedidos = collect($response->json());
                
                // 1. Obtener usuarios para el mapa (necesario para buscar por nombre)
                $resUsers = Http::timeout(5)->get($this->apiUrl . '/v1/usuarios/');
                if ($resUsers->successful()) {
                    foreach ($resUsers->json() as $user) {
                        $usuariosMap[$user['id']] = $user['nombre'];
                    }
                }

                // 2. Aplicar Filtros Dinámicos
                $filtered = $allPedidos->filter(function($p) use ($request, $usuariosMap) {
                    // Filtro por Búsqueda (ID o Nombre)
                    if ($request->search) {
                        $term = strtolower($request->search);
                        $userName = strtolower($usuariosMap[$p['usuario_id']] ?? '');
                        $orderId = (string)$p['id'];
                        if (!str_contains($userName, $term) && !str_contains($orderId, $term)) return false;
                    }

                    // Filtro por Estatus
                    if ($request->estatus && $request->estatus !== 'todos') {
                        $currentStatus = strtolower(str_replace('PedidoStatusEnum.', '', (is_array($p['estatus']) ? $p['estatus']['value'] : $p['estatus'])));
                        if ($currentStatus !== strtolower($request->estatus)) return false;
                    }

                    // Filtro por Fecha
                    if ($request->fecha) {
                        $fechaPedido = \Illuminate\Support\Carbon::parse($p['fecha_creacion']);
                        if ($request->fecha === 'hoy' && !$fechaPedido->isToday()) return false;
                        if ($request->fecha === 'semana' && !$fechaPedido->isCurrentWeek()) return false;
                        if ($request->fecha === 'mes' && !$fechaPedido->isCurrentMonth()) return false;
                    }

                    return true;
                });

                $pedidos = $filtered->sortByDesc('fecha_creacion')->values()->all();
            }
        } catch (\Exception $e) {
        }

        return view('admin.ordenes.index', compact('pedidos', 'usuariosMap'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estatus' => 'required|string',
        ]);

        try {
            $response = Http::put($this->apiUrl . '/v1/pedidos/' . $id . '/estatus', [
                'estatus' => $request->estatus
            ]);

            if ($response->successful()) {
                return back()->with('success', 'El estado de la orden #ORD-'.str_pad($id, 4, "0", STR_PAD_LEFT).' ha sido actualizado a ' . strtoupper($request->estatus));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servicio de órdenes.');
        }

        return back()->with('error', 'No se pudo actualizar el estado de la orden.');
    }

    /**
     * Obtiene los detalles de una orden específica (incluyendo productos)
     */
    public function getDetails($id)
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl . '/v1/pedidos/' . $id);
            
            if ($response->successful()) {
                $pedido = $response->json();
                
                // Enriquecer con nombres de productos si es necesario o enviar directo
                // Para este caso, el schema PedidoOut en FastAPI ya debería traer los detalles
                return response()->json($pedido);
            }
            
            return response()->json(['error' => 'No se encontró la orden'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de conexión con la API'], 500);
        }
    }
}
