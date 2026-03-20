@extends('admin.layout.admin')

@section('title', 'Añadir nuevo Usuario')

@section('page-title', 'Añadir nuevo Usuario')
@section('page-subtitle', 'Llena los siguientes detalles para registrar un usuario al sistema')

@push('styles')
<style>
    .form-card {
        background-color: #111827;
        border-radius: var(--radius-lg);
        border: 1px solid rgba(255,255,255,0.07);
        padding: 32px 40px 40px;
    }

    .form-row { display: grid; gap: 28px; }
    .form-row--full { grid-template-columns: 1fr; }
    .form-row--half { grid-template-columns: 1fr 1fr; }

    .form-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.06);
        margin: 28px 0;
    }

    .upload-zone {
        border: 1.5px dashed rgba(255,255,255,0.18);
        border-radius: var(--radius-lg);
        background-color: rgba(255,255,255,0.02);
        padding: 40px 20px;
        display: flex; flex-direction: column; align-items: center; gap: 10px;
        cursor: pointer; transition: 0.2s;
    }

    .upload-zone:hover {
        border-color: var(--color-primary);
        background-color: rgba(57,116,224,0.04);
    }
    
    /* Toggle Switch Styles */
    .switch-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(255,255,255,0.1);
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: var(--color-primary);
    }
    input:checked + .slider:before {
        transform: translateX(20px);
    }
</style>
@endpush

@section('content')
    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 20px;">
        <a href="{{ url('/usuarios') }}" class="btn btn-secondary">Cancelar</a>
        <button class="btn btn-primary" type="button" onclick="document.getElementById('form-usuario').submit()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 00-8 0v2M12 11a4 4 0 100-8 4 4 0 000 8z" />
                <path d="M19 12h-6M16 15l3-3-3-3" />
            </svg>
            Guardar Usuario
        </button>
    </div>

    <div class="form-card">
        <form id="form-usuario" action="#" method="POST">
            @csrf

            <div class="form-row form-row--full">
                <div>
                    <label class="field-label" for="nombre">Nombre Completo</label>
                    <input id="nombre" type="text" class="input" placeholder="e.g. Juan Pérez">
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-row form-row--half">
                <div>
                    <label class="field-label" for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="input" placeholder="e.g. empleado@macuin.com">
                </div>
                <div>
                    <label class="field-label" for="rol">Rol</label>
                    <select id="rol" class="input" style="appearance: none;">
                        <option value="" disabled selected>Selecciona un Rol</option>
                        <option value="admin">Administrador</option>
                        <option value="gerente">Gerente</option>
                        <option value="empleado">Empleado de Mostrador</option>
                        <option value="almacen">Encargado de Almacén</option>
                    </select>
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-row form-row--half">
                <div>
                    <label class="field-label" for="password">Contraseña (Obligatorio)</label>
                    <input id="password" type="password" class="input" placeholder="Ingresa una contraseña segura">
                </div>
                <div>
                    <label class="field-label" for="estado">Estado de la cuenta</label>
                    <div class="switch-wrap">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                        <span style="font-family: var(--font-display); font-size: 13px; color: var(--color-subtle);">Activo (El usuario puede iniciar sesión)</span>
                    </div>
                </div>
            </div>

            <hr class="form-divider">

            <div>
                <label class="field-label">Fotografía de Perfil (Opcional)</label>
                <div class="upload-zone">
                    <div style="width: 46px; height: 46px; background: var(--color-logo-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <p style="font-family: var(--font-display); font-size: 14px; color: #fff;">Click para subir</p>
                    <p style="font-family: var(--font-display); font-size: 11px; color: var(--color-subtle);">SVG, PNG, JPG (MAX 800 x 800 px)</p>
                </div>
            </div>
        </form>
    </div>
@endsection
