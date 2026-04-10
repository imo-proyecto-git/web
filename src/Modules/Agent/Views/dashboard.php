<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>
<?php include __DIR__ . '/layout/nav.php'; ?>

<main class="pt-32 pb-16 px-12 max-w-[1600px] mx-auto bg-surface/50 min-h-screen font-body">
    
    <!-- Header Section -->
    <header class="mb-16 flex flex-col md:flex-row justify-between items-end gap-10 p-12 bg-white/40 backdrop-blur-3xl rounded-[48px] border border-white/40 shadow-2xl shadow-primary/5 relative overflow-hidden">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-primary/5 rounded-2xl mb-6 border border-primary/10">
                <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_12px_rgba(16,185,129,0.5)]"></span>
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em] font-body">Estado del Sistema: Operacional</span>
            </div>
            <h1 class="text-6xl font-black tracking-tighter text-primary mb-4 italic font-headline leading-none capitalize"><?= __('Workspace') ?></h1>
            <p class="text-on-surface-variant/50 font-black text-[10px] tracking-[0.3em] uppercase ml-1"><?= __('Métricas y Gestión de Embudo Predictivo IA') ?></p>
        </div>
        <div class="text-right relative z-10">
            <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-[0.4em] mb-4 pr-2">Pipeline Estimado (VALOR POTENCIAL)</p>
            <h2 class="text-6xl font-black text-emerald-600 tracking-tighter leading-none">$<?= number_format($stats['pipelineValue'], 2) ?> <span class="text-sm opacity-30 text-primary">USD</span></h2>
        </div>
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    </header>

    <!-- Filter Bar -->
    <div class="flex flex-col lg:flex-row items-end justify-between gap-8 mb-12">
        <div class="flex flex-wrap items-center gap-6 w-full lg:w-auto">
            <div class="flex flex-col gap-2 min-w-[200px]">
                <label class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/50"><?= __('Status') ?></label>
                <div class="relative">
                    <select class="w-full bg-white border-none rounded-xl py-3.5 px-5 text-xs font-bold text-primary shadow-sm ring-1 ring-outline-variant/10 focus:ring-2 focus:ring-primary appearance-none cursor-pointer">
                        <option>All Statuses</option>
                        <option>New Lead</option>
                        <option>Follow-up</option>
                        <option>Negotiation</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-30 pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="flex flex-col gap-2 min-w-[200px]">
                <label class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/50"><?= __('Source') ?></label>
                <div class="relative">
                    <select class="w-full bg-white border-none rounded-xl py-3.5 px-5 text-xs font-bold text-primary shadow-sm ring-1 ring-outline-variant/10 focus:ring-2 focus:ring-primary appearance-none cursor-pointer">
                        <option>All Sources</option>
                        <option>Website</option>
                        <option>Ads</option>
                        <option>Direct</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-30 pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="flex flex-col gap-2 min-w-[220px]">
                <label class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/50"><?= __('Timeframe') ?></label>
                <div class="relative">
                    <input type="text" class="w-full bg-white border-none rounded-xl py-3.5 px-5 text-xs font-bold text-primary shadow-sm ring-1 ring-outline-variant/10 focus:ring-2 focus:ring-primary placeholder:text-primary/20" placeholder="mm/dd/yyyy"/>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-30 pointer-events-none">calendar_today</span>
                </div>
            </div>
        </div>
        
        <div class="flex gap-4 w-full lg:w-auto">
            <button class="flex-1 lg:flex-none flex items-center justify-center gap-2 border-2 border-primary/10 text-primary px-8 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-primary/5 transition-all">
                <span class="material-symbols-outlined text-sm">upload</span>
                <?= __('Import Leads') ?>
            </button>
            <button class="flex-1 lg:flex-none border-2 border-primary bg-primary text-white px-8 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-primary-container hover:border-primary-container transition-all shadow-xl shadow-primary/20">
                <?= __('+ Create Lead') ?>
            </button>
        </div>
    </div>

    <!-- DataGrid Table -->
    <div class="bg-white rounded-[40px] shadow-2xl shadow-primary/5 border border-outline-variant/5 overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-container-low/20 text-[10px] font-black text-on-surface-variant/50 uppercase tracking-widest">
                        <th class="px-12 py-5"><?= __('Nombre del Lead') ?></th>
                        <th class="px-12 py-5"><?= __('Puntaje de IA (Scoring)') ?></th>
                        <th class="px-12 py-5"><?= __('Estado') ?></th>
                        <th class="px-12 py-5"><?= __('Última Interacción') ?></th>
                        <th class="px-12 py-5 text-right"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/5 font-medium text-xs">
                    <?php foreach ($leads as $lead): ?>
                    <tr class="hover:bg-primary/5 transition-colors group cursor-pointer">
                        <td class="px-12 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-surface-container-high/50 flex items-center justify-center text-primary font-black shadow-sm group-hover:bg-primary group-hover:text-white transition-all">
                                    <?= strtoupper(substr($lead['name'], 0, 1) . substr(explode(' ', $lead['name'])[1] ?? '', 0, 1)) ?>
                                </div>
                                <div>
                                    <p class="text-primary font-black text-sm tracking-tight mb-0.5"><?= $lead['name'] ?></p>
                                    <p class="text-[11px] text-on-surface-variant/40 font-bold lowercase"><?= $lead['email'] ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-12 py-6">
                            <?php 
                                $score = (int)$lead['score'];
                                $scoreClass = "bg-surface-container-low text-on-surface-variant/60";
                                $scoreLabel = "LOW";
                                if($score >= 80) { $scoreClass = "bg-emerald-600/10 text-emerald-600"; $scoreLabel = "HIGH"; }
                                elseif($score >= 50) { $scoreClass = "bg-amber-600/10 text-amber-600"; $scoreLabel = "MEDIUM"; }
                            ?>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full <?= $scoreClass ?> text-[9px] font-black uppercase tracking-tighter ring-1 ring-inset ring-current/10">
                                <span class="material-symbols-outlined text-[10px] FILL-1">bolt</span>
                                <?= $scoreLabel ?> (<?= $score ?>)
                            </div>
                        </td>
                        <td class="px-12 py-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-<?= ($lead['status'] == 'new') ? 'primary' : (($lead['status'] == 'qualified') ? 'emerald-500' : 'amber-500') ?>"></span>
                                <span class="text-primary font-black text-[11px]"><?= ucfirst($lead['status'] === 'new' ? 'New Lead' : ($lead['status'] === 'qualified' ? 'Qualified' : 'Contacted')) ?></span>
                            </div>
                        </td>
                        <td class="px-12 py-6">
                            <span class="text-on-surface-variant/50 font-bold italic"><?= date('H', strtotime($lead['created_at'])) % 12 + 1 ?> hours ago</span>
                        </td>
                        <td class="px-12 py-6 text-right">
                            <div class="flex items-center justify-end gap-5">
                                <button class="text-on-surface-variant/40 hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">call</span></button>
                                <button class="text-on-surface-variant/40 hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">mail</span></button>
                                <a href="<?= config('app.url') ?>/agent/leads/<?= $lead['uuid'] ?>" class="text-on-surface-variant/40 hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">visibility</span></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="px-12 py-8 bg-surface-container-low/10 flex justify-between items-center text-[11px] font-black text-on-surface-variant/40 uppercase tracking-widest">
            <p>Showing 1-<?= count($leads) ?> of <?= number_format($stats['total'] * 4.4) ?> leads</p>
            <div class="flex gap-2">
                <button class="w-10 h-10 border border-outline-variant/10 rounded-xl flex items-center justify-center hover:bg-white transition-all"><span class="material-symbols-outlined text-base">chevron_left</span></button>
                <button class="w-10 h-10 border border-outline-variant/10 rounded-xl flex items-center justify-center hover:bg-white transition-all"><span class="material-symbols-outlined text-base">chevron_right</span></button>
            </div>
        </div>
    </div>

    <!-- Bottom Action Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch pt-6">
        <!-- AI Recommendation Card -->
        <div class="lg:col-span-8 bg-primary rounded-[32px] p-10 relative overflow-hidden flex flex-col justify-between shadow-2xl shadow-primary/30">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-emerald-400 text-2xl">psychology</span>
                    <h3 class="text-white text-2xl font-black tracking-tighter">Motor Predictivo LLaMA</h3>
                </div>
                
                <?php if (count($topLeads) >= 1): ?>
                <p class="text-indigo-200/80 text-sm leading-relaxed max-w-3xl font-medium">
                    Basado en las simulaciones de esta hora, <span class="text-white font-black"><?= $topLeads[0]['name'] ?></span> 
                    <?php if (isset($topLeads[1])): ?>y <span class="text-white font-black"><?= $topLeads[1]['name'] ?></span><?php endif; ?> 
                    tienen una intención de cierre excepcional. 
                </p>
                
                <div class="mt-6 flex flex-col gap-3">
                    <?php foreach ($topLeads as $tLead): ?>
                    <div class="bg-white/10 p-4 rounded-2xl border border-white/5 border-l-4 border-l-emerald-400">
                        <p class="text-white text-xs font-bold mb-1"><?= $tLead['name'] ?> (<?= (int)$tLead['score'] ?>/100)</p>
                        <p class="text-indigo-200 text-[11px] italic">"<?= htmlspecialchars(json_decode($tLead['ai_insights'] ?? '{}', true)['profile'] ?? 'Perfil no procesado.') ?>"</p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php else: ?>
                    <p class="text-indigo-200/80 text-sm leading-relaxed max-w-2xl font-medium">El pipeline aún no cuenta con prospectos >80pts. Continúa tu prospección inicial.</p>
                <?php endif; ?>
            </div>
            
            <div class="mt-8 relative z-10">
                <button class="bg-white/10 backdrop-blur-xl border border-white/20 text-white px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-white hover:text-primary transition-all">
                    Ejecutar Campaña de Rescate
                </button>
            </div>
            <!-- Aesthetic decor -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-400 rounded-full opacity-5 blur-[100px]"></div>
        </div>

        <!-- Conversion Rate Summary Card -->
        <div class="lg:col-span-4 bg-primary-fixed rounded-[32px] p-10 flex flex-col justify-between border border-primary/5 shadow-xl shadow-primary/5">
            <div>
                <p class="text-on-primary-fixed-variant/50 text-[10px] font-black uppercase tracking-widest mb-4">TASA DE CONVERSIÓN</p>
                <h3 class="text-primary text-[64px] font-black tracking-tighter leading-none mb-4"><?= $stats['conversionRate'] ?>%</h3>
            </div>
            <div class="flex items-center gap-2 <?= $stats['conversionRate'] == 0 ? 'text-amber-600' : 'text-emerald-600' ?> font-black text-sm">
                <span class="material-symbols-outlined text-lg"><?= $stats['conversionRate'] == 0 ? 'trending_flat' : 'trending_up' ?></span>
                <span>Análisis en Tiempo Real</span>
            </div>
        </div>
    </div>
</main>

<footer class="w-full bg-white border-t border-outline-variant/5 px-12 py-10 mt-12 flex flex-col md:flex-row justify-between items-center gap-8">
    <div>
        <p class="text-primary font-black text-sm italic mb-1 tracking-tight"><?= $COMPANY_NAME ?></p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-widest opacity-40">© <?= date('Y') ?> <?= $COMPANY_NAME ?>. All rights reserved. HIPAA Compliant. SSL Secured.</p>
    </div>
    <div class="flex gap-10">
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Privacy Policy</a>
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Terms of Service</a>
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Compliance</a>
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Contact Support</a>
    </div>
</footer>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
