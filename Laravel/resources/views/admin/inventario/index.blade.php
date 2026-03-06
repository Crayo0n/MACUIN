<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MACUIN – Gestión de Inventario</title>
    @vite('resources/css/macuin.css')
    <style>

        /* ── Navbar ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--nav-h);
            background-color: var(--color-navbar);
            border-bottom: 0.5px solid rgba(255,255,255,0.15);
            border-radius: 0 0 10px 10px;
            display: flex;
            align-items: center;
            padding: 0 28px;
            z-index: 100;
            gap: 0;
        }

        .navbar__logo {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            text-decoration: none;
        }

        .navbar__logo-icon {
            width: 54px;
            height: 56px;
            background-color: var(--color-logo-bg);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 24px;
            color: #fff;
        }

        .navbar__logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .navbar__logo-text span:first-child {
            font-family: var(--font-display);
            font-size: 20px;
            color: #fff;
        }

        .navbar__logo-text span:last-child {
            font-family: var(--font-display);
            font-size: 10px;
            color: var(--color-muted);
        }

        .navbar__nav {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-left: 36px;
        }

        .navbar__nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-display);
            font-size: 13px;
            color: var(--color-text);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            transition: background 0.2s;
            text-decoration: none;
        }

        .navbar__nav-item:hover { background-color: rgba(57,116,224,0.12); }
        .navbar__nav-item.active { background-color: var(--color-primary); }
        .navbar__nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        .navbar__spacer { flex: 1; }

        .navbar__right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .navbar__bell {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            cursor: pointer;
        }

        .navbar__bell:hover { background-color: rgba(255,255,255,0.13); }
        .navbar__bell svg { width: 20px; height: 20px; }

        .navbar__divider {
            width: 1px;
            height: 44px;
            background-color: rgba(255,255,255,0.15);
        }

        .navbar__user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .navbar__user-info { text-align: right; }

        .navbar__user-name {
            font-family: var(--font-display);
            font-size: 12px;
            color: #fff;
        }

        .navbar__user-role {
            font-family: var(--font-display);
            font-size: 10px;
            color: var(--color-subtle);
        }

        .navbar__avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--color-logo-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 17px;
            color: #fff;
        }

        /* ── Wrapper principal ── */
        .main-wrapper {
            padding-top: var(--nav-h);
            min-height: 100vh;
        }

        /* ── Cabecera de página ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 28px 32px 0;
        }

        .page-header__left {}

        .page-header__title {
            font-family: var(--font-display);
            font-size: 42px;
            color: var(--color-text);
            line-height: 1.1;
        }

        .page-header__subtitle {
            font-family: var(--font-display);
            font-size: 12px;
            color: var(--color-muted);
            margin-top: 5px;
        }

        .page-header__right {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 8px;
        }

        /* ── Contenido ── */
        .page-content { padding: 20px 32px 40px; }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        /* Buscador */
        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 240px;
        }

        .search-wrap svg {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            stroke: var(--color-subtle);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            background-color: #1a1a2e;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-sm);
            padding: 10px 16px 10px 40px;
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--color-text);
            outline: none;
            transition: border-color 0.2s;
        }

        .search-input::placeholder { color: var(--color-subtle); }
        .search-input:focus { border-color: var(--color-primary); }

        /* Chips de filtro */
        .filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: var(--font-display);
            font-size: 11px;
            padding: 7px 14px;
            border-radius: 35px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .filter-chip.active {
            background-color: var(--color-primary);
            color: #fff;
            border: none;
        }

        .filter-chip.inactive {
            background-color: rgba(170,173,182,0.1);
            border: 1px solid rgba(170,173,182,0.35);
            color: var(--color-muted);
        }

        .filter-chip.inactive:hover {
            background-color: rgba(57,116,224,0.12);
            border-color: var(--color-primary);
            color: #fff;
        }

        .filter-chip svg { width: 9px; height: 9px; }

        /* Alerta stock bajo */
        .stock-alert {
            background-color: rgba(255,0,0,0.08);
            border: 1px solid rgba(255,0,0,0.25);
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .stock-alert__label {
            font-family: var(--font-display);
            font-size: 10px;
            color: var(--color-danger);
            letter-spacing: 0.05em;
        }

        .stock-alert__count {
            font-family: var(--font-display);
            font-size: 18px;
            color: var(--color-danger);
            line-height: 1;
        }

        /* Botón añadir */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--color-primary);
            color: #fff;
            font-family: var(--font-display);
            font-size: 13px;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
            white-space: nowrap;
            text-decoration: none;
            flex-shrink: 0;
        }

        .btn-add:hover { opacity: 0.88; }
        .btn-add svg { width: 15px; height: 15px; }

        /* ── Tabla ── */
        .inv-table-wrap {
            background-color: #111827;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255,255,255,0.07);
            overflow: hidden;
        }

        .inv-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inv-table thead tr {
            background-color: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .inv-table th {
            font-family: var(--font-display);
            font-size: 12px;
            color: var(--color-muted);
            padding: 16px 18px;
            text-align: left;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .inv-table td {
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--color-text);
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            vertical-align: middle;
        }

        .inv-table tbody tr:last-child td { border-bottom: none; }

        .inv-table tbody tr:hover { background-color: rgba(57,116,224,0.04); }

        .sku-cell {
            font-family: var(--font-display);
            font-size: 13px;
            color: var(--color-primary);
        }

        /* Thumbnail */
        .product-thumb {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.1);
            background-color: rgba(255,255,255,0.04);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-thumb svg { width: 20px; height: 20px; stroke: var(--color-subtle); }

        /* Categoría chip */
        .cat-chip {
            display: inline-block;
            font-family: var(--font-display);
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 20px;
            background-color: rgba(57,116,224,0.12);
            color: var(--color-primary);
            border: 1px solid rgba(57,116,224,0.25);
        }

        /* Botones de acción */
        .action-group { display: flex; gap: 8px; align-items: center; }

        .action-btn {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            transition: background 0.2s;
            text-decoration: none;
        }

        .action-btn svg { width: 15px; height: 15px; }

        .action-btn--edit { background-color: rgba(57,116,224,0.13); }
        .action-btn--edit svg { stroke: var(--color-primary); }
        .action-btn--edit:hover { background-color: rgba(57,116,224,0.28); }

        .action-btn--delete { background-color: rgba(239,68,68,0.1); }
        .action-btn--delete svg { stroke: #ef4444; }
        .action-btn--delete:hover { background-color: rgba(239,68,68,0.22); }

        /* ── Paginación ── */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .pagination__info {
            font-family: var(--font-body);
            font-size: 13px;
            color: var(--color-muted);
        }

        .pagination__info b { color: var(--color-primary); font-weight: 400; }

        .pagination__controls { display: flex; gap: 6px; }

        .pagination__btn {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            background-color: rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            transition: background 0.2s;
        }

        .pagination__btn:hover { background-color: var(--color-primary); }
        .pagination__btn svg  { width: 14px; height: 14px; stroke: #fff; }
    </style>
</head>
<body>

    <!-- ── Navbar ── -->
    <nav class="navbar">
        <a href="#" class="navbar__logo">
            <div class="navbar__logo-icon">M</div>
            <div class="navbar__logo-text">
                <span>MACUIN</span>
                <span>Autopartes Dist.</span>
            </div>
        </a>

        <nav class="navbar__nav">
            <a href="#" class="navbar__nav-item active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/>
                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
                </svg>
                Inventario
            </a>
            <a href="#" class="navbar__nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="2"/>
                    <path d="M9 12h6M9 16h4"/>
                </svg>
                Ordenes
            </a>
            <a href="#" class="navbar__nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Reportes
            </a>
        </nav>

        <div class="navbar__spacer"></div>

        <div class="navbar__right">
            <button class="navbar__bell" title="Notificaciones">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
            </button>
            <div class="navbar__divider"></div>
            <div class="navbar__user">
                <div class="navbar__user-info">
                    <div class="navbar__user-name">Mauricio Rodríguez</div>
                    <div class="navbar__user-role">Gerente General</div>
                </div>
                <div class="navbar__avatar">M</div>
            </div>
        </div>
    </nav>

    <!-- ── Contenido ── -->
    <div class="main-wrapper">

        <!-- Cabecera -->
        <div class="page-header">
            <div class="page-header__left">
                <h1 class="page-header__title">Gestión de Inventario</h1>
                <p class="page-header__subtitle">Gestiona el stock de autopartes y actualiza precios</p>
            </div>
        </div>

        <div class="page-content">

            <!-- Toolbar -->
            <div class="toolbar">

                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" class="search-input" placeholder="Buscar autopartes...">
                </div>

                <div class="filter-group">
                    <button class="filter-chip active">Todas las Categorías</button>
                    <button class="filter-chip inactive">
                        Frenos
                        <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5"/></svg>
                    </button>
                    <button class="filter-chip inactive">
                        Eléctrico
                        <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5"/></svg>
                    </button>
                </div>

                <div class="stock-alert">
                    <div class="stock-alert__label">STOCK BAJO</div>
                    <div class="stock-alert__count">23</div>
                </div>

                <a href="#" class="btn-add">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5"  y1="12" x2="19" y2="12"/>
                    </svg>
                    Añadir nueva Autoparte
                </a>

            </div>

            <!-- Tabla -->
            <div class="inv-table-wrap">
                <table class="inv-table">
                    <thead>
                        <tr>
                            <th>ID / SKU</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio unitario</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sku-cell">#SKU-5457</td>
                            <td>
                                <div class="product-thumb">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            </td>
                            <td>Freno de Disco</td>
                            <td>Freno para camionetas</td>
                            <td><span class="cat-chip">Frenos</span></td>
                            <td>$450.00</td>
                            <td>124 unidades</td>
                            <td>
                                <div class="action-group">
                                    <a href="#" class="action-btn action-btn--edit" title="Editar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="action-btn action-btn--delete" title="Eliminar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sku-cell">#SKU-5458</td>
                            <td><div class="product-thumb"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div></td>
                            <td>Alternador</td>
                            <td>Alternador remanufacturado</td>
                            <td><span class="cat-chip">Eléctrico</span></td>
                            <td>$890.00</td>
                            <td>56 unidades</td>
                            <td>
                                <div class="action-group">
                                    <a href="#" class="action-btn action-btn--edit" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                    <button class="action-btn action-btn--delete" title="Eliminar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sku-cell">#SKU-5459</td>
                            <td><div class="product-thumb"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div></td>
                            <td>Pastillas de Freno</td>
                            <td>Para sedán y compactos</td>
                            <td><span class="cat-chip">Frenos</span></td>
                            <td>$220.00</td>
                            <td>200 unidades</td>
                            <td>
                                <div class="action-group">
                                    <a href="#" class="action-btn action-btn--edit" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                    <button class="action-btn action-btn--delete" title="Eliminar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sku-cell">#SKU-5460</td>
                            <td><div class="product-thumb"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div></td>
                            <td>Batería 12V</td>
                            <td>Batería de ciclo profundo</td>
                            <td><span class="cat-chip" style="background:rgba(234,179,8,0.1);color:#eab308;border-color:rgba(234,179,8,0.25);">Eléctrico</span></td>
                            <td>$1,200.00</td>
                            <td style="color:#ef4444;">8 unidades</td>
                            <td>
                                <div class="action-group">
                                    <a href="#" class="action-btn action-btn--edit" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                    <button class="action-btn action-btn--delete" title="Eliminar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sku-cell">#SKU-5461</td>
                            <td><div class="product-thumb"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div></td>
                            <td>Amortiguador</td>
                            <td>Trasero universal</td>
                            <td><span class="cat-chip" style="background:rgba(139,92,246,0.1);color:#8b5cf6;border-color:rgba(139,92,246,0.25);">Suspensión</span></td>
                            <td>$650.00</td>
                            <td>34 unidades</td>
                            <td>
                                <div class="action-group">
                                    <a href="#" class="action-btn action-btn--edit" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                    <button class="action-btn action-btn--delete" title="Eliminar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sku-cell">#SKU-5462</td>
                            <td><div class="product-thumb"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div></td>
                            <td>Filtro de aceite</td>
                            <td>Compatible con Toyota</td>
                            <td><span class="cat-chip" style="background:rgba(34,197,94,0.1);color:#22c55e;border-color:rgba(34,197,94,0.25);">Motor</span></td>
                            <td>$85.00</td>
                            <td>310 unidades</td>
                            <td>
                                <div class="action-group">
                                    <a href="#" class="action-btn action-btn--edit" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                    <button class="action-btn action-btn--delete" title="Eliminar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sku-cell">#SKU-5463</td>
                            <td><div class="product-thumb"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div></td>
                            <td>Bujía NGK</td>
                            <td>Bujía de iridio</td>
                            <td><span class="cat-chip" style="background:rgba(249,115,22,0.1);color:#f97316;border-color:rgba(249,115,22,0.25);">Encendido</span></td>
                            <td>$120.00</td>
                            <td>145 unidades</td>
                            <td>
                                <div class="action-group">
                                    <a href="#" class="action-btn action-btn--edit" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                    <button class="action-btn action-btn--delete" title="Eliminar"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="pagination">
                    <p class="pagination__info">
                        Mostrando <b>1</b> a <b>7</b> de <b>100</b> resultados
                    </p>
                    <div class="pagination__controls">
                        <button class="pagination__btn" title="Anterior">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button class="pagination__btn" title="Siguiente">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>

</body>
</html>