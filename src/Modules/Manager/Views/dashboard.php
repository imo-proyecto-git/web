<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<div class="flex min-h-screen pt-16">
    <!-- Sidebar de Supervisión -->
    <aside class="h-screen w-64 border-r border-outline-variant/10 flex flex-col py-8 px-5 gap-6 sticky top-16 bg-surface-container-low shadow-sm">
        <div class="mb-4 px-2">
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-black mb-1 opacity-60"><?= __('Oversight Module') ?></p>
            <h2 class="text-primary font-headline font-black text-2xl tracking-tighter"><?= __('Bastion Hub') ?></h2>
        </div>
        
        <nav class="flex flex-col gap-1">
            <a class="flex items-center gap-3 px-3 py-2.5 bg-primary/5 text-primary rounded-xl font-bold text-sm scale-[1.02] transition-all" href="#">
                <span class="material-symbols-outlined text-sm">dashboard</span> <?= __('Dashboard') ?>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-primary/5 hover:text-primary rounded-xl font-semibold text-sm transition-all" href="#">
                <span class="material-symbols-outlined text-sm">group</span> <?= __('Agentes') ?>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-primary/5 hover:text-primary rounded-xl font-semibold text-sm transition-all" href="#">
                <span class="material-symbols-outlined text-sm">history_edu</span> <?= __('Auditoría Central') ?>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-primary/5 hover:text-primary rounded-xl font-semibold text-sm transition-all" href="#">
                <span class="material-symbols-outlined text-sm">security</span> <?= __('Seguridad PII') ?>
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-outline-variant/10">
            <button class="w-full bg-primary-container text-white py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest hover:opacity-90 shadow-lg shadow-primary/20 transition-all">
                <?= __('Generar Reporte Global') ?>
            </button>
            <a href="<?= $APP_URL ?>/logout" class="flex items-center gap-3 px-3 py-3 mt-4 text-on-surface-variant/60 hover:text-error transition-colors text-xs font-bold uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">logout</span> <?= __('Cerrar Sesión') ?>
            </a>
        </div>
    </aside>

    <!-- Área de Contenido Principal -->
    <main class="flex-1 p-10 bg-surface">
        <header class="mb-12 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black tracking-tighter text-primary mb-2"><?= __('Supervisión Comercial') ?></h1>
                <p class="text-on-surface-variant text-sm font-medium opacity-80"><?= __('Bienvenido Administrador.') ?> <?= __('Monitoreo en tiempo real bajo cumplimiento HIPAA/COPC.') ?></p>
            </div>
            <div class="bg-surface-container-high rounded-full px-4 py-2 flex items-center gap-2 border border-outline-variant/10">
                <span class="w-2 h-2 bg-on-tertiary-container rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black uppercase text-primary tracking-widest"><?= __('Servidores estables') ?></span>
            </div>
        </header>

        <!-- KPI Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-surface-container-lowest p-6 rounded-2xl border-l-4 border-primary shadow-sm hover:shadow-xl transition-all group">
                <p class="text-on-surface-variant text-[10px] font-black uppercase tracking-widest mb-3 opacity-60"><?= __('Total Prospectos') ?></p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-black text-primary tracking-tight"><?= $stats['total_leads'] ?></h3>
                    <span class="text-on-tertiary-container text-xs font-black">+12%</span>
                </div>
            </div>
            
            <div class="bg-surface-container-lowest p-6 rounded-2xl border-l-4 border-primary shadow-sm hover:shadow-xl transition-all group">
                <p class="text-on-surface-variant text-[10px] font-black uppercase tracking-widest mb-3 opacity-60"><?= __('Agentes Activos') ?></p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-black text-primary tracking-tight"><?= $stats['active_sessions'] ?></h3>
                    <span class="text-on-surface-variant text-xs font-bold"><?= __('En línea') ?></span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-2xl border-l-4 border-on-tertiary-container shadow-sm hover:shadow-xl transition-all group">
                <p class="text-on-surface-variant text-[10px] font-black uppercase tracking-widest mb-3 opacity-60"><?= __('Contratos Firmados') ?></p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-black text-on-tertiary-container tracking-tight"><?= $stats['signed_contracts'] ?></h3>
                    <span class="text-on-surface-variant/40 text-xs font-black italic"><?= __('Verified') ?></span>
                </div>
            </div>

            <div class="bg-primary p-6 rounded-2xl shadow-2xl relative overflow-hidden flex flex-col justify-between">
                <div>
                    <p class="text-white/60 text-[10px] font-black uppercase tracking-widest mb-3"><?= __('Compliance Score') ?></p>
                    <h3 class="text-4xl font-black text-gold-color tracking-tight"><?= $stats['compliance_pct'] ?>%</h3>
                </div>
                <div class="text-[9px] text-white/50 font-bold uppercase tracking-wider"><?= __('Protocolo HIPAA v2.1') ?></div>
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-primary-container rounded-full opacity-30 blur-2xl"></div>
            </div>
        </div>

        <!-- Vista Dual: Agentes + Auditoría -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Tabla de Agentes -->
            <div class="lg:col-span-8 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm border border-outline-variant/10">
                <div class="px-8 py-5 border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-low/30 backdrop-blur-sm">
                    <h2 class="font-black text-primary tracking-tight"><?= __('Gestión de Productividad - Agentes') ?></h2>
                    <button class="text-primary text-[10px] font-black hover:underline uppercase tracking-widest"><?= __('Ver Todo') ?></button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low/30">
                            <tr>
                                <th class="px-8 py-3 text-[10px] font-black text-on-surface-variant uppercase tracking-widest"><?= __('Agente') ?></th>
                                <th class="px-8 py-3 text-[10px] font-black text-on-surface-variant uppercase tracking-widest"><?= __('Rol') ?></th>
                                <th class="px-8 py-3 text-[10px] font-black text-on-surface-variant uppercase tracking-widest"><?= __('Estatus') ?></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10 font-medium text-xs">
                            <?php foreach ($agents as $agent): ?>
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary-container text-white flex items-center justify-center font-black">
                                            <?= substr($agent['email'], 0, 1) ?>
                                        </div>
                                        <p class="text-primary font-bold"><?= $agent['email'] ?></p>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="px-3 py-1 bg-primary text-white text-[9px] font-black uppercase rounded-full tracking-widest"><?= $agent['role'] ?></span>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-<?= ($agent['status'] == 'active') ? 'on-tertiary-container' : 'error' ?>"></span>
                                        <span class="text-on-surface-variant/70 font-bold uppercase text-[10px]"><?= $agent['status'] ?></span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Feed de Auditoría HIPAA -->
            <div class="lg:col-span-4 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 flex flex-col">
                <div class="px-8 py-5 border-b border-outline-variant/10 flex items-center justify-between bg-primary-container text-white">
                    <h2 class="font-black tracking-tight text-sm uppercase"><?= __('Audit Trail PHI-Secure') ?></h2>
                    <span class="material-symbols-outlined text-sm">verified_user</span>
                </div>
                <div class="p-6 flex flex-col gap-6 overflow-y-auto max-h-[600px]">
                    <?php foreach ($logs as $log): ?>
                    <div class="flex gap-4 border-l-2 border-primary/10 pl-4 py-1">
                        <div class="mt-1 w-6 h-6 rounded bg-primary/5 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary text-xs">history_edu</span>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[11px] font-black text-primary leading-tight truncate"><?= $log['action'] ?></p>
                            <p class="text-[9px] text-on-surface-variant/70 mt-1 italic"><?= $log['user_email'] ?? __('System') ?></p>
                            <p class="text-[8px] font-black text-outline uppercase mt-1"><?= date('H:i', strtotime($log['created_at'])) ?> • IP: <?= $log['ip_address'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <button class="w-full mt-4 py-3 bg-surface-container-high rounded-xl text-primary text-[10px] font-black uppercase tracking-widest hover:bg-primary-container hover:text-white transition-all">
                        <?= __('Revisar Bitácora Completa') ?>
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
