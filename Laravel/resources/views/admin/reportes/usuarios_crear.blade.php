@extends('admin.layout.admin')

@section('title', 'Añadir nuevo Usuario')

@section('page-title', 'Añadir nuevo Usuario')
@section('page-subtitle', 'Llena los siguientes detalles para registrar un usuario al sistema')

@section('content')
    <div class="flex justify-end gap-3 mb-6">
        <a href="{{ url('/admin/reportes/usuarios') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-medium py-2.5 px-6 rounded-xl transition-colors border border-slate-700">
            Cancelar
        </a>
        <button class="bg-brand-600 hover:bg-brand-500 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-brand-500/25 transition-all flex items-center gap-2" type="button" onclick="document.getElementById('form-usuario').submit()">
            <i class="fa-solid fa-user-check"></i>
            Guardar Usuario
        </button>
    </div>

    <div class="glass-card rounded-2xl border border-slate-700/50 p-6 md:p-10 mb-8">
        <form id="form-usuario" action="#" method="POST">
            @csrf

            <!-- Section 1 -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2" for="nombre">Nombre Completo</label>
                    <input id="nombre" type="text" class="w-full bg-slate-800 border-none rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium placeholder-slate-500" placeholder="e.g. Juan Pérez">
                </div>
            </div>

            <hr class="border-t border-slate-700/50 my-8">

            <!-- Section 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2" for="email">Correo Electrónico</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input id="email" type="email" class="w-full bg-slate-800 border-none rounded-xl pl-11 pr-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium placeholder-slate-500" placeholder="e.g. empleado@macuin.com">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2" for="rol">Rol</label>
                    <div class="relative">
                        <select id="rol" class="w-full bg-slate-800 border-none rounded-xl pl-4 pr-10 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium appearance-none cursor-pointer">
                            <option value="" disabled selected>Selecciona un Rol</option>
                            <option value="admin">Administrador</option>
                            <option value="gerente">Gerente</option>
                            <option value="empleado">Empleado de Mostrador</option>
                            <option value="almacen">Encargado de Almacén</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none text-xs"></i>
                    </div>
                </div>
            </div>

            <hr class="border-t border-slate-700/50 my-8">

            <!-- Section 3 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2" for="password">Contraseña (Obligatorio)</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input id="password" type="password" class="w-full bg-slate-800 border-none rounded-xl pl-11 pr-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all font-medium placeholder-slate-500" placeholder="Ingresa una contraseña segura">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Estado de la cuenta</label>
                    <label class="flex items-center gap-4 cursor-pointer mt-3">
                        <div class="relative">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-brand-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-400">Activo (El usuario puede iniciar sesión)</span>
                    </label>
                </div>
            </div>

            <hr class="border-t border-slate-700/50 my-8">

            <!-- Upload Photo -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Fotografía de Perfil (Opcional)</label>
                <div class="border-2 border-dashed border-slate-700 hover:border-brand-500 bg-slate-800/30 hover:bg-brand-500/5 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 cursor-pointer transition-all group">
                    <div class="w-14 h-14 bg-slate-800 group-hover:bg-brand-500/20 text-slate-400 group-hover:text-brand-500 rounded-full flex items-center justify-center text-2xl transition-colors shadow-inner">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-bold text-white mb-1 tracking-wide">Click para subir</p>
                        <p class="text-xs font-medium text-slate-500">SVG, PNG, JPG (MAX 800 x 800 px)</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
