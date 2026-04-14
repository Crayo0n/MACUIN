<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://server_api:8080');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        try {
            $response = Http::post($this->apiUrl . '/v1/usuarios/login', [
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ]);

            if ($response->successful()) {
                $user = $response->json();
                
                // Validar que el rol sea administrativo
                $rolesPermitidos = ['admin', 'ventas', 'almacen'];
                $userRol = is_array($user['rol']) ? ($user['rol']['value'] ?? $user['rol']) : $user['rol'];
                $userRol = strtolower(str_replace('RoleEnum.', '', $userRol));

                if (!in_array($userRol, $rolesPermitidos)) {
                    return back()->with('error', 'No tienes permisos para acceder al panel de administración.');
                }

                // Guardar en la sesión de Laravel
                Session::put('admin_user', $user);
                Session::put('is_logged_in', true);

                return redirect('/inventario')->with('success', 'Bienvenido al panel de control, ' . $user['nombre']);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servicio de autenticación.');
        }

        return back()->with('error', 'Credenciales incorrectas. Inténtalo de nuevo.');
    }

    public function logout()
    {
        Session::forget(['admin_user', 'is_logged_in']);
        return redirect('/login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
