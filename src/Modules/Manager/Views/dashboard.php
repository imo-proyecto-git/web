<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<!-- Tailwind Extensión (Ad-Hoc para igualar mockup) -->
<style>
    body { background-color: #f8f9fc; }
    .nav-link-active { color: #00113a; border-bottom: 3px solid #1a56db; font-weight: 700; padding-bottom: 1.2rem; }
    .nav-link { color: #6b7280; font-weight: 600; transition: color 0.2s; }
    .nav-link:hover { color: #00113a; }
    
    .sidebar-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; color: #4b5563; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; }
    .sidebar-link:hover { color: #00113a; }
    .sidebar-link .material-symbols-outlined { color: #6b7280; font-size: 1.25rem; transition: color 0.2s; }
    .sidebar-link:hover .material-symbols-outlined { color: #00113a; }
    
    .kpi-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); position: relative; overflow: hidden; }
    .kpi-card::before { content: ''; position: absolute; left: 0; top: 10%; bottom: 10%; width: 4px; border-radius: 0 4px 4px 0; }
    .kpi-border-dark::before { background-color: #00113a; }
    .kpi-border-emerald::before { background-color: #10b981; }
    .kpi-border-red::before { background-color: #ef4444; }

    .role-pill-admin { background-color: #00113a; color: white; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.6rem; font-weight: 700; letter-spacing: 0.05em; }
    .role-pill-supervisor { background-color: #e0e7ff; color: #3730a3; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.6rem; font-weight: 700; letter-spacing: 0.05em; }
    .role-pill-agente { background-color: #f3f4f6; color: #4b5563; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.6rem; font-weight: 700; letter-spacing: 0.05em; }

    .log-icon-success { background-color: #d1fae5; color: #059669; }
    .log-icon-danger { background-color: #fee2e2; color: #dc2626; }
    .log-icon-neutral { background-color: #f3f4f6; color: #4b5563; }
    .log-icon-warning { background-color: #dcfce3; color: #10b981; } /* as per visual */

    .global-status-banner { background-color: #031435; border-radius: 16px; color: white; padding: 2.5rem; }
    .global-status-box { background-color: rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 1rem 1.5rem; text-align: center; }
</style>

<!-- Top Navigation -->
<nav class="fixed top-0 w-full z-50 bg-white border-b border-gray-100 flex justify-between items-center px-10 h-[72px]">
    <div class="flex items-center gap-16 h-full">
        <span class="text-xl font-bold text-[#1a56db] tracking-tight font-headline">empresa<span class="text-[#00113a]">IMO</span></span>
        <div class="hidden md:flex gap-8 items-end h-full pt-6">
            <a class="nav-link-active text-sm uppercase tracking-wider" href="<?= config('app.url') ?>/manager/dashboard">Dashboard</a>
            <a class="nav-link text-sm uppercase tracking-wider pb-[1.2rem]" href="<?= config('app.url') ?>/manager/users">User Management</a>
            <a class="nav-link text-sm uppercase tracking-wider pb-[1.2rem]" href="<?= config('app.url') ?>/manager/roles">Roles & Permissions</a>
            <a class="nav-link text-sm uppercase tracking-wider pb-[1.2rem]" href="<?= config('app.url') ?>/manager/audit">System Logs</a>
        </div>
    </div>
    <div class="flex items-center gap-6">
        <div class="relative cursor-pointer">
            <span class="material-symbols-outlined text-gray-500 hover:text-gray-800 transition-colors">notifications</span>
            <span class="absolute top-0 right-0.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
        </div>
        <span class="material-symbols-outlined text-gray-500 hover:text-gray-800 transition-colors text-[28px] cursor-pointer">account_circle</span>
    </div>
</nav>

<div class="flex min-h-screen pt-[72px]">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#f8f9fc] flex flex-col py-8 px-8 border-r border-gray-100 sticky top-[72px] h-[calc(100vh-72px)] shrink-0">
        <div class="mb-8">
            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">SYSTEM OVERSIGHT</h4>
            <h2 class="text-[#00113a] font-black text-[22px] tracking-tight leading-none">Admin Panel</h2>
        </div>
        
        <nav class="flex flex-col gap-1 mb-auto">
            <a class="sidebar-link" href="<?= config('app.url') ?>/manager/audit"><span class="material-symbols-outlined">history_edu</span> Audit Trail</a>
            <a class="sidebar-link" href="<?= config('app.url') ?>/manager/audit/export"><span class="material-symbols-outlined">cloud_download</span> Export Data CSV</a>
            <a class="sidebar-link" href="<?= config('app.url') ?>/manager/marketing/campaigns/analytics"><span class="material-symbols-outlined">monitoring</span> Growth & Analytics</a>
            <a class="sidebar-link" href="<?= config('app.url') ?>/manager/marketing/campaigns/create"><span class="material-symbols-outlined">campaign</span> Launch Campaign</a>
        </nav>

        <div class="mt-auto flex flex-col gap-6">
            <a href="<?= config('app.url') ?>/manager/marketing/campaigns/create" class="w-full bg-[#00113a] hover:bg-[#1a2b5a] text-white py-3 rounded-lg font-semibold text-sm transition-colors shadow-md text-center flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">add_circle</span> New Campaign
            </a>
            <a href="<?= config('app.url') ?>/logout" class="flex items-center gap-3 text-gray-600 hover:text-red-500 transition-colors font-semibold text-sm">
                <span class="material-symbols-outlined text-xl">logout</span> Sign Out
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10 max-w-7xl">
        <header class="mb-10">
            <h1 class="text-4xl font-bold text-[#00113a] tracking-tight mb-2">Resumen del Sistema</h1>
            <p class="text-gray-500 text-[15px] font-medium">Estado actual de la infraestructura y métricas de seguridad en tiempo real.</p>
        </header>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <!-- Card 1 -->
            <div class="kpi-card kpi-border-dark pl-8">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">TOTAL LEADS</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-[#00113a]"><?= number_format($stats['total_leads']) ?></h3>
                    <span class="text-emerald-500 font-bold text-xs">Avanzando</span>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="kpi-card kpi-border-dark pl-8">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">SESIONES ACTIVAS</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-[#00113a]"><?= number_format($stats['active_sessions']) ?></h3>
                    <div class="flex items-center gap-1.5 ml-1">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                        <span class="text-emerald-500 font-bold text-xs">En vivo</span>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="kpi-card kpi-border-emerald pl-8">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">CUMPLIMIENTO</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-emerald-500"><?= number_format($stats['compliance_pct'], 1) ?>%</h3>
                    <span class="text-gray-400 font-bold text-[10px]">ISO 27001</span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="kpi-card kpi-border-red pl-8">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">CONTRATOS FIRMADOS</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-emerald-500"><?= number_format($stats['signed_contracts']) ?></h3>
                    <span class="text-emerald-500 font-bold text-xs">Ingreso Consolidado</span>
                </div>
            </div>
        </div>

        </div>

        <!-- Data Analysis Section: Conversion Funnel -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-10 text-center">
            <?php 
                $totalLeads = max($stats['total_leads'], 1);
                $signed = $stats['signed_contracts'];
                $convRate = ($signed / $totalLeads) * 100;
            ?>
            <div class="bg-white p-8 rounded-2xl border border-gray-100 flex flex-col items-center">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Captura (Leads)</p>
                <div class="w-full h-24 flex items-end justify-center px-4">
                    <div class="w-full bg-blue-600 h-full rounded-t-lg shadow-lg shadow-blue-500/20"></div>
                </div>
                <p class="text-xl font-black text-[#00113a] mt-4"><?= number_format($totalLeads) ?></p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-gray-100 flex flex-col items-center">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Pipeline Activo</p>
                <div class="w-full h-24 flex items-end justify-center px-4">
                    <div class="w-3/4 bg-blue-500 h-[70%] rounded-t-lg"></div>
                </div>
                <p class="text-xl font-black text-[#00113a] mt-4">70% <span class="text-xs text-gray-400">interés</span></p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-gray-100 flex flex-col items-center">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Emisión Legal</p>
                <div class="w-full h-24 flex items-end justify-center px-4">
                    <div class="w-1/2 bg-indigo-400 h-[45%] rounded-t-lg"></div>
                </div>
                <p class="text-xl font-black text-[#00113a] mt-4">45% <span class="text-xs text-gray-400">drafts</span></p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-emerald-100 bg-emerald-50/10 flex flex-col items-center">
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em] mb-4">Conversión Final</p>
                <div class="w-full h-24 flex items-end justify-center px-4">
                    <div class="w-1/3 bg-emerald-500 h-[<?= $convRate + 5 ?>%] rounded-t-lg shadow-lg shadow-emerald-500/20"></div>
                </div>
                <p class="text-xl font-black text-emerald-600 mt-4"><?= number_format($signed) ?> <span class="text-xs">Firmas</span></p>
            </div>
        </div>
        
            <!-- User Table Section -->
            <div class="w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col self-start">
                <div class="px-6 py-5 flex justify-between items-center border-b border-gray-50">
                    <h2 class="font-bold text-[#00113a] text-lg">Gestión Rápida de Usuarios</h2>
                    <a href="<?= config('app.url') ?>/manager/users" class="text-gray-500 text-sm font-semibold hover:text-[#00113a] flex items-center gap-1 transition-colors">
                        Ver todos <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
                <div class="overflow-x-auto p-2">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                <th class="px-6 py-4">USUARIO</th>
                                <th class="px-6 py-4 text-center">ROL</th>
                                <th class="px-6 py-4">ESTADO</th>
                                <th class="px-6 py-4 text-right">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach ($agents as $agent): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full <?= $agent['status'] === 'active' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' ?> flex items-center justify-center font-bold text-sm shrink-0 uppercase">
                                            <?= substr(explode('@', $agent['email'])[0], 0, 2) ?>
                                        </div>
                                        <div>
                                            <p class="text-[#00113a] font-bold text-[13px] capitalize"><?= explode('@', $agent['email'])[0] ?></p>
                                            <p class="text-gray-500 text-[11px]"><?= $agent['email'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="role-pill-<?= strtolower($agent['role'] ?? 'agente') ?> uppercase"><?= $agent['role'] ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full <?= $agent['status'] === 'active' ? 'bg-emerald-500' : 'bg-gray-400' ?>"></span>
                                        <span class="text-gray-600 text-xs font-semibold capitalize"><?= $agent['status'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-[#00113a]"><span class="material-symbols-outlined">more_vert</span></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($agents)): ?>
                                <tr><td colspan="4" class="text-center py-6 text-xs font-bold text-gray-400">No hay agentes bajo supervisión.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Logs Section -->
            <div class="w-full lg:w-1/3 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col self-start">
                <div class="px-6 py-5 flex items-center justify-between border-b border-gray-50">
                    <h2 class="font-bold text-[#00113a] text-lg">Seguridad y Logs</h2>
                    <span class="material-symbols-outlined text-[#00113a] text-xl">shield</span>
                </div>
                <div class="px-6 py-6 flex-1 space-y-6 overflow-y-auto max-h-[500px]">
                    <?php foreach($logs as $log): ?>
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg <?= strpos($log['action'], 'CREATE') !== false ? 'log-icon-success' : (strpos($log['action'], 'DELETE') !== false ? 'log-icon-danger' : 'log-icon-neutral') ?> flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[16px]">
                                <?= strpos($log['action'], 'LOGIN') !== false ? 'login' : (strpos($log['action'], 'USER') !== false ? 'person' : (strpos($log['action'], 'CONTRACT') !== false ? 'description' : 'shield')) ?>
                            </span>
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-[#00113a]"><?= str_replace('_', ' ', $log['action']) ?></p>
                            <p class="text-[12px] text-gray-500 mt-0.5"><?= $log['details'] ?></p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mt-1"><?= $log['user_email'] ?> • <?= date('H:i', strtotime($log['created_at'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <a href="<?= config('app.url') ?>/manager/audit" class="mt-2 w-full py-3 bg-white border border-gray-200 text-[#00113a] text-[11px] font-bold uppercase tracking-widest text-center hover:bg-gray-50 transition-colors rounded-lg block">
                        REVISAR AUDITORÍA COMPLETA
                    </a>
                </div>
            </div>
        </div>

        <!-- Global Status Banner -->
        <div class="global-status-banner flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="max-w-2xl">
                <h3 class="text-white font-bold text-2xl mb-3 leading-tight tracking-tight">Estado Global del Sistema</h3>
                <p class="text-indigo-200/80 text-[14px] leading-relaxed font-medium">
                    Todos los nodos de la región "US-East-1" están operando con una latencia inferior a 45ms. El próximo respaldo programado es en 2 horas.
                </p>
            </div>
            <div class="flex gap-4 flex-shrink-0">
                <div class="global-status-box min-w-[120px]">
                    <p class="text-[10px] text-indigo-300 font-bold uppercase tracking-widest mb-1.5">CPU LOAD</p>
                    <p class="text-white text-2xl font-bold">12%</p>
                </div>
                <div class="global-status-box min-w-[120px]">
                    <p class="text-[10px] text-indigo-300 font-bold uppercase tracking-widest mb-1.5">DISK OPS</p>
                    <p class="text-white text-2xl font-bold">Stable</p>
                </div>
            </div>
        </div>
        
        <!-- Extensión del Footer según mock (Integrado) -->
        <footer class="mt-16 border-t border-gray-200 pt-8 pb-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[11px] uppercase tracking-widest text-gray-400 font-bold">© 2024 ADMINBASTION IMO. ALL RIGHTS RESERVED.</p>
            <div class="flex gap-6">
                <a class="text-[11px] uppercase tracking-widest text-gray-400 hover:text-gray-600 font-bold transition-all" href="#">COMPLIANCE</a>
                <a class="text-[11px] uppercase tracking-widest text-gray-400 hover:text-gray-600 font-bold transition-all" href="#">SECURITY POLICY</a>
                <a class="text-[11px] uppercase tracking-widest text-gray-400 hover:text-gray-600 font-bold transition-all" href="#">TERMS OF SERVICE</a>
            </div>
        </footer>
    </main>
</div>

<?php // El footer base original está omitido visualmente para matchear el diseño del mockup, se integra nativamente HTML ?>
