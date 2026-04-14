<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsuarioController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://server_api:8080');
    }

    /**
     * Store a newly created user via the API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rol' => 'required|string',
            'password' => 'required|string|min:4'
        ]);

        try {
            $response = Http::post($this->apiUrl . '/v1/usuarios/', [
                'nombre' => $request->nombre,
                'email' => $request->email,
                'rol' => $request->rol,
                'password' => $request->password
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Usuario registrado exitosamente.');
            }

            $error = $response->json();
            return back()->with('error', $error['detail'] ?? 'Error al registrar el usuario.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con la API: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user via the API.
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete($this->apiUrl . '/v1/usuarios/' . $id);

            if ($response->successful()) {
                return back()->with('success', 'Usuario eliminado correctamente.');
            }

            return back()->with('error', 'No se pudo eliminar el usuario.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servicio de usuarios.');
        }
    }
}
