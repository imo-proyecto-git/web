<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>
<?php include __DIR__ . '/layout/nav.php'; ?>

<main class="pt-24 pb-16 px-8 max-w-[1600px] mx-auto">
    <!-- Dashboard Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-primary font-headline tracking-tighter mb-2"><?= __('Gestión de Prospectos') ?></h1>
            <p class="text-on-surface-variant font-medium"><?= __('Bienvenido de nuevo,') ?> <span class="text-primary font-bold"><?= $user['name'] ?></span>. <?= __('Tienes') ?> <span class="text-secondary font-bold"><?= $stats['new'] ?></span> <?= __('leads nuevos hoy.') ?></p>
        </div>
        <div class="flex gap-3">
            <button class="bg-surface-container-high text-on-surface-variant px-5 py-2.5 rounded-xl font-bold text-sm transition-all hover:bg-surface-container-highest">
                <?= __('Descargar Reporte') ?>
            </button>
            <button class="bg-gradient-to-r from-primary to-primary-container text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 transition-all hover:scale-[1.02] active:scale-95">
                <?= __('+ Nuevo Prospecto') ?>
            </button>
        </div>
    </div>

    <!-- Bento Grid Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        <!-- Totales -->
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 hover:shadow-xl transition-shadow group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-low rounded-xl group-hover:bg-primary-container group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <span class="text-on-tertiary-container bg-tertiary-container/10 px-2 py-1 rounded-full text-xs font-bold font-label">Activos</span>
            </div>
            <h3 class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1"><?= __('Total en Campaña') ?></h3>
            <p class="text-2xl font-black text-primary font-headline"><?= $stats['total'] ?></p>
        </div>

        <!-- Nuevos -->
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 hover:shadow-xl transition-shadow group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-error-container text-error rounded-xl group-hover:bg-error group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">bolt</span>
                </div>
                <span class="text-error bg-error-container px-2 py-1 rounded-full text-xs font-bold font-label">Nuevos</span>
            </div>
            <h3 class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1"><?= __('Esperando Contacto') ?></h3>
            <p class="text-2xl font-black text-primary font-headline"><?= $stats['new'] ?></p>
        </div>

        <!-- Meta Eficiencia -->
        <div class="bg-primary p-6 rounded-xl shadow-xl text-white relative overflow-hidden flex flex-col justify-between">
            <div class="relative z-10">
                <h3 class="text-white/60 text-xs font-bold uppercase tracking-widest mb-1"><?= __('Speed to Lead') ?></h3>
                <p class="text-3xl font-black font-headline"><?= $stats['speed'] ?></p>
            </div>
            <div class="mt-4 relative z-10 flex items-center gap-2">
                <span class="material-symbols-outlined text-gold-color text-sm" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="text-sm font-medium">Cumplimiento COPC 7.1</span>
            </div>
            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-primary-container rounded-full opacity-50 blur-2xl"></div>
        </div>
    </div>

    <!-- Leads DataGrid -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/10 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary font-headline"><?= __('Pipeline de Conversión') ?></h2>
            <div class="flex gap-2">
                <button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-sm">filter_list</span>
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left font-body">
                <thead>
                    <tr class="bg-surface-container-low/50 text-xs text-on-surface-variant uppercase font-black tracking-widest">
                        <th class="px-6 py-4"><?= __('Lead / Prospecto') ?></th>
                        <th class="px-6 py-4"><?= __('Contacto (Masked)') ?></th>
                        <th class="px-6 py-4"><?= __('Producto') ?></th>
                        <th class="px-6 py-4"><?= __('Fecha') ?></th>
                        <th class="px-6 py-4 text-center"><?= __('Acción') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    <?php if (empty($leads)): ?>
                        <tr><td colspan="5" class="px-6 py-12 text-center text-on-surface-variant italic"><?= __('No hay leads en el pipeline.') ?></td></tr>
                    <?php endif; ?>

                    <?php foreach ($leads as $lead): ?>
                    <tr class="hover:bg-surface-container-lowest transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 bg-primary-container/10 flex items-center justify-center text-primary font-black rounded-lg">
                                    <?= substr($lead['name'], 0, 1) ?>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-primary"><?= $lead['name'] ?></p>
                                    <span class="text-[10px] bg-<?= ($lead['status'] == 'new') ? 'error-container text-error' : 'on-tertiary-container/10 text-on-tertiary-container' ?> font-black uppercase px-1.5 py-0.5 rounded"><?= $lead['status'] ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="text-primary/70 mb-0.5"><?= $lead['email'] ?></p>
                            <p class="text-on-surface-variant text-xs"><?= $lead['phone'] ?></p>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-primary uppercase">
                            <?= $lead['insurance_type'] ?>
                        </td>
                        <td class="px-6 py-4 text-xs text-on-surface-variant">
                            <?= date('d M, Y H:i', strtotime($lead['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="<?= $APP_URL ?>/agent/leads/<?= $lead['uuid'] ?>" class="p-2 text-primary opacity-0 group-hover:opacity-100 hover:bg-primary/5 rounded-full transition-all inline-block">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
