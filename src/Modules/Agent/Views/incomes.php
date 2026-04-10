<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>
<?php include __DIR__ . '/layout/nav.php'; ?>

<div class="flex-1 bg-surface min-h-screen pt-24 px-10 pb-10">
    <div class="max-w-7xl mx-auto">
        
        <header class="mb-16 flex flex-col md:flex-row justify-between items-end gap-8 p-12 bg-white/40 backdrop-blur-3xl rounded-[40px] border border-white/40 shadow-2xl shadow-primary/5 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-2 h-10 bg-indigo-500 rounded-full"></div>
                    <h1 class="text-5xl font-black text-primary tracking-tighter uppercase font-headline italic leading-none">Mis Ingresos</h1>
                </div>
                <p class="text-on-surface-variant/60 font-black text-[10px] tracking-[0.3em] uppercase ml-6">Estructura Residual y Comisiones Acumuladas</p>
            </div>
            <div class="text-right relative z-10">
                <p class="text-[10px] font-black text-on-surface-variant/50 uppercase tracking-[0.4em] mb-3 pr-2">Total Histórico (YTD)</p>
                <h2 class="text-6xl font-black text-primary tracking-tighter flex items-center justify-end gap-3">
                    <span class="text-2xl opacity-20">$</span>
                    <?= number_format($totalEarnings, 2) ?> 
                    <span class="text-xs font-black uppercase tracking-widest px-3 py-1 bg-primary text-white rounded-lg shadow-xl shadow-primary/20">USD</span>
                </h2>
            </div>
            <!-- Background Decoration -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>
        </header>

        <!-- Financial Status Cards -->
            <div class="bg-primary p-10 rounded-[48px] shadow-3xl shadow-primary/30 text-white relative overflow-hidden transition-transform hover:scale-[1.02] duration-500 group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-200/60 mb-8 flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span> Próximo Desembolso
                    </p>
                    <h3 class="text-5xl font-black tracking-tighter mb-4">$<?= number_format($totalEarnings * 0.4, 2) ?></h3>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-white/10 rounded-lg text-[9px] font-black uppercase tracking-widest border border-white/10">15 DE <?= date('M') ?></span>
                        <span class="text-[10px] font-bold text-indigo-200/80 italic">Status: Pendiente</span>
                    </div>
                </div>
                <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-[12rem] opacity-5 group-hover:rotate-12 transition-transform duration-700">monetization_on</span>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 blur-3xl rounded-full"></div>
            </div>
            
            <div class="bg-white p-10 rounded-[48px] shadow-2xl shadow-primary/5 border border-outline-variant/10 relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-500">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-[0.3em] mb-8">Pipeline Potencial</p>
                    <div class="flex items-end gap-3 mb-6">
                        <h3 class="text-5xl font-black text-primary tracking-tighter">$<?= number_format($stats['active_pipeline'] ?? 0) ?></h3>
                        <div class="flex items-center gap-1 text-emerald-500 font-black text-[11px] mb-2">
                            <span class="material-symbols-outlined text-[14px]">trending_up</span> 14%
                        </div>
                    </div>
                    <div class="h-2 w-full bg-surface-low rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-600 w-2/3 shadow-lg shadow-emerald-500/20"></div>
                    </div>
                </div>
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 opacity-0 group-hover:opacity-100 rounded-full blur-2xl transition-opacity"></div>
            </div>

            <div class="bg-white p-10 rounded-[48px] shadow-2xl shadow-primary/5 border border-outline-variant/10 relative overflow-hidden group transition-all duration-500">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-[0.3em] mb-8">Quarterly Growth</p>
                    <div class="flex items-center gap-3 mb-4">
                        <h3 class="text-5xl font-black text-primary tracking-tighter">$<?= number_format($stats['last_month'] ?? 0) ?></h3>
                    </div>
                    <div class="flex gap-1 h-12 items-end">
                        <div class="w-3 bg-primary/5 h-1/4 rounded-t-sm"></div>
                        <div class="w-3 bg-primary/10 h-1/2 rounded-t-sm"></div>
                        <div class="w-3 bg-primary/5 h-1/3 rounded-t-sm"></div>
                        <div class="w-3 bg-primary/20 h-2/3 rounded-t-sm"></div>
                        <div class="w-3 bg-primary h-full rounded-t-sm"></div>
                    </div>
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
