<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACUIN – Reportes Empresariales</title>
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
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font-body); background-color: var(--color-bg); color: var(--color-text); min-height: 100vh; overflow-x: hidden; }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; height: var(--nav-h);
            background-color: var(--color-navbar); border-bottom: 0.5px solid rgba(255, 255, 255, 0.3);
            display: flex; align-items: center; padding: 0 24px; z-index: 100;
        }
        .navbar__logo { display: flex; align-items: center; gap: 10px; }
        .navbar__logo-icon { width: 54px; height: 56px; background: var(--color-logo-bg); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-size: 25px; }
        .navbar__nav { display: flex; gap: 8px; margin-left: 40px; }
        .navbar__nav-item { display: flex; align-items: center; gap: 8px; font-family: var(--font-display); font-size: 14px; padding: 10px 20px; border-radius: 8px; color: white; text-decoration: none; }
        .navbar__nav-item.active { background-color: var(--color-primary); }

        /* DASHBOARD LAYOUT */
        .dashboard-container { display: flex; padding-top: var(--nav-h); min-height: 100vh; gap: 30px; padding-left: 30px; padding-right: 30px; }

        /* SIDEBAR DE PARÁMETROS */
        .sidebar { width: 300px; flex-shrink: 0; display: flex; flex-direction: column; gap: 20px; padding-top: 30px; }
        .sidebar-card { background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); border-radius: 15px; padding: 20px; }
        .sidebar-title { font-family: var(--font-display); font-size: 12px; color: var(--color-muted); text-transform: uppercase; margin-bottom: 15px; letter-spacing: 1px; }
        
        .report-type-btn { 
            width: 100%; display: flex; align-items: center; gap: 12px; padding: 12px; 
            border-radius: 10px; color: white; margin-bottom: 8px; border: none; background: transparent; 
            font-family: var(--font-display); font-size: 13px; text-align: left; cursor: pointer; transition: 0.3s;
        }
        .report-type-btn.active { background: var(--color-primary); }
        .report-type-btn:hover:not(.active) { background: rgba(255,255,255,0.1); }

        .param-group { margin-bottom: 20px; }
        .param-label { display: flex; justify-content: space-between; font-family: var(--font-display); font-size: 11px; margin-bottom: 10px; }
        .param-label span:last-child { color: var(--color-primary); }
        
        .range-slider { width: 100%; accent-color: var(--color-primary); margin-bottom: 10px; }
        .range-dates { display: flex; justify-content: space-between; font-size: 10px; color: var(--color-subtle); font-family: var(--font-display); }

        /* MAIN CONTENT AREA */
        .main-content { flex: 1; padding-top: 30px; }
        .page-header__title { font-family: var(--font-display); font-size: 48px; text-transform: uppercase; line-height: 1; }
        .page-header__subtitle { color: var(--color-muted); font-size: 14px; margin-top: 8px; margin-bottom: 30px; }

        /* STATS GRID */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); border-radius: 15px; padding: 20px; position: relative; }
        .stat-label { font-family: var(--font-display); font-size: 12px; color: var(--color-muted); margin-bottom: 10px; }
        .stat-value { font-family: var(--font-display); font-size: 32px; }
        .stat-badge { position: absolute; top: 20px; right: 20px; padding: 4px 10px; border-radius: 6px; font-family: var(--font-display); font-size: 9px; }
        .badge--blue { background: rgba(57, 116, 224, 0.2); color: #3974e0; border: 1px solid #3974e0; }
        .badge--red { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444; }
        .badge--green { background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid #22c55e; }

        /* TABLE CARD */
        .table-card { background: var(--color-surface); border-radius: 15px; border: 1px solid var(--color-border); overflow: hidden; }
        .table-header { background: var(--color-card-head); padding: 20px; font-family: var(--font-display); font-size: 18px; border-bottom: 1px solid var(--color-border); }
        .report-table { width: 100%; border-collapse: collapse; }
        .report-table th { padding: 20px; text-align: left; font-family: var(--font-display); font-size: 13px; color: var(--color-muted); border-bottom: 1px solid var(--color-border); }
        .report-table td { padding: 18px 20px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .status-tag { padding: 4px 12px; border-radius: 20px; font-size: 9px; font-family: var(--font-display); text-transform: uppercase; }
        .status--entregado { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
        .status--cancelado { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

        .btn-generate { 
            width: 100%; background: var(--color-primary); color: white; border: none; padding: 15px; 
            border-radius: 30px; font-family: var(--font-display); font-size: 14px; cursor: pointer; margin-top: 10px;
            box-shadow: 0 4px 15px rgba(57, 116, 224, 0.3); transition: 0.3s;
        }
        .btn-generate:hover { transform: translateY(-2px); opacity: 0.9; }
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
            <a href="#" class="navbar__nav-item">Ordenes</a>
            <a href="#" class="navbar__nav-item active">Reportes</a>
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

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Tipo de Reporte</h3>
                <button class="report-type-btn active">📦 Pedidos</button>
                <button class="report-type-btn">📈 Ventas</button>
                <button class="report-type-btn">👥 Clientes</button>
            </div>

            <div class="sidebar-card">
                <h3 class="sidebar-title">PARÁMETROS</h3>
                <div class="param-group">
                    <div class="param-label">
                        <span>Rango de fecha</span>
                        <span>Últimos 30 Días</span>
                    </div>
                    <input type="range" class="range-slider">
                    <div class="range-dates">
                        <span>1 Enero, 2026</span>
                        <span>Hoy</span>
                    </div>
                </div>
                <div class="param-group">
                    <p class="param-label">Categoría de Producto</p>
                    <select style="width:100%; background:#333; color:white; border:none; padding:12px; border-radius:8px; font-family: var(--font-body);">
                        <option>Todas las Categorías</option>
                    </select>
                </div>
                <button class="btn-generate">Generar Reporte</button>
            </div>
        </aside>

        <main class="main-content">
            <h1 class="page-header__title">Reportes Empresariales</h1>
            <p class="page-header__subtitle">Genera y exporta análisis detallados de ventas, pedidos y clientes.</p>

            <div class="stats-grid">
                <div class="stat-card">
                    <p class="stat-label">Total de Ordenes</p>
                    <p class="stat-value">1,245</p>
                    <span class="stat-badge badge--blue">+ 24 Horas</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Pendiente de Cumplir</p>
                    <p class="stat-value">86</p>
                    <span class="stat-badge badge--red">Crítico</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Valor Promedio de Orden</p>
                    <p class="stat-value">$85.45</p>
                    <span class="stat-badge badge--green">↗ 4.1%</span>
                </div>
            </div>

            <div class="table-card">
                <div class="table-header">Vista Previa del Informe: Ventas (Enero 1 - Enero 24)</div>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Orden ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Pedido</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="color:var(--color-primary); font-weight:600;">#ORD-2938</td>
                            <td>Enero 12, 2026</td>
                            <td style="font-weight:600;">Juan Pérez</td>
                            <td>Aceite de motor (x2)</td>
                            <td><span class="status-tag status--entregado">Entregado</span></td>
                            <td style="font-weight:600;">$450.00</td>
                        </tr>
                        <tr>
                            <td style="color:var(--color-primary); font-weight:600;">#ORD-2939</td>
                            <td>Enero 12, 2026</td>
                            <td style="font-weight:600;">Juan Pérez</td>
                            <td>Batería LTH</td>
                            <td><span class="status-tag status--entregado">Entregado</span></td>
                            <td style="font-weight:600;">$2,100.00</td>
                        </tr>
                        <tr>
                            <td style="color:var(--color-primary); font-weight:600;">#ORD-2940</td>
                            <td>Enero 12, 2026</td>
                            <td style="font-weight:600;">Juan Pérez</td>
                            <td>Filtro de aire</td>
                            <td><span class="status-tag status--cancelado">Cancelado</span></td>
                            <td style="font-weight:600;">$150.00</td>
                        </tr>
                    </tbody>
                </table>
                <div style="padding: 20px; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.2);">
                    <p style="font-size: 13px; color: var(--color-muted);">Mostrando <span>1 a 5</span> de <span>100</span> resultados</p>
                    <div style="display: flex; gap: 10px;">
                        <button style="background:none; border:none; cursor:pointer; opacity:0.6;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                        <button style="background:none; border:none; cursor:pointer; opacity:0.6;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>