<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>
<?php include __DIR__ . '/../../Agent/Views/layout/nav.php'; ?>

<div class="flex pt-16">
    <!-- SideNavBar de Lead (Drill-down) -->
    <aside class="h-screen w-64 border-r border-outline-variant/10 bg-surface-container-low fixed left-0 top-16 flex flex-col p-4 space-y-2">
        <div class="flex items-center gap-3 p-3 mb-6 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10">
            <div class="h-10 w-10 bg-primary-container text-white flex items-center justify-center font-black rounded-lg">
                <?= substr($phi['name'] ?? 'P', 0, 1) ?>
            </div>
            <div class="overflow-hidden">
                <p class="font-bold text-sm text-primary truncate"><?= $phi['name'] ?></p>
                <p class="text-[9px] uppercase tracking-tighter text-on-surface-variant font-black"><?= $lead['insurance_type'] ?></p>
            </div>
        </div>

        <nav class="space-y-1">
            <a class="flex items-center gap-3 px-3 py-2.5 font-bold text-primary bg-primary/5 rounded-lg transition-all" href="#">
                <span class="material-symbols-outlined text-sm">person</span> <?= __('Resumen General') ?>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant font-medium hover:bg-primary/5 hover:text-primary rounded-lg transition-all" href="#historial">
                <span class="material-symbols-outlined text-sm">history</span> <?= __('Trazabilidad HIPAA') ?>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant font-medium hover:bg-primary/5 hover:text-primary rounded-lg transition-all" href="#comisiones">
                <span class="material-symbols-outlined text-sm">payments</span> <?= __('Comisiones') ?>
            </a>
        </nav>

        <div class="mt-auto pt-4 border-t border-outline-variant/10">
            <button class="w-full bg-primary text-white py-3 rounded-xl font-bold text-xs shadow-lg hover:opacity-90 transition-all uppercase tracking-widest">
                <?= __('Generar Propuesta') ?>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-8 bg-surface mb-12">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[10px] font-black text-on-surface-variant uppercase tracking-widest mb-8">
            <a href="<?= $APP_URL ?>/agent/dashboard" class="hover:text-primary transition-colors"><?= __('Leads') ?></a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-primary"><?= $phi['name'] ?></span>
        </nav>

        <!-- Lead Profile Header -->
        <div class="grid grid-cols-12 gap-8 mb-8">
            <div class="col-span-12 lg:col-span-8 bg-surface-container-lowest p-8 rounded-2xl relative overflow-hidden shadow-sm border border-outline-variant/10">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-container opacity-5 rounded-bl-full"></div>
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <div class="w-24 h-24 rounded-full bg-surface-container-high border-4 border-white flex items-center justify-center text-4xl font-black text-primary/20">
                                <?= substr($phi['name'], 0, 1) ?>
                            </div>
                            <div class="absolute bottom-0 right-0 bg-on-tertiary-container text-white px-2 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter">
                                <?= __('Encriptado') ?>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-primary tracking-tighter mb-2"><?= $phi['name'] ?></h1>
                            <div class="flex flex-wrap items-center gap-4 text-on-surface-variant text-xs font-medium">
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary/50">mail</span> <?= $phi['email'] ?></span>
                                <span class="w-1 h-1 bg-outline-variant/30 rounded-full"></span>
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary/50">call</span> <?= $phi['phone'] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-tertiary-container/10 p-5 rounded-2xl border border-tertiary-container/20 flex flex-col items-center min-w-[120px]">
                        <span class="text-[9px] uppercase font-black text-on-tertiary-container tracking-widest mb-1"><?= __('Score IA') ?></span>
                        <span class="text-4xl font-black text-on-tertiary-container"><?= $lead['score'] ?>%</span>
                        <span class="text-[9px] text-on-tertiary-container font-bold uppercase"><?= ($lead['score'] >= 70) ? __('Calificación Alta') : __('Calificación Media') ?></span>
                    </div>
                    <a href="<?= $APP_URL ?>/agent/leads/<?= $lead['uuid'] ?>/report" target="_blank" class="p-3 bg-surface-container-high rounded-xl text-primary hover:bg-primary hover:text-white transition-all shadow-sm" title="<?= __('Generar Reporte PII-Secure') ?>">
                        <span class="material-symbols-outlined">print</span>
                    </a>
                </div>

                <div class="mt-10 flex flex-wrap gap-4 relative z-10">
                    <button class="bg-primary text-white px-6 py-3.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:shadow-xl hover:shadow-primary/20 transition-all">
                        <span class="material-symbols-outlined text-sm">call</span> <?= __('Llamar Ahora') ?>
                    </button>
                    <button class="bg-surface-container-high text-primary px-6 py-3.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-surface-container-highest transition-all border border-outline-variant/10">
                        <span class="material-symbols-outlined text-sm">chat</span> <?= __('WhatsApp') ?>
                    </button>
                    <button class="bg-surface-container-high text-primary px-6 py-3.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-surface-container-highest transition-all border border-outline-variant/10">
                        <span class="material-symbols-outlined text-sm">mail</span> <?= __('Enviar Correo') ?>
                    </button>
                </div>
            </div>

            <!-- AI Insight Widget -->
            <div class="col-span-12 lg:col-span-4 bg-primary-container p-8 rounded-2xl text-white flex flex-col justify-between shadow-xl shadow-primary/10">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-gold-color">psychology</span>
                        <h3 class="text-sm font-black uppercase tracking-widest"><?= __('IA Insights LLaMA') ?></h3>
                    </div>
                    <p class="text-blue-200 text-sm leading-relaxed mb-6 italic opacity-90">
                        "El prospecto muestra un alto interés en <strong><?= $lead['insurance_type'] ?></strong>. Los patrones de captura sugieren una intención de compra inmediata."
                    </p>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-2 text-xs font-bold">
                        <span class="material-symbols-outlined text-gold-color text-sm">check_circle</span>
                        <?= __('Email Verificado') ?>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold">
                        <span class="material-symbols-outlined text-gold-color text-sm">check_circle</span>
                        <?= __('PII Encriptada AES-256') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8">
            <!-- Trazabilidad HIPAA Flow -->
            <div id="historial" class="col-span-12 lg:col-span-7 bg-surface-container-low p-8 rounded-2xl border border-outline-variant/10">
                <h2 class="text-xl font-black text-primary mb-8 flex items-center gap-2 uppercase tracking-tighter">
                    <span class="material-symbols-outlined">history</span> <?= __('Trazabilidad Inmutable (Audit Log)') ?>
                </h2>
                
                <div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-outline-variant/20">
                    <?php foreach ($logs as $log): ?>
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-1 w-6 h-6 rounded-full bg-white border-2 border-<?= ($log['action'] == 'VIEW_PHI') ? 'primary' : 'outline-variant' ?> flex items-center justify-center z-10 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-<?= ($log['action'] == 'VIEW_PHI') ? 'primary' : 'outline-variant' ?>"></span>
                        </div>
                        <p class="text-[9px] font-black text-on-surface-variant uppercase mb-0.5"><?= date('d M, H:i', strtotime($log['created_at'])) ?></p>
                        <h4 class="text-sm font-bold text-primary"><?= $log['action'] ?></h4>
                        <p class="text-[10px] text-on-surface-variant leading-tight"><?= $log['details'] ?></p>
                        <p class="text-[8px] text-primary/30 mt-1 font-mono">IP: <?= $log['ip_address'] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Commission Widget -->
            <div id="comisiones" class="col-span-12 lg:col-span-5 bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant/10 shadow-sm">
                <h2 class="text-xl font-black text-primary mb-8 flex items-center gap-2 uppercase tracking-tighter">
                    <span class="material-symbols-outlined">payments</span> <?= __('Estimación de Comisiones') ?>
                </h2>
                
                <div class="space-y-6">
                    <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                        <span class="text-xs font-black text-on-surface-variant uppercase tracking-widest"><?= __('Tasa Base') ?> (<?= $lead['insurance_type'] ?>)</span>
                        <span class="font-bold text-primary"><?= $commissions['base_rate'] ?></span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-outline-variant/10">
                        <span class="text-xs font-black text-on-surface-variant uppercase tracking-widest"><?= __('Bono Calidad IA') ?></span>
                        <span class="font-bold text-on-tertiary-container">+<?= $commissions['lead_bonus'] ?></span>
                    </div>
                    <div class="flex justify-between items-center py-4 text-primary">
                        <span class="text-xs font-black uppercase tracking-widest"><?= __('Porcentaje Final') ?></span>
                        <span class="text-2xl font-black"><?= $commissions['final_rate'] ?></span>
                    </div>

                    <div class="p-6 bg-primary-container rounded-2xl text-center">
                        <p class="text-[10px] text-white/60 font-black uppercase tracking-widest mb-2"><?= __('Monto Estimado de Comisión') ?></p>
                        <p class="text-4xl font-black text-white">$<?= number_format($commissions['total_amount'], 2) ?> <span class="text-xs font-medium"><?= $commissions['currency'] ?></span></p>
                    </div>

                    <div class="flex items-center gap-2 p-3 bg-surface-container-high rounded-xl text-xs text-on-surface-variant font-medium">
                        <span class="material-symbols-outlined text-primary text-sm">info</span>
                        <?= __('Sujeto a validación de póliza final y pago de prima.') ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
