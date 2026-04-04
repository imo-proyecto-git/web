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
            <a class="nav-link text-sm uppercase tracking-wider pb-[1.2rem]" href="#">Settings</a>
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
            <a class="sidebar-link" href="#"><span class="material-symbols-outlined">history_edu</span> Audit Trail</a>
            <a class="sidebar-link" href="#"><span class="material-symbols-outlined">security</span> Security Center</a>
            <a class="sidebar-link" href="#"><span class="material-symbols-outlined">cloud_download</span> Data Export</a>
            <a class="sidebar-link" href="#"><span class="material-symbols-outlined">vpn_key</span> API Keys</a>
            <a class="sidebar-link" href="#"><span class="material-symbols-outlined">help</span> Support</a>
        </nav>

        <div class="mt-auto flex flex-col gap-6">
            <button class="w-full bg-[#00113a] hover:bg-[#1a2b5a] text-white py-3 rounded-lg font-semibold text-sm transition-colors shadow-md">
                New System Alert
            </button>
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
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">TOTAL USUARIOS</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-[#00113a]">12,482</h3>
                    <span class="text-emerald-500 font-bold text-xs">+12%</span>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="kpi-card kpi-border-dark pl-8">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">SESIONES ACTIVAS</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-[#00113a]">843</h3>
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
                    <h3 class="text-3xl font-black text-emerald-500">98.2%</h3>
                    <span class="text-gray-400 font-bold text-[10px]">ISO 27001</span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="kpi-card kpi-border-red pl-8">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">ALERTAS CRITICAS</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-red-500">3</h3>
                    <span class="text-red-500 font-bold text-xs">Acción Requerida</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 mb-10 w-full align-top">
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
                            <!-- Fila 1 -->
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm shrink-0">
                                            AR
                                        </div>
                                        <div>
                                            <p class="text-[#00113a] font-bold text-[13px]">Alejandro Rivera</p>
                                            <p class="text-gray-500 text-[11px]">a.rivera@bastion.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="role-pill-admin uppercase">Admin</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-gray-600 text-xs font-semibold">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-[#00113a]"><span class="material-symbols-outlined">more_vert</span></button>
                                </td>
                            </tr>
                            
                            <!-- Fila 2 -->
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shrink-0">
                                            MC
                                        </div>
                                        <div>
                                            <p class="text-[#00113a] font-bold text-[13px]">Mariana Costa</p>
                                            <p class="text-gray-500 text-[11px]">m.costa@bastion.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="role-pill-supervisor uppercase">Supervisor</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-gray-600 text-xs font-semibold">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-[#00113a]"><span class="material-symbols-outlined">more_vert</span></button>
                                </td>
                            </tr>

                            <!-- Fila 3 -->
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm shrink-0">
                                            JS
                                        </div>
                                        <div>
                                            <p class="text-[#00113a] font-bold text-[13px]">Julian Soto</p>
                                            <p class="text-gray-500 text-[11px]">j.soto@bastion.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="role-pill-agente uppercase">Agente</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                        <span class="text-gray-500 text-xs font-semibold">Inactivo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-[#00113a]"><span class="material-symbols-outlined">more_vert</span></button>
                                </td>
                            </tr>
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
                <div class="p-6 flex flex-col gap-6 flex-1">
                    
                    <!-- Log 1 -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg log-icon-success flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[16px]">verified_user</span>
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-[#00113a]">MFA Login Success</p>
                            <p class="text-[12px] text-gray-500 mt-0.5">Admin: Alejandro Rivera</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mt-1">HACE 2 MINUTOS</p>
                        </div>
                    </div>
                    
                    <!-- Log 2 -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg log-icon-danger flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[16px]">close</span>
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-[#00113a]">Contract Deleted</p>
                            <p class="text-[12px] text-gray-500 mt-0.5">Ref ID: #CT-9821-X</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mt-1">HACE 14 MINUTOS</p>
                        </div>
                    </div>

                    <!-- Log 3 -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg log-icon-neutral flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[16px]">manage_accounts</span>
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-[#00113a]">Role Updated</p>
                            <p class="text-[12px] text-gray-500 mt-0.5">Agente → Supervisor</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mt-1">HACE 1 HORA</p>
                        </div>
                    </div>

                    <!-- Log 4 -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg log-icon-success flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[16px]">lock</span>
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-[#00113a]">Password Reset Request</p>
                            <p class="text-[12px] text-gray-500 mt-0.5">User: Carlos Mendez</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wide mt-1">HACE 3 HORAS</p>
                        </div>
                    </div>
                    
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
