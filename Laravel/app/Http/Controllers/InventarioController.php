<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InventarioController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://server_api:8080');
    }

    public function index()
    {
        $autopartes = [];
        $categoriasList = []; // Para el modal
        $kpis = [
            'total' => 0,
            'valor_total' => 0,
            'stock_critico' => 0,
            'categorias' => 0
        ];

        try {
            // Obtener autopartes
            $response = Http::timeout(5)->get($this->apiUrl . '/v1/autopartes/');
            if ($response->successful()) {
                $autopartes = $response->json();
            }

            // Obtener categorías reales para el modal y conteo
            $resCats = Http::timeout(5)->get($this->apiUrl . '/v1/categorias/');
            if ($resCats->successful()) {
                $categoriasList = $resCats->json();
                $kpis['categorias'] = count($categoriasList);
            }
            
            // Calcular KPIs dinámicos
            $kpis['total'] = count($autopartes);
            foreach ($autopartes as $ap) {
                $kpis['valor_total'] += ($ap['precio'] * $ap['stock_disponible']);
                if ($ap['stock_disponible'] <= 10) {
                    $kpis['stock_critico']++;
                }
            }
        } catch (\Exception $e) {
            // Silencio
        }

        return view('admin.inventario.index', compact('autopartes', 'kpis', 'categoriasList'));
    }

    public function create()
    {
        $categorias = [];
        try {
            $response = Http::get($this->apiUrl . '/v1/categorias/');
            if ($response->successful()) {
                $categorias = $response->json();
            }
        } catch (\Exception $e) {}

        return view('admin.inventario.crear', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Manejo de Imagen
        if ($request->hasFile('imagen_file')) {
            $image = $request->file('imagen_file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/autopartes'), $imageName);
            $data['imagen'] = $imageName;
        }

        try {
            $response = Http::post($this->apiUrl . '/v1/autopartes/', $data);
            
            if ($response->successful()) {
                return redirect('/inventario')->with('success', 'Producto creado exitosamente');
            }
        } catch (\Exception $e) {}

        return back()->with('error', 'No se pudo crear el producto');
    }

    public function edit($id)
    {
        $categorias = [];
        try {
            // Producto
            $response = Http::get($this->apiUrl . '/v1/autopartes/' . $id);
            // Categorías
            $resCats = Http::get($this->apiUrl . '/v1/categorias/');

            if ($response->successful()) {
                $producto = $response->json();
                $categorias = $resCats->successful() ? $resCats->json() : [];
                return view('admin.inventario.editar', compact('producto', 'categorias'));
            }
        } catch (\Exception $e) {}

        return redirect('/inventario')->with('error', 'Producto no encontrado');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // Manejo de Imagen
        if ($request->hasFile('imagen_file')) {
            // 1. Obtener producto actual para borrar imagen vieja
            try {
                $curr = Http::get($this->apiUrl . '/v1/autopartes/' . $id)->json();
                if (!empty($curr['imagen'])) {
                    $oldPath = public_path('images/autopartes/' . $curr['imagen']);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            } catch (\Exception $e) {}

            // 2. Guardar nueva
            $image = $request->file('imagen_file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/autopartes'), $imageName);
            $data['imagen'] = $imageName;
        }

        try {
            $response = Http::put($this->apiUrl . '/v1/autopartes/' . $id, $data);
            
            if ($response->successful()) {
                return redirect('/inventario')->with('success', 'Producto actualizado correctamente');
            }
        } catch (\Exception $e) {}

        return back()->with('error', 'Error al actualizar el producto');
    }
    public function destroy($id)
    {
        try {
            $response = Http::delete($this->apiUrl . '/v1/autopartes/' . $id);
            if ($response->successful()) {
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {}

        return response()->json(['success' => false], 400);
    }

    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        try {
            $response = Http::post($this->apiUrl . '/v1/categorias/', [
                'nombre' => $request->nombre
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Categoría añadida con éxito');
            }

            $error = $response->json()['detail'] ?? 'Error desconocido';
            return back()->with('error', 'Error de la API: ' . $error);

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo contactar con el servidor');
        }
    }
}
