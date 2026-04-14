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

    public function index()
    {
        $pedidos = [];
        $usuariosMap = [];
        try {
            $response = Http::timeout(5)->get($this->apiUrl . '/v1/pedidos/');
            if ($response->successful()) {
                $pedidos = $response->json();
            }
            
            // Obtener usuarios para mostrar su nombre en lugar del ID
            $resUsers = Http::timeout(5)->get($this->apiUrl . '/v1/usuarios/');
            if ($resUsers->successful()) {
                foreach ($resUsers->json() as $user) {
                    $usuariosMap[$user['id']] = $user['nombre'];
                }
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
}
