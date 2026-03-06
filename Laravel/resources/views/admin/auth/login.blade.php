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
        <div class="login-hero">
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
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="input-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                Correo Electrónico
                            </label>
                            <input type="email" class="input" placeholder="tu.correo@macuin.com" required>
                        </div>

                        <div class="form-group">
                            <label class="input-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Contraseña
                            </label>
                            <div style="position: relative;">
                                <input type="password" class="input" placeholder="••••••••" required>
                                <button type="button" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); opacity: 0.5;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></circle></svg>
                                </button>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-family: var(--font-display); font-size: 11px; color: white;">
                                <input type="checkbox" style="accent-color: var(--color-primary);"> Recordarme
                            </label>
                            <a href="#" style="font-family: var(--font-display); font-size: 11px; color: var(--color-logo-bg);">Olvidé mi contraseña</a>
                        </div>

                        <button type="submit" class="btn-login">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</body>
</html>