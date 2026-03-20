@extends('admin.layout.reportes')

@section('title', 'Reporte de Clientes - MACUIN')

@push('report-styles')
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: rgba(255,255,255,0.05); border: 1px solid var(--color-border); border-radius: 15px; padding: 20px; position: relative; }
    .stat-label { font-family: var(--font-display); font-size: 12px; color: var(--color-muted); margin-bottom: 10px; }
    .stat-value { font-family: var(--font-display); font-size: 28px; color: #fff; }
    
    .stat-badge { position: absolute; top: 20px; right: 20px; padding: 4px 10px; border-radius: 6px; font-family: var(--font-display); font-size: 9px; }
    .badge--trend { background: rgba(57, 116, 224, 0.2); color: #3974e0; border: 1px solid #3974e0; }
    .badge--top { background: rgba(147, 51, 234, 0.2); color: #a855f7; border: 1px solid #a855f7; }
    .badge--stable { background: rgba(107, 114, 128, 0.2); color: #9ca3af; border: 1px solid #9ca3af; }

    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 9px; font-family: var(--font-display); background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid #22c55e; }

    .btn-generate { 
        width: 100%; background: var(--color-primary); color: white; border: none; padding: 15px; 
        border-radius: 30px; font-family: var(--font-display); font-size: 14px; cursor: pointer; margin-top: 10px;
        box-shadow: 0 4px 15px rgba(57, 116, 224, 0.3); transition: 0.3s;
    }
</style>
@endpush

@section('sidebar-filters')
    <div class="sidebar-card">
        <h3 class="sidebar-title">PARÁMETROS</h3>
        <div class="param-group" style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">
                <span>Rango de fecha</span>
                <span style="color: var(--color-primary);">Últimos 30 Días</span>
            </div>
            <input type="range" style="width: 100%; accent-color: var(--color-primary);">
            <div style="display: flex; justify-content: space-between; font-size: 10px; color: var(--color-subtle); font-family: var(--font-display); margin-top: 5px;">
                <span>1 Enero, 2026</span>
                <span>Hoy</span>
            </div>
        </div>
        <div class="param-group">
            <p style="font-family: var(--font-display); font-size: 11px; margin-bottom: 10px;">Categoría de Clientes</p>
            <select style="width:100%; background:#333; color:white; border:none; padding:12px; border-radius:8px; font-family: var(--font-body);">
                <option>Todos los Clientes</option>
                <option>Minoristas</option>
                <option>Distribuidores</option>
            </select>
        </div>
        <button class="btn-generate">Generar Reporte</button>
    </div>
@endsection

@section('report-body')
    <h1 class="page-header__title" style="font-size: 48px; margin-bottom: 8px;">Reportes Empresariales</h1>
    <p class="page-header__subtitle" style="margin-bottom: 30px;">Genera y exporta análisis detallados de ventas, pedidos y clientes.</p>

    <div class="stats-grid">
        <div class="stat-card">
            <p class="stat-label">Total de Clientes</p>
            <p class="stat-value">1,000</p>
            <span class="stat-badge badge--trend">📈 12.5%</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Vendedor TOP</p>
            <p class="stat-value" style="font-size: 24px;">Juan Pérez</p>
            <span class="stat-badge badge--top">TOP</span>
        </div>
        <div class="stat-card">
            <p class="stat-label">Usuarios Activos</p>
            <p class="stat-value">650</p>
            <span class="stat-badge badge--stable">➖ 0.2%</span>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-family: var(--font-display); font-size: 20px;">Directorio de Clientes</h2>
        <a href="{{ url('/usuarios/crear') }}" style="background: var(--color-primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-family: var(--font-display); font-size: 13px; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nuevo Cliente
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @php
            $users = [
                ['name' => 'Juan Pérez', 'email' => 'juanperez@gmail.com', 'initials' => 'JP', 'date' => '14 Ene, 2026', 'status' => 'ACTIVE', 'color' => 'var(--color-primary)'],
                ['name' => 'María López', 'email' => 'm.lopez@empresa.com', 'initials' => 'ML', 'date' => '22 Feb, 2026', 'status' => 'ACTIVE', 'color' => '#a855f7'],
                ['name' => 'Carlos Estrada', 'email' => 'carlos.e@outlook.com', 'initials' => 'CE', 'date' => '05 Mar, 2026', 'status' => 'INACTIVE', 'color' => '#ef4444'],
                ['name' => 'Ana Martínez', 'email' => 'ana.martinez@gmail.com', 'initials' => 'AM', 'date' => '10 Mar, 2026', 'status' => 'ACTIVE', 'color' => '#22c55e'],
                ['name' => 'Empresa XYZ', 'email' => 'compras@xyz.com', 'initials' => 'EX', 'date' => '15 Mar, 2026', 'status' => 'PENDING', 'color' => '#eab308']
            ];
        @endphp

        @foreach($users as $user)
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--color-border); border-radius: 16px; padding: 30px 25px; text-align: center; position: relative; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor='{{ $user['color'] }}'; this.style.transform='translateY(-3px)';" onmouseout="this.style.borderColor='var(--color-border)'; this.style.transform='translateY(0)';">
            <span class="status-pill" style="position: absolute; top: 20px; right: 20px; font-weight: bold; background: {{ $user['status'] == 'ACTIVE' ? 'rgba(34,197,94,0.1)' : ($user['status'] == 'INACTIVE' ? 'rgba(239,68,68,0.1)' : 'rgba(234,179,8,0.1)') }}; color: {{ $user['status'] == 'ACTIVE' ? '#22c55e' : ($user['status'] == 'INACTIVE' ? '#ef4444' : '#eab308') }}; border: none; padding: 6px 12px; letter-spacing: 0.5px;">{{ $user['status'] }}</span>
            
            <div style="width: 75px; height: 75px; background: {{ str_replace(')', ', 0.1)', str_replace('var(--color-primary)', 'rgba(57,116,224', $user['color'])) }}; color: {{ $user['color'] }}; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 26px; font-weight: bold; font-family: var(--font-display); margin: 0 auto 15px;">
                {{ $user['initials'] }}
            </div>
            
            <h3 style="font-family: var(--font-display); font-size: 19px; margin-bottom: 6px; color: #fff;">{{ $user['name'] }}</h3>
            <p style="font-size: 13px; color: {{ $user['color'] }}; margin-bottom: 15px; font-weight: 500;">{{ $user['email'] }}</p>
            <p style="font-size: 12px; color: var(--color-muted); margin-bottom: 25px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px; margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Registrado el {{ $user['date'] }}</p>
            
            <div style="display: flex; gap: 10px; padding-top: 18px; border-top: 1px solid rgba(255,255,255,0.05);">
                <button style="flex: 1; background: rgba(255,255,255,0.05); border: none; padding: 10px; border-radius: 8px; color: #fff; cursor: pointer; font-size: 12px; font-family: var(--font-display); transition: 0.2s;">PERFIL</button>
                <button style="flex: 1; background: rgba(57,116,224,0.1); border: 1px solid rgba(57,116,224,0.3); padding: 10px; border-radius: 8px; color: var(--color-primary); cursor: pointer; font-size: 12px; font-family: var(--font-display); transition: 0.2s;">MENSAJE</button>
            </div>
        </div>
        @endforeach
    </div>
@endsection