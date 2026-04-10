<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<!-- Top Navigation (Editorial Glass) -->
<nav class="fixed top-0 w-full z-50 glass-card flex justify-between items-center px-12 h-20">
    <div class="flex items-center gap-12">
        <span class="text-3xl font-black text-primary tracking-tighter font-headline"><?= $COMPANY_NAME ?></span>
        <div class="hidden md:flex gap-10 items-center">
            <a class="text-on-surface-variant font-bold hover:text-primary transition-colors text-xs uppercase tracking-widest" href="<?= config('app.url') ?>/manager/dashboard"><?= __('Dashboard') ?></a>
            <a class="text-on-surface-variant font-bold hover:text-primary transition-colors text-xs uppercase tracking-widest" href="<?= config('app.url') ?>/manager/users"><?= __('User Management') ?></a>
            <a class="text-on-surface-variant font-bold hover:text-primary transition-colors text-xs uppercase tracking-widest" href="<?= config('app.url') ?>/manager/roles"><?= __('Roles') ?></a>
            <a class="font-headline tracking-tighter font-black text-primary border-b-4 border-primary pb-1 text-sm uppercase" href="<?= config('app.url') ?>/manager/audit"><?= __('System Logs') ?></a>
        </div>
    </div>
    <div class="flex items-center gap-6 text-on-surface-variant/20">
        <span class="material-symbols-outlined text-primary cursor-pointer relative">notifications<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-white"></span></span>
        <div class="w-8 h-8 rounded-lg overflow-hidden border border-primary/10 shadow-sm"><img src="<?= avatar_url('Admin') ?>" class="w-full h-full object-cover"></div>
    </div>
</nav>

<div class="flex min-h-screen pt-20 bg-surface">
    <!-- Sidebar (Secondary Context - No Border) -->
    <aside class="h-screen w-80 bg-surface-low flex flex-col py-12 px-10 gap-12 sticky top-20">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-primary/90 rounded-xl flex items-center justify-center text-white shadow-lg"><span class="material-symbols-outlined text-xl">history_edu</span></div>
            <div>
                <p class="text-[11px] font-black tracking-tighter text-primary"><?= __('Compliance Central') ?></p>
                <p class="text-[9px] text-on-surface-variant/40 font-bold uppercase tracking-widest"><?= __('Immutable Ledger') ?></p>
            </div>
        </div>
        
        <a href="<?= config('app.url') ?>/manager/audit/export" class="w-full bg-surface-container-high text-primary py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 border border-outline-variant/10 hover:bg-primary hover:text-white transition-all">
            <span class="material-symbols-outlined text-sm">download</span> <?= __('Export Audit CSV') ?>
        </a>

        <nav class="flex flex-col gap-2 pt-4">
            <a class="flex items-center gap-3 px-4 py-3.5 bg-primary/10 text-primary font-black text-xs rounded-xl shadow-sm transition-all" href="<?= config('app.url') ?>/manager/audit">
                <span class="material-symbols-outlined text-lg">history_edu</span> <?= __('Bitácora de Auditoría') ?>
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-outline-variant/5">
            <p class="text-[8px] font-black text-on-surface-variant/30 uppercase tracking-[0.2em] mb-4">SEGURIDAD AZURE SHIELD</p>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 text-emerald-600">
                    <span class="material-symbols-outlined text-lg animate-pulse">lock</span>
                    <span class="text-[9px] font-black uppercase tracking-widest">Conexión Blindada</span>
                </div>
                <a href="<?= config('app.url') ?>/logout" class="text-error/80 hover:text-error transition-colors flex items-center justify-center p-2 rounded-full hover:bg-error/10" title="Cerrar sesión">
                    <span class="material-symbols-outlined text-sm">logout</span>
                </a>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-16">
        <header class="flex flex-col md:flex-row justify-between items-end gap-16 mb-20">
            <div class="max-w-2xl">
                <h1 class="text-6xl font-black text-primary tracking-tighter mb-6 font-headline leading-[0.9] uppercase"><?= __('Compliance') ?><br/><?= __('Ledger') ?></h1>
                <p class="text-on-surface-variant/50 font-medium text-lg leading-relaxed">
                    <?= __('Historial inmutable de acciones críticas del sistema, trazabilidad de acceso a datos sensibles y cambios en roles bajo norma HIPAA.') ?>
                </p>
            </div>
            <div class="flex flex-wrap gap-4">
                <div class="flex flex-col gap-2">
                    <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">USUARIO</label>
                    <input class="bg-white border-none ring-1 ring-primary/5 rounded-xl py-3 px-5 text-xs font-bold text-primary shadow-sm focus:ring-2 focus:ring-primary" placeholder="Buscar por email..."/>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">ACCIÓN</label>
                    <select class="bg-white border-none ring-1 ring-primary/5 rounded-xl py-3 px-5 text-xs font-bold text-primary shadow-sm appearance-none cursor-pointer">
                        <option>Todas las Acciones</option>
                        <option>LOGIN</option>
                        <option>VIEW_PHI</option>
                        <option>EXPORT_PHI</option>
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">CRITICIDAD</label>
                    <select class="bg-white border-none ring-1 ring-primary/5 rounded-xl py-3 px-5 text-xs font-bold text-primary shadow-sm appearance-none cursor-pointer">
                        <option>Todos los Niveles</option>
                        <option>ALTA</option>
                        <option>MEDIA</option>
                        <option>BAJA</option>
                    </select>
                </div>
            </div>
        </header>

        <!-- Audit Cards List (Tonal Layering: lowest on context) -->
        <div class="space-y-8 mb-24">
            <?php foreach ($logs as $log): ?>
            <?php 
                $criticalActions = ['EXPORT_PHI', 'EDIT_USER', 'CHANGE_PERMISSION', 'DELETE_PHI'];
                $isCritical = in_array($log['action'], $criticalActions);
            ?>
            <div class="group bg-surface-lowest p-10 rounded-[40px] shadow-2xl shadow-primary/5 hover:-translate-y-2 transition-all duration-500 flex flex-col md:flex-row items-center gap-12">
                <div class="flex items-center gap-8 flex-1">
                    <div class="w-16 h-16 rounded-2xl bg-<?= $isCritical ? 'error/5 text-error shadow-error/10' : 'surface-low text-primary shadow-primary/5' ?> flex items-center justify-center shrink-0 shadow-xl transition-all group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-3xl font-black"><?= $isCritical ? 'report' : 'shield_with_heart' ?></span>
                    </div>
                    <div>
                        <div class="flex items-center gap-5 mb-2">
                            <h4 class="text-lg font-black text-primary tracking-tighter uppercase font-headline"><?= $log['action'] ?></h4>
                            <?php if($isCritical): ?>
                            <span class="px-3 py-1 bg-error text-white text-[9px] font-black uppercase rounded tracking-widest shadow-lg shadow-error/20"><?= __('PROTECTED ACCESS EVENT') ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="text-sm text-on-surface-variant/40 font-bold leading-relaxed max-w-2xl">
                            <?= $log['details'] ?>
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col md:items-end gap-2 shrink-0">
                    <p class="text-[11px] font-black text-primary tracking-[0.2em] uppercase"><?= explode('@', $log['user_email'])[0] ?? 'SYSTEM' ?></p>
                    <p class="text-[10px] text-on-surface-variant/30 font-black tracking-widest"><?= $log['ip_address'] ?></p>
                </div>

                <div class="text-right shrink-0 min-w-[120px]">
                    <p class="text-lg font-black text-primary tracking-tighter"><?= date('H:i:s', strtotime($log['created_at'])) ?></p>
                    <p class="text-[10px] text-on-surface-variant/40 font-black uppercase tracking-widest"><?= date('d M, Y', strtotime($log['created_at'])) ?></p>
                </div>

                <button class="w-14 h-14 rounded-2xl bg-surface-low flex items-center justify-center text-primary/30 hover:bg-primary hover:text-white transition-all shadow-sm">
                    <span class="material-symbols-outlined text-xl">file_open</span>
                </button>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Footer Stats Banner -->
        <div class="bg-primary rounded-[40px] p-10 flex flex-col md:flex-row justify-between items-center text-white relative overflow-hidden shadow-2xl shadow-primary/40">
            <div class="relative z-10 flex flex-col md:flex-row gap-16">
                <div>
                    <p class="text-indigo-200/40 text-[10px] font-black uppercase tracking-widest mb-2">EVENTOS TOTALES (30D)</p>
                    <h3 class="text-5xl font-black tracking-tighter"><?= number_format($stats['total_logs']) ?></h3>
                </div>
                <div class="h-16 w-[1px] bg-white/10 hidden md:block"></div>
                <div>
                    <p class="text-indigo-200/40 text-[10px] font-black uppercase tracking-widest mb-2">ALERTAS DETECTADAS</p>
                    <h3 class="text-5xl font-black tracking-tighter text-error-fixed"><?= $stats['security_alerts'] ?></h3>
                </div>
                <div class="h-16 w-[1px] bg-white/10 hidden md:block"></div>
                <div>
                    <p class="text-indigo-200/40 text-[10px] font-black uppercase tracking-widest mb-2">PHI EXPORTS (24H)</p>
                    <h3 class="text-5xl font-black tracking-tighter text-emerald-400"><?= $stats['phi_exports'] ?></h3>
                </div>
            </div>
            <!-- Aesthetic decor -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-500 rounded-full opacity-10 blur-[100px]"></div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
