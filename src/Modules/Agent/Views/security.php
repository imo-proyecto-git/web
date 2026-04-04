<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>
<?php 
// Determinamos qué navegación usar según el rol
if(in_array($user['role_id'], [1, 2])) {
    include __DIR__ . '/../../Manager/Views/layout/nav.php'; 
} else {
    include __DIR__ . '/layout/nav.php'; 
}
?>

<main class="pt-32 pb-24 px-12 max-w-[1440px] mx-auto min-h-screen font-body bg-surface/30">
    <header class="mb-12">
        <nav class="flex items-center gap-2 text-on-surface-variant/40 text-[10px] font-black uppercase tracking-widest mb-4">
            <a href="#" class="hover:text-primary transition-colors"><?= __('Ajustes') ?></a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-primary"><?= __('Seguridad') ?></span>
        </nav>
        <h1 class="text-5xl font-black text-primary tracking-tighter mb-4 shadow-sm"><?= __('Seguridad de la Cuenta') ?></h1>
        <p class="text-on-surface-variant/50 font-medium text-sm leading-relaxed max-w-2xl">
            <?= __('Gestiona tus credenciales de acceso, activa la protección de doble factor (2FA) y supervisa tus sesiones activas en Azure Shield.') ?>
        </p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Sidebar Configurativa -->
        <aside class="lg:col-span-3 space-y-4">
            <a href="#" class="flex items-center gap-3 px-6 py-4 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all">
                <span class="material-symbols-outlined text-lg">person</span> <?= __('Perfil del Usuario') ?>
            </a>
            <a href="#" class="flex items-center gap-3 px-6 py-4 bg-primary/10 text-primary font-black text-xs rounded-2xl shadow-sm transition-all border border-primary/5 shadow-primary/5">
                <span class="material-symbols-outlined text-lg">security</span> <?= __('Seguridad y 2FA') ?>
            </a>
            <a href="#" class="flex items-center gap-3 px-6 py-4 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all">
                <span class="material-symbols-outlined text-lg">notifications</span> <?= __('Notificaciones') ?>
            </a>
            <a href="#" class="flex items-center gap-3 px-6 py-4 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all">
                <span class="material-symbols-outlined text-lg">api</span> <?= __('Integraciones API') ?>
            </a>
        </aside>

        <!-- Main Settings Content -->
        <div class="lg:col-span-9 space-y-12">
            <!-- Cambio de Contraseña -->
            <section class="bg-white rounded-[40px] p-12 shadow-2xl shadow-primary/5 border border-outline-variant/10">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-primary"><span class="material-symbols-outlined text-2xl">password</span></div>
                    <h2 class="text-2xl font-black text-primary tracking-tight"><?= __('Cambiar Contraseña') ?></h2>
                </div>
                
                <form class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Contraseña Actual</label>
                        <input type="password" class="w-full bg-indigo-50/50 border-none rounded-xl py-4 px-6 text-sm font-bold text-primary shadow-sm" placeholder="••••••••••••"/>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Nueva Contraseña</label>
                        <input type="password" class="w-full bg-indigo-50/50 border-none rounded-xl py-4 px-6 text-sm font-bold text-primary shadow-sm" placeholder="Nueva contraseña"/>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Confirmar Nueva Contraseña</label>
                        <input type="password" class="w-full bg-indigo-50/50 border-none rounded-xl py-4 px-6 text-sm font-bold text-primary shadow-sm" placeholder="Repite contraseña"/>
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <button class="bg-primary text-white px-10 py-4 rounded-xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-primary/30 hover:scale-105 transition-all">
                            <?= __('Actualizar Contraseña') ?>
                        </button>
                    </div>
                </form>
            </section>

            <!-- Doble Factor (2FA) -->
            <section class="bg-white rounded-[40px] p-12 shadow-2xl shadow-primary/5 border border-outline-variant/10">
                <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><span class="material-symbols-outlined text-2xl">shield_with_heart</span></div>
                        <div>
                            <h2 class="text-2xl font-black text-primary tracking-tight"><?= __('Autenticación de 2 Factores (2FA)') ?></h2>
                            <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest mt-1"><?= __('ESTADO: ') ?><span class="text-error"><?= __('DESACTIVADO') ?></span></p>
                        </div>
                    </div>
                    <button class="bg-emerald-600 text-white px-10 py-4 rounded-xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-emerald-600/30 hover:scale-105 transition-all">
                        <?= __('Activar Blindaje 2FA') ?>
                    </button>
                </div>
                <div class="mt-10 p-6 bg-emerald-500/5 rounded-2xl border border-emerald-500/10 flex gap-6 items-start">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shrink-0 shadow-lg shadow-emerald-500/20">
                        <span class="material-symbols-outlined text-lg">verified_user</span>
                    </div>
                    <div>
                        <p class="text-emerald-700 font-black text-[11px] uppercase tracking-widest mb-1"><?= __('Azure Shield Protection Alert') ?></p>
                        <p class="text-emerald-700/60 font-medium text-xs leading-relaxed">
                            Activar el 2FA reduce el riesgo de accesos no autorizados en un 99.9%. Recomendado para cumplimiento HIPAA e institucional.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sesiones Activas -->
            <section class="bg-white rounded-[40px] p-12 shadow-2xl shadow-primary/5 border border-outline-variant/10">
                <div class="flex items-center justify-between gap-4 mb-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-2xl">devices</span></div>
                        <h2 class="text-2xl font-black text-primary tracking-tight"><?= __('Sesiones Activas') ?></h2>
                    </div>
                    <button class="text-[10px] font-black text-error uppercase tracking-widest hover:bg-error/5 px-4 py-2 rounded-lg transition-all"><?= __('Cerrar otras sesiones') ?></button>
                </div>

                <div class="space-y-6">
                    <?php foreach ($sessions as $s): ?>
                    <div class="flex items-center justify-between p-6 rounded-3xl border border-outline-variant/5 <?= $s['current'] ? 'bg-primary/5 ring-1 ring-primary/10' : 'bg-surface' ?> transition-all">
                        <div class="flex items-center gap-6">
                            <span class="material-symbols-outlined text-3xl text-primary/40"><?= str_contains(strtolower($s['device']), 'iphone') ? 'smartphone' : 'desktop_windows' ?></span>
                            <div>
                                <h4 class="text-sm font-black text-primary tracking-tight"><?= $s['device'] ?></h4>
                                <div class="flex items-center gap-3 text-[10px] font-bold text-on-surface-variant/40 uppercase tracking-widest mt-1">
                                    <span><?= $s['location'] ?></span>
                                    <span class="w-1.5 h-1.5 bg-outline-variant/30 rounded-full"></span>
                                    <span><?= $s['ip'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black <?= $s['current'] ? 'text-emerald-600' : 'text-on-surface-variant/30' ?> uppercase tracking-widest"><?= $s['last_active'] ?></p>
                            <?php if(!$s['current']): ?>
                            <button class="text-[9px] text-error font-black uppercase tracking-tighter mt-1 hover:underline"><?= __('Revocar Acceso') ?></button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>
</main>

<footer class="w-full bg-white border-t border-outline-variant/10 px-12 py-10 mt-12 flex flex-col md:flex-row justify-between items-center gap-8">
    <p class="text-[10px] font-black text-on-surface-variant/30 uppercase tracking-widest opacity-60">© <?= date('Y') ?> <?= $COMPANY_NAME ?> PORTAL. ENCRYPTED CONFIGURATION INTERFACE.</p>
    <div class="flex gap-10">
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Privacy Policy</a>
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">SLA Agreement</a>
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Support</a>
    </div>
</footer>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
