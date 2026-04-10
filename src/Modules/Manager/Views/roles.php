<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<!-- Top Navigation Unificada (Cero Hardcode) -->
<?php include __DIR__ . '/layout/nav.php'; ?>

<div class="flex min-h-screen pt-20 bg-surface">
    <!-- Sidebar Unificada -->
    <?php include __DIR__ . '/layout/sidebar.php'; ?>

    <main class="flex-1 p-16">
        <header class="flex flex-col md:flex-row justify-between items-end gap-16 mb-20">
            <div class="max-w-2xl">
                <h1 class="text-6xl font-black text-primary tracking-tighter mb-6 font-headline leading-[0.9] uppercase"><?= __('Role Based') ?><br/><?= __('Access Control') ?></h1>
                <p class="text-on-surface-variant/50 font-medium text-lg leading-relaxed">
                    <?= __('Defina y aplique estrictas políticas de Zero Trust a través de la matriz de permisos. Todos los cambios quedan grabados en la bitácora de auditoría inmutable de ') . ($COMPANY_NAME ?? 'IMO-OS') . '.' ?>
                </p>
            </div>
            <div class="flex gap-6">
                <button class="bg-surface-low text-primary px-10 py-5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-surface-highest transition-all shadow-sm border border-outline-variant/10">
                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">download</span> <?= __('Exportar Matriz') ?></span>
                </button>
                <button class="btn-primary px-10 py-5 shadow-2xl shadow-primary/30 hover:scale-105 transition-all uppercase tracking-widest text-xs">
                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">save</span> <?= __('Guardar Cambios') ?></span>
                </button>
            </div>
        </header>

        <!-- KPI Overviews for Roles -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-indigo-500 p-8 rounded-[32px] text-white flex gap-6 items-center shadow-lg shadow-indigo-500/20 relative overflow-hidden group">
                <div class="relative z-10 flex-1">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-2"><?= __('MÁS PERMISIVO') ?></p>
                    <h3 class="text-2xl font-black tracking-tighter">Administrador Global</h3>
                    <p class="text-indigo-100 text-xs mt-2">12 Roles Asignados</p>
                </div>
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center shrink-0 border border-white/20 relative z-10">
                    <span class="material-symbols-outlined text-2xl">admin_panel_settings</span>
                </div>
                <!-- bg decor -->
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
            </div>

            <div class="bg-white p-8 rounded-[32px] border border-outline-variant/10 shadow-sm flex items-center gap-6 group hover:border-primary/30 transition-all">
                <div class="flex-1">
                    <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/40 mb-2"><?= __('MÁS COMÚN') ?></p>
                    <h3 class="text-2xl font-black text-primary tracking-tighter">Agente (Ventas)</h3>
                    <p class="text-on-surface-variant/50 text-xs mt-2 truncate">Activo en ~240 cuentas</p>
                </div>
                <div class="w-16 h-16 bg-surface-lowest rounded-2xl border border-outline-variant/10 flex items-center justify-center shrink-0 text-primary group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">support_agent</span>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[32px] border border-outline-variant/10 shadow-sm flex items-center gap-6 group hover:border-primary/30 transition-all">
                <div class="flex-1">
                    <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/40 mb-2"><?= __('NUEVO ROL RECIENTE') ?></p>
                    <h3 class="text-2xl font-black text-primary tracking-tighter">Supervisor B2B</h3>
                    <p class="text-on-surface-variant/50 text-xs mt-2 truncate">Creado hace 2 horas</p>
                </div>
                <div class="w-16 h-16 bg-surface-lowest rounded-2xl border border-outline-variant/10 flex items-center justify-center shrink-0 text-primary group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">supervisor_account</span>
                </div>
            </div>
        </div>

        <!-- The Security Matrix -->
        <section class="bg-surface-lowest rounded-[40px] shadow-2xl shadow-primary/5 border border-outline-variant/5 overflow-hidden">
            <div class="px-12 py-10 flex justify-between items-center border-b border-outline-variant/5 bg-gray-50/50">
                <h2 class="font-black text-primary tracking-tighter text-2xl font-headline uppercase"><?= __('Matriz de Privilegios Corporativos') ?></h2>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-40">Permitido</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-error/80"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-40">Denegado</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto p-8">
                <!-- We simulate the matrix via CSS Grid for an architectural look -->
                <div class="min-w-[800px]">
                    <!-- Table Header -->
                    <div class="grid grid-cols-5 gap-4 mb-6">
                        <div class="col-span-2 text-[10px] font-black text-on-surface-variant/30 uppercase tracking-[0.2em] pl-4">Entidad / Permiso</div>
                        <div class="text-center pb-4 text-xs font-black uppercase tracking-widest border-b-2 border-indigo-500 text-indigo-700">Admins</div>
                        <div class="text-center pb-4 text-xs font-black uppercase tracking-widest border-b-2 border-primary/20 text-primary/70">Managers</div>
                        <div class="text-center pb-4 text-xs font-black uppercase tracking-widest border-b-2 border-primary/20 text-primary/70">Agentes</div>
                    </div>

                    <?php 
                    $permissions = [
                        'Gestión de Directorio (Usuarios)' => [
                            ['name' => 'Can Create Users', 'admin' => true, 'manager' => false, 'agent' => false],
                            ['name' => 'Can Edit Roles', 'admin' => true, 'manager' => false, 'agent' => false],
                            ['name' => 'Can View Directory', 'admin' => true, 'manager' => true, 'agent' => false],
                        ],
                        'Campañas y Marketing' => [
                            ['name' => 'Create Mail Campaigns', 'admin' => true, 'manager' => true, 'agent' => false],
                            ['name' => 'Export Campaign Data', 'admin' => true, 'manager' => true, 'agent' => false],
                            ['name' => 'View Campaign KPIs', 'admin' => true, 'manager' => true, 'agent' => true],
                        ],
                        'Módulo CRM / Leads' => [
                            ['name' => 'Force Re-assign Leads', 'admin' => true, 'manager' => true, 'agent' => false],
                            ['name' => 'Delete Leads Permanent', 'admin' => true, 'manager' => false, 'agent' => false],
                            ['name' => 'View PII/SSN Data', 'admin' => true, 'manager' => false, 'agent' => false, 'warning' => true],
                            ['name' => 'Generate AI Transcripts', 'admin' => true, 'manager' => true, 'agent' => true],
                        ],
                        'Sistema (Auditoría)' => [
                            ['name' => 'View System Audit Trail', 'admin' => true, 'manager' => false, 'agent' => false],
                            ['name' => 'Configure Webhooks', 'admin' => true, 'manager' => false, 'agent' => false],
                        ]
                    ];
                    ?>

                    <?php foreach ($permissions as $moduleName => $perms): ?>
                        <div class="mb-8 bg-white rounded-3xl p-6 shadow-sm border border-outline-variant/10">
                            <h3 class="text-sm font-black text-primary tracking-widest uppercase mb-4 pl-4 border-l-4 border-primary"><?= $moduleName ?></h3>
                            
                            <div class="flex flex-col gap-2">
                                <?php foreach ($perms as $perm): ?>
                                    <div class="grid grid-cols-5 gap-4 items-center group py-2 hover:bg-surface-low rounded-xl px-4 transition-colors">
                                        <div class="col-span-2 flex items-center justify-between pr-8">
                                            <span class="text-xs font-bold text-on-surface-variant/80"><?= $perm['name'] ?></span>
                                            <?php if(isset($perm['warning'])): ?>
                                                <span class="material-symbols-outlined text-error text-[16px]" title="Acceso a datos protegidos (HIPAA) - Log incondicional">warning</span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Checkboxes styled as toggle switches -->
                                        <div class="text-center flex justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="" class="sr-only peer" <?= $perm['admin'] ? 'checked' : '' ?> disabled>
                                                <div class="w-9 h-5 bg-error/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500 opacity-50 cursor-not-allowed"></div>
                                            </label>
                                        </div>
                                        <div class="text-center flex justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="" class="sr-only peer" <?= $perm['manager'] ? 'checked' : '' ?>>
                                                <div class="w-9 h-5 bg-error/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500 border border-outline-variant/10"></div>
                                            </label>
                                        </div>
                                        <div class="text-center flex justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="" class="sr-only peer" <?= $perm['agent'] ? 'checked' : '' ?>>
                                                <div class="w-9 h-5 bg-error/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500 border border-outline-variant/10"></div>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            </div>
            <div class="px-10 py-6 bg-surface-low border-t border-outline-variant/5 text-right">
                <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest"><span class="material-symbols-outlined text-[10px] inline-block mr-1">info</span> Los permisos de "Adminstrador" son inmutables por política del sistema.</p>
            </div>
        </section>

    </main>
</div>

<!-- Architectural Footer -->
<footer class="w-full border-t border-outline-variant/10 bg-surface-container-low/50 flex flex-col md:flex-row justify-between items-center px-12 py-6 gap-6">
    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold opacity-60">© <?= date('Y') ?> <?= $COMPANY_NAME ?? 'IMO-OS' ?>. ALL RIGHTS RESERVED - ZERO TRUST.</p>
    <div class="flex gap-8">
        <a class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-primary font-bold opacity-60 transition-all hover:opacity-100" href="#"><?= __('Compliance') ?></a>
        <a class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-primary font-bold opacity-60 transition-all hover:opacity-100" href="#"><?= __('Auditoría') ?></a>
        <a class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-primary font-bold opacity-60 transition-all hover:opacity-100" href="#"><?= __('Data Privacy') ?></a>
    </div>
</footer>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
