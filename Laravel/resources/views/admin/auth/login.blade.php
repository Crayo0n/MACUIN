<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MACUIN – Login Interno</title>

    @vite(['resources/css/macuin.css', 'resources/css/login.css'])
</head>
<body>

    <div class="layout-two-columns">
        <div class="login-hero" style="background-image: url('{{ asset('images/bodega.png') }}'); background-size: cover; background-position: center;">
            <div class="login-hero-content">
                <div class="hero-logo">
                    <div class="hero-logo__icon">M</div>
                    <div class="hero-logo__text">MACUIN</div>
                </div>

                <div class="hero-tagline">
                    <p>Central de control</p>
                    <p class="highlight">Automatiza tus procesos</p>
                </div>

                <div class="hero-footer">
                    <div class="hero-footer__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="hero-footer__text">Sistema de Gestión de Autopartes</div>
                </div>
            </div>
        </div>
        <div class="login-form-col">
            <div class="login-card">
                <div class="login-card-header">
                    <div class="m-box">M</div>
                    <h2>Login Interno</h2>
                    <p style="font-family: var(--font-display); font-size: 11px; color: var(--color-muted);">Inicia sesión para acceder al panel de administración.</p>
                </div>

                <div class="login-card-body">
                    @if($errors->any())
                        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; padding: 12px; border-radius: 8px; font-size: 11px; margin-bottom: 20px;">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; padding: 12px; border-radius: 8px; font-size: 11px; margin-bottom: 20px; text-align: center;">
                            <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div style="background: rgba(34, 197, 94, 0.15); border: 1px solid #22c55e; color: #22c55e; padding: 12px; border-radius: 8px; font-size: 11px; margin-bottom: 20px; text-align: center;">
                            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="input-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                Correo Electrónico
                            </label>
                            <input type="email" name="email" class="input" placeholder="tu.correo@macuin.com" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label class="input-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Contraseña
                            </label>
                            <div style="position: relative;">
                                <input type="password" name="password" class="input" placeholder="••••••••">
                            </div>
                        </div>
                        <button type="submit" class="btn-login">Ingresar al Panel</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</body>
</html>