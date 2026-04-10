<?php include __DIR__ . '/layout/nav.php'; ?>

<div class="flex-1 bg-surface min-h-screen pt-24 px-10 pb-10">
    <div class="max-w-7xl mx-auto">
        
        <header class="mb-12 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black text-primary tracking-tighter uppercase font-headline italic">Mis Ingresos</h1>
                <p class="text-on-surface-variant/60 font-bold text-sm tracking-widest uppercase">Estructura Residual y Comisiones Acumuladas</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black text-on-surface-variant/50 uppercase tracking-[0.3em] mb-2">Total Histórico</p>
                <h2 class="text-5xl font-black text-primary tracking-tighter">$<?= number_format($totalEarnings, 2) ?> <span class="text-lg opacity-40">USD</span></h2>
            </div>
        </header>

        <!-- Financial Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-primary p-8 rounded-[32px] shadow-2xl shadow-primary/20 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-6">Próximo Desembolso</p>
                    <h3 class="text-4xl font-black tracking-tighter mb-2">$<?= number_format($totalEarnings * 0.4, 2) ?></h3>
                    <p class="text-xs font-bold text-indigo-200">Disponible el 15 de <?= date('M') ?></p>
                </div>
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-9xl opacity-10">payments</span>
            </div>
            
            <div class="bg-white p-8 rounded-[32px] shadow-xl border border-outline-variant/10">
                <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest mb-6">Pipeline Potencial</p>
                <div class="flex items-baseline gap-3">
                    <h3 class="text-4xl font-black text-primary tracking-tighter">$<?= number_format($stats['active_pipeline'] ?? 0) ?></h3>
                    <span class="text-emerald-500 font-black text-xs">↑ 14%</span>
                </div>
                <div class="mt-4 h-1.5 w-full bg-surface-low rounded-full overflow-hidden">
                    <div class="h-full bg-primary w-2/3"></div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[32px] shadow-xl border border-outline-variant/10">
                <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest mb-6">Comparativa Mes Anterior</p>
                <div class="flex items-baseline gap-3">
                    <h3 class="text-4xl font-black text-primary tracking-tighter">$<?= number_format($stats['last_month'] ?? 0) ?></h3>
                </div>
                <p class="text-xs font-bold text-on-surface-variant/40 mt-2 italic">Cierre consolidado al 30 de <?= date('M', strtotime('-1 month')) ?></p>
            </div>
        </div>

        <!-- Commissions Ledger -->
        <div class="bg-white rounded-[40px] shadow-2xl shadow-primary/5 border border-outline-variant/10 overflow-hidden">
            <div class="px-10 py-8 border-b border-outline-variant/5 flex justify-between items-center">
                <h3 class="font-black text-primary uppercase tracking-widest text-xs">Historial de Comisiones</h3>
                <button class="text-primary font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:opacity-60 transition-all">
                    <span class="material-symbols-outlined text-sm">download</span> Descargar Reporte Fiscal
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-low/50 text-[10px] font-black text-on-surface-variant/50 uppercase tracking-[0.2em]">
                            <th class="px-10 py-5">Cliente / Lead</th>
                            <th class="px-10 py-5">Tipo de Póliza</th>
                            <th class="px-10 py-5">Fecha Cierre</th>
                            <th class="px-10 py-5">Premium Base</th>
                            <th class="px-10 py-5 text-right">Comisión (20%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        <?php foreach($commissions as $c): ?>
                        <tr class="hover:bg-primary/5 transition-colors group">
                            <td class="px-10 py-6">
                                <p class="text-primary font-black text-[13px] tracking-tight"><?= $c['client'] ?></p>
                            </td>
                            <td class="px-10 py-6">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-indigo-100">
                                    <?= $c['type'] ?>
                                </span>
                            </td>
                            <td class="px-10 py-6 text-xs text-on-surface-variant font-bold"><?= date('d M, Y', strtotime($c['date'])) ?></td>
                            <td class="px-10 py-6 text-xs text-on-surface-variant/60 font-black">$<?= number_format($c['premium'], 2) ?></td>
                            <td class="px-10 py-6 text-right">
                                <span class="text-emerald-600 font-black text-sm">+$<?= number_format($c['earned'], 2) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($commissions)): ?>
                        <tr>
                            <td colspan="5" class="py-20 text-center">
                                <span class="material-symbols-outlined text-5xl text-on-surface-variant/20 mb-4">account_balance_wallet</span>
                                <p class="text-xs font-bold text-on-surface-variant/40 uppercase tracking-widest">Aún no tienes comisiones liquidadas.</p>
                                <a href="<?= config('app.url') ?>/agent/pipeline" class="text-primary text-[10px] font-black uppercase tracking-widest mt-4 inline-block hover:underline">Ir a cerrar leads →</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php 
if ($user['role'] === 'manager' || $user['role'] === 'superadmin') {
    include __DIR__ . '/../../Landing/Views/layout/footer.php';
}
?>
