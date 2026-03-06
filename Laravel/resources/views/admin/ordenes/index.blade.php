<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACUIN – Control de Pedidos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+One&family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-bg: #010d2c;
            --color-surface: #1e1e1e;
            --color-navbar: #010d2c;
            --color-card-head: #091e57;
            --color-primary: #3974e0;
            --color-logo-bg: #0d3a8d;
            --color-text: #ffffff;
            --color-muted: #aaadb6;
            --color-subtle: #6c6c6c;
            --color-border: rgba(255, 255, 255, 0.15);
            --font-display: 'Rubik One', sans-serif;
            --font-body: 'Rubik', sans-serif;
            --nav-h: 86px;
            --radius-lg: 15px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font-body); background-color: var(--color-bg); color: var(--color-text); min-height: 100vh; }

        .navbar {
            position: fixed; top: 0; left: 0; right: 0; height: var(--nav-h);
            background-color: var(--color-navbar); border-bottom: 0.5px solid rgba(255, 255, 255, 0.3);
            display: flex; align-items: center; padding: 0 24px; z-index: 100;
        }
        .navbar__logo { display: flex; align-items: center; gap: 10px; }
        .navbar__logo-icon { 
            width: 54px; height: 56px; background-color: var(--color-logo-bg); 
            border-radius: var(--radius-lg); display: flex; align-items: center; 
            justify-content: center; font-family: var(--font-display); font-size: 25px; 
        }
        .navbar__nav { display: flex; gap: 8px; margin-left: 40px; }
        .navbar__nav-item { 
            display: flex; align-items: center; gap: 8px; font-family: var(--font-display); 
            font-size: 14px; padding: 10px 20px; border-radius: 8px; transition: 0.3s;
            text-decoration: none; color: white;
        }
        .navbar__nav-item.active { background-color: var(--color-primary); }
        .navbar__nav-item:hover:not(.active) { background-color: rgba(57, 116, 224, 0.2); }

        /* MAIN WRAPPER */
        .main-wrapper { padding-top: var(--nav-h); padding-bottom: 50px; }
        .page-header { padding: 40px 40px 20px; }
        .page-header__title { font-family: var(--font-display); font-size: 48px; text-transform: uppercase; }
        .page-header__subtitle { color: var(--color-muted); font-size: 14px; margin-top: 5px; }

        /* FILTROS */
        .filters-bar {
            display: flex; gap: 20px; padding: 0 40px 30px; align-items: center;
        }
        .search-container { position: relative; flex: 1; max-width: 600px; }
        .search-input {
            width: 100%; background-color: #333; border: none; border-radius: 12px;
            padding: 14px 14px 14px 45px; color: white; font-family: var(--font-body);
        }
        .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); opacity: 0.5; }

        .filter-select {
            background-color: #333; color: white; border: none; border-radius: 12px;
            padding: 14px 40px 14px 20px; font-family: var(--font-body);
            appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 15px center;
        }

        .table-card { margin: 0 40px; background-color: var(--color-surface); border-radius: 20px; overflow: hidden; border: 1px solid var(--color-border); }
        .orders-table { width: 100%; border-collapse: collapse; text-align: left; }
        .orders-table th { 
            background-color: transparent; padding: 20px; font-family: var(--font-display); 
            font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border);
        }
        .orders-table td { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 14px; }
        .orders-table tr:hover { background-color: rgba(255,255,255,0.03); transition: 0.2s; }
        .order-id { color: var(--color-primary); font-weight: 600; text-decoration: none; }

        .status-pill {
            display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; 
            border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;
        }
        .status--surtido { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
        .status--pendiente { background: rgba(234, 179, 8, 0.2); color: #eab308; }
        .status--enviado { background: rgba(57, 116, 224, 0.2); color: #3974e0; }
        .status--cancelado { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

        /* ACCIONES */
        .view-btn { 
            background: none; border: none; cursor: pointer; color: white; opacity: 0.7; 
            transition: 0.2s; 
        }
        .view-btn:hover { opacity: 1; transform: scale(1.1); }

        /* PAGINACIÓN */
        .table-footer { 
            display: flex; justify-content: space-between; align-items: center; 
            padding: 20px; background-color: rgba(0,0,0,0.2);
        }
        .pagination-text { font-size: 13px; color: var(--color-muted); }
        .pagination-text span { color: var(--color-primary); font-weight: 600; }
        .nav-arrows { display: flex; gap: 15px; }
        .arrow-btn { cursor: pointer; opacity: 0.6; transition: 0.2s; background: none; border: none; }
        .arrow-btn:hover { opacity: 1; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar__logo">
            <div class="navbar__logo-icon">M</div>
            <div class="navbar__logo-text">
                <span style="font-family: var(--font-display); font-size: 22px;">MACUIN</span>
                <span style="font-family: var(--font-display); font-size: 11px; color: var(--color-muted);">Autopartes Dist.</span>
            </div>
        </div>
        <div class="navbar__nav">
            <a href="#" class="navbar__nav-item">Inventario</a>
            <a href="#" class="navbar__nav-item active">Ordenes</a>
            <a href="#" class="navbar__nav-item">Reportes</a>
        </div>
        <div class="navbar__spacer" style="flex:1"></div>
        <div class="navbar__right">
            <div class="navbar__user">
                <div style="text-align: right; margin-right: 10px;">
                    <p style="font-size: 13px; font-weight: 600;">Mauricio Rodriguez</p>
                    <p style="font-size: 10px; color: var(--color-subtle);">Gerente General</p>
                </div>
                <div style="width: 46px; height: 46px; background: var(--color-logo-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">MR</div>
            </div>
        </div>
    </nav>

    <main class="main-wrapper">
        <header class="page-header">
            <h1 class="page-header__title">Control de Pedidos</h1>
            <p class="page-header__subtitle">Gestiona y sigue las ordenes de los clientes.</p>
        </header>

        <section class="filters-bar">
            <div class="search-container">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" class="search-input" placeholder="Buscar Orden por ID, Nombre del cliente ...">
            </div>
            <select class="filter-select"><option>Status: Todos</option></select>
            <select class="filter-select"><option>Fecha: Esta Semana</option></select>
        </section>

        <div class="table-card">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Orden ID</th>
                        <th>Cliente</th>
                        <th>Fecha de compra</th>
                        <th>Monto</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2938</a></td>
                        <td>Juan Pérez</td>
                        <td>14 de Enero de 2026</td>
                        <td style="font-weight: 500;">$1,245.00</td>
                        <td><span class="status-pill status--surtido">Surtido ▾</span></td>
                        <td><button class="view-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button></td>
                    </tr>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2939</a></td>
                        <td>Juan Pérez</td>
                        <td>14 de Enero de 2026</td>
                        <td style="font-weight: 500;">$1,245.00</td>
                        <td><span class="status-pill status--pendiente">Pendiente ▾</span></td>
                        <td><button class="view-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button></td>
                    </tr>
                    <tr>
                        <td><a href="#" class="order-id">#ORD-2940</a></td>
                        <td>Juan Pérez</td>
                        <td>14 de Enero de 2026</td>
                        <td style="font-weight: 500;">$1,245.00</td>
                        <td><span class="status-pill status--enviado">Enviado ▾</span></td>
                        <td><button class="view-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button></td>
                    </tr>
                </tbody>
            </table>
            <footer class="table-footer">
                <p class="pagination-text">Mostrando <span>1 a 5</span> de <span>100</span> resultados</p>
                <div class="nav-arrows">
                    <button class="arrow-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                    <button class="arrow-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                </div>
            </footer>
        </div>
    </main>

</body>
</html>