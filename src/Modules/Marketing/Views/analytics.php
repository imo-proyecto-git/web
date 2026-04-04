<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<!-- Top Navigation (Azure Shield Style) -->
<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm h-16 flex justify-between items-center px-12 border-b border-outline-variant/5">
    <div class="flex items-center gap-12">
        <span class="text-xl font-black text-primary tracking-tighter font-headline">Campaign Manager</span>
        <nav class="hidden md:flex items-center gap-2 text-on-surface-variant/40 text-[11px] font-bold uppercase tracking-widest">
            <a href="#" class="hover:text-primary transition-colors"><?= __('ANALYTICS') ?></a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary"><?= __('QUARTERLY REVIEW') ?></span>
        </nav>
    </div>
    <div class="flex items-center gap-6">
        <div class="relative hidden lg:block">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant/30 text-sm">search</span>
            <input class="bg-surface-container-low/50 border-none rounded-xl pl-12 pr-6 py-2 text-xs font-bold focus:ring-2 focus:ring-primary w-64 transition-all placeholder:text-on-surface-variant/20" placeholder="<?= __('Buscar campañas...') ?>" type="text"/>
        </div>
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-primary cursor-pointer relative">notifications<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-white"></span></span>
            <span class="material-symbols-outlined text-primary cursor-pointer">settings</span>
        </div>
    </div>
</nav>

<div class="flex min-h-screen pt-16 bg-surface/50">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-outline-variant/10 flex flex-col py-10 px-8 gap-8 sticky top-16 bg-white/50">
        <div class="mb-4">
            <p class="text-lg font-black text-primary tracking-tighter"><?= __('Azure Shield') ?></p>
            <p class="text-[9px] text-on-surface-variant/40 font-black uppercase tracking-widest"><?= __('MARKETING MODULE') ?></p>
        </div>
        
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="<?= config('app.url') ?>/manager/marketing/campaigns/create">
                <span class="material-symbols-outlined text-lg">send</span> <?= __('Campaigns') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 bg-primary/10 text-primary font-black text-xs rounded-xl shadow-sm transition-all" href="#">
                <span class="material-symbols-outlined text-lg">insights</span> <?= __('Analytics') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">group</span> <?= __('Audience') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">dashboard_customize</span> <?= __('Templates') ?>
            </a>
        </nav>

        <div class="mt-auto space-y-6">
            <button class="w-full bg-primary text-white py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 shadow-xl shadow-primary/20">
                <span class="material-symbols-outlined text-sm">add</span> <?= __('New Campaign') ?>
            </button>
            <a href="#" class="flex items-center gap-3 px-3 py-2 text-on-surface-variant/60 hover:text-primary transition-all text-xs font-bold uppercase tracking-widest">
                <span class="material-symbols-outlined text-lg">contact_support</span> <?= __('Support') ?>
            </a>
            <div class="p-4 bg-indigo-50/50 rounded-2xl border border-primary/5 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white text-xs font-bold">IA</div>
                <div>
                    <p class="text-[11px] font-black tracking-tighter text-primary leading-none"><?= __('IMO Admin') ?></p>
                    <p class="text-[9px] text-on-surface-variant/40 font-bold uppercase tracking-widest mt-1"><?= __('Account Settings') ?></p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-12 max-w-[1440px] mx-auto">
        <header class="flex flex-col md:flex-row justify-between items-end gap-8 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-black text-primary tracking-tighter mb-4 italic uppercase"><?= __('Marketing') ?><br/><?= __('Analytics') ?></h1>
                <p class="text-on-surface-variant/40 font-bold text-xs uppercase tracking-widest"><?= __('MONITOREO DE DESPACHO Y MÉTRICAS EN TIEMPO REAL') ?></p>
            </div>
            <div class="flex gap-4">
                <div class="bg-indigo-50/50 border border-primary/5 p-6 rounded-2xl flex items-center gap-6">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest">Queue Status</span>
                        <span class="text-xs font-black text-primary flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Worker Active
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Queue Stats Widget -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <?php 
                $emailsPending = $queueStats['emails']['pending'] ?? 0;
                $emailsProcessing = $queueStats['emails']['processing'] ?? 0;
                $emailsFailed = $queueStats['emails']['failed'] ?? 0;
                $emailsDone = $queueStats['emails']['done'] ?? 0;
            ?>
            <div class="bg-primary p-8 rounded-[32px] text-white shadow-2xl shadow-primary/20 relative overflow-hidden group">
                <p class="text-[9px] font-black uppercase tracking-widest text-white/40 mb-2">Pending in Queue</p>
                <h3 class="text-4xl font-black tracking-tighter mb-2"><?= number_format($emailsPending) ?></h3>
                <p class="text-white/30 text-[10px] font-bold uppercase">Ready to dispatch</p>
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-white/5">pending_actions</span>
            </div>
            <div class="bg-white p-8 rounded-[32px] border border-outline-variant/10 shadow-sm group">
                <p class="text-[9px] font-black uppercase tracking-widest text-on-surface-variant/40 mb-2">Processing</p>
                <h3 class="text-4xl font-black text-primary tracking-tighter mb-2"><?= number_format($emailsProcessing) ?></h3>
                <p class="text-primary/20 text-[10px] font-bold uppercase">Active workers</p>
            </div>
            <div class="bg-emerald-50 p-8 rounded-[32px] border border-emerald-500/10 group">
                <p class="text-[9px] font-black uppercase tracking-widest text-emerald-800/40 mb-2">Successfully Sent</p>
                <h3 class="text-4xl font-black text-emerald-800 tracking-tighter mb-2"><?= number_format($emailsDone) ?></h3>
                <p class="text-emerald-500 text-[10px] font-black uppercase flex items-center gap-2 tracking-widest">
                    <span class="material-symbols-outlined text-xs">verified</span> Real-time stats
                </p>
            </div>
            <div class="bg-red-50 p-8 rounded-[32px] border border-red-500/10 group">
                <p class="text-[9px] font-black uppercase tracking-widest text-red-800/40 mb-2">Failed Deliveries</p>
                <h3 class="text-4xl font-black text-red-800 tracking-tighter mb-2"><?= number_format($emailsFailed) ?></h3>
                <p class="text-red-500 text-[10px] font-bold uppercase">Requires review</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Campaign List -->
            <div class="lg:col-span-12 bg-white rounded-[40px] p-12 shadow-2xl shadow-primary/5 border border-outline-variant/5">
                <div class="flex items-center gap-4 mb-12">
                    <span class="material-symbols-outlined text-primary text-3xl">list_alt</span>
                    <h3 class="text-2xl font-black text-primary tracking-tighter uppercase italic"><?= __('Recent Campaigns') ?></h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-outline-variant/5">
                                <th class="pb-6 text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-4">Campaign Name</th>
                                <th class="pb-6 text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-4">Status</th>
                                <th class="pb-6 text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-4 text-center">Progress</th>
                                <th class="pb-6 text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-4 text-center">Metrics</th>
                                <th class="pb-6 text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-4">Created</th>
                                <th class="pb-6 text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            <?php foreach ($campaigns as $camp): ?>
                                <?php 
                                    $total = (int)$camp['recipient_count'];
                                    $sent = (int)$camp['sent_count'];
                                    $perc = $total > 0 ? round(($sent / $total) * 100, 1) : 0;
                                    $statusClass = match($camp['status']) {
                                        'queued' => 'bg-amber-100 text-amber-800',
                                        'sending' => 'bg-blue-100 text-blue-800',
                                        'sent' => 'bg-emerald-100 text-emerald-800',
                                        default => 'bg-indigo-50 text-primary',
                                    };
                                ?>
                                <tr class="hover:bg-indigo-50/30 transition-all group" data-camp-id="<?= $camp['id'] ?>">
                                    <td class="py-10 px-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-primary"><?= $camp['name'] ?></span>
                                            <span class="text-[9px] font-bold text-on-surface-variant/40 uppercase tracking-widest mt-1"><?= $camp['uuid'] ?></span>
                                        </div>
                                    </td>
                                    <td class="py-10 px-4">
                                        <span class="px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest <?= $statusClass ?>">
                                            <?= $camp['status'] ?>
                                        </span>
                                    </td>
                                    <td class="py-10 px-4 w-60">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex justify-between text-[10px] font-black text-primary mb-1">
                                                <span><?= $perc ?>%</span>
                                                <span class="text-on-surface-variant/40"><?= $sent ?> / <?= $total ?></span>
                                            </div>
                                            <div class="h-1.5 w-full bg-indigo-50 rounded-full overflow-hidden">
                                                <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: <?= $perc ?>%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-10 px-4 text-center">
                                        <div class="flex justify-center gap-8">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-primary"><?= $camp['open_count'] ?></span>
                                                <span class="text-[8px] font-bold text-on-surface-variant/40 uppercase tracking-widest">Opens</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-primary"><?= $camp['click_count'] ?></span>
                                                <span class="text-[8px] font-bold text-on-surface-variant/40 uppercase tracking-widest">Clicks</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-10 px-4">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-primary"><?= date('M d, H:i', strtotime($camp['created_at'])) ?></span>
                                            <span class="text-[8px] font-bold text-on-surface-variant/40 uppercase mt-0.5 tracking-widest"><?= $camp['created_by_email'] ?></span>
                                        </div>
                                    </td>
                                    <td class="py-10 px-4 text-right">
                                        <button class="w-10 h-10 rounded-xl bg-indigo-50 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-lg">monitoring</span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        /**
         * Real-time Campaign Monitoring
         * Polling data for active campaigns to visualize background dispatch progress.
         */
        document.addEventListener('DOMContentLoaded', () => {
            const pollCampaigns = async () => {
                const rows = document.querySelectorAll('tr[data-camp-id]');
                for (const row of rows) {
                    const id = row.getAttribute('data-camp-id');
                    try {
                        const response = await fetch(`<?= config('app.url') ?>/api/v1/marketing/campaigns/${id}/status`);
                        const data = await response.json();
                        if (data.status === 'success') {
                            // Update progress bar and text
                            const progressText = row.querySelector('.flex.justify-between.text-\\[10px\\] span:first-child');
                            const counterText = row.querySelector('.flex.justify-between.text-\\[10px\\] span:last-child');
                            const progressBar = row.querySelector('.h-full.bg-primary');
                            
                            if (progressText) progressText.innerText = `${data.progress}%`;
                            if (counterText) counterText.innerText = `${data.sent} / ${data.total}`;
                            if (progressBar) progressBar.style.width = `${data.progress}%`;
                        }
                    } catch (e) {
                        console.error('Polling error:', e);
                    }
                }
            };

            // Initial poll and then every 3 seconds
            setInterval(pollCampaigns, 3000);
        });
    </script>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
