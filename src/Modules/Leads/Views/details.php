<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<!-- Top Navigation (Bastion Portal Style) -->
<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm h-16 flex justify-between items-center px-12 border-b border-outline-variant/5">
    <div class="flex items-center gap-12">
        <span class="text-2xl font-black text-primary tracking-tighter font-headline"><?= $COMPANY_NAME ?> Portal</span>
        <div class="hidden md:flex gap-8 items-center">
            <a class="text-on-surface-variant/70 font-bold hover:text-primary transition-colors text-sm" href="<?= config('app.url') ?>/agent/dashboard"><?= __('Dashboard') ?></a>
            <a class="text-primary border-b-2 border-primary font-black pb-1 text-sm tracking-tight" href="#"><?= __('Leads') ?></a>
            <a class="text-on-surface-variant/70 font-bold hover:text-primary transition-colors text-sm" href="#"><?= __('Policies') ?></a>
            <a class="text-on-surface-variant/70 font-bold hover:text-primary transition-colors text-sm" href="#"><?= __('Claims') ?></a>
        </div>
    </div>
    <div class="flex items-center gap-6">
        <span class="material-symbols-outlined text-primary cursor-pointer relative">notifications<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-white"></span></span>
        <span class="material-symbols-outlined text-primary cursor-pointer">settings</span>
        <div class="w-8 h-8 rounded-lg overflow-hidden border border-primary/10 shadow-sm"><img src="<?= avatar_url('Admin') ?>" class="w-full h-full object-cover"></div>
    </div>
</nav>

<div class="flex min-h-screen pt-16 bg-surface/30">
    <!-- Sidebar -->
    <aside class="w-72 border-r border-outline-variant/5 flex flex-col py-10 px-8 gap-8 sticky top-16 bg-white/50">
        <div class="bg-indigo-50/50 p-5 rounded-2xl border border-primary/5 flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-xl overflow-hidden shadow-lg border-2 border-white group-hover:scale-110 transition-all">
                <img src="<?= avatar_url($phi['name']) ?>" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="text-primary font-black text-sm tracking-tight mb-0.5"><?= $phi['name'] ?></p>
                <p class="text-[9px] text-on-surface-variant/40 font-black uppercase tracking-widest leading-none">HIGH PRIORITY <?= $COMPANY_NAME ?></p>
            </div>
        </div>

        <nav class="flex flex-col gap-2 pt-4">
            <a class="flex items-center gap-3 px-4 py-3.5 bg-primary/10 text-primary font-black text-xs rounded-xl shadow-sm transition-all" href="#">
                <span class="material-symbols-outlined text-lg">person</span> <?= __('Lead Overview') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">history</span> <?= __('Activity Log') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">calendar_today</span> <?= __('Schedule Call') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">request_quote</span> <?= __('Policy Quotes') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">folder</span> <?= __('Documents') ?>
            </a>
        </nav>

        <div class="mt-auto">
            <a href="<?= config('app.url') ?>/agent/leads/<?= $lead['uuid'] ?>/report" target="_blank" class="w-full bg-primary text-white py-4 rounded-xl font-black text-[11px] uppercase tracking-widest flex items-center justify-center gap-2 shadow-2xl shadow-primary/30 hover:scale-105 transition-all">
                <span class="material-symbols-outlined text-sm">picture_as_pdf</span> <?= __('Generate Quote') ?>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-12 max-w-[1440px] mx-auto">
        <nav class="flex items-center gap-2 text-on-surface-variant/40 text-[11px] font-bold uppercase tracking-widest mb-10">
            <a href="<?= config('app.url') ?>/agent/dashboard" class="hover:text-primary transition-colors"><?= __('Leads') ?></a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary"><?= $phi['name'] ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Central Lead Profile Card -->
            <div class="lg:col-span-8 space-y-10">
                <div class="bg-white rounded-[40px] p-12 shadow-2xl shadow-primary/5 border border-outline-variant/5 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center gap-10">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-[32px] overflow-hidden border-4 border-white shadow-2xl shadow-primary/20">
                                <img src="<?= avatar_url($phi['name'], '00113a', 'fff', 200) ?>" class="w-full h-full object-cover">
                            </div>
                            <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-emerald-500 text-white text-[9px] font-black uppercase px-3 py-1.5 rounded-full ring-4 ring-white tracking-widest shadow-lg"><?= __('VERIFICADO') ?></span>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-5xl font-black text-primary tracking-tighter mb-4"><?= $phi['name'] ?></h1>
                            <div class="flex flex-wrap justify-center md:justify-start items-center gap-6 text-on-surface-variant/50 text-[11px] font-bold uppercase tracking-widest">
                                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">location_on</span> Austin, TX</div>
                                <div class="flex items-center gap-2 underline cursor-pointer hover:text-primary transition-colors"><span class="material-symbols-outlined text-sm">mail</span> <?= $phi['email'] ?></div>
                            </div>
                        </div>
                        <div class="bg-indigo-50/50 p-6 rounded-[32px] border border-primary/5 text-center px-10 shrink-0">
                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1"><?= __('PUNTUACIÓN DEL LEAD') ?></p>
                            <h3 class="text-4xl font-black text-primary tracking-tighter mb-1"><?= (int)$lead['score'] ?>%</h3>
                            <p class="text-emerald-500 text-[8px] font-black uppercase tracking-widest"><?= __('Calificación Alta') ?></p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-12 border-t border-outline-variant/10 pt-10">
                        <button class="flex-1 flex items-center justify-center gap-3 bg-primary text-white py-4 px-8 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/30 hover:scale-105 transition-all">
                            <span class="material-symbols-outlined text-lg">call</span> <?= __('Llamar Ahora') ?>
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-3 bg-[#e9f7f0] text-[#1e4630] py-4 px-8 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#d5eee0] transition-all">
                            <span class="material-symbols-outlined text-lg">chat</span> <?= __('Enviar WhatsApp') ?>
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-3 bg-indigo-50 text-primary py-4 px-8 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-100 transition-all">
                            <span class="material-symbols-outlined text-lg">mail</span> <?= __('Enviar Correo') ?>
                        </button>
                    </div>
                </div>

                <!-- Historial de Actividad -->
                <div class="bg-white rounded-[40px] p-12 shadow-2xl shadow-primary/5 border border-outline-variant/5">
                    <div class="flex items-center gap-4 mb-12">
                        <span class="material-symbols-outlined text-primary text-2xl">history</span>
                        <h2 class="text-2xl font-black text-primary tracking-tight"><?= __('Historial de Actividad') ?></h2>
                    </div>

                    <div class="space-y-12 pl-4 border-l-2 border-outline-variant/10 relative">
                        <?php foreach (array_slice($logs, 0, 4) as $index => $log): ?>
                        <div class="relative">
                            <div class="absolute -left-[27px] top-0 w-5 h-5 rounded-full bg-<?= $index == 0 ? 'primary' : ($index == 2 ? 'emerald-500' : 'surface-container-high') ?> border-4 border-white shadow-md"></div>
                            <div>
                                <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest mb-1"><?= strtoupper(date('D, H:i A', strtotime($log['created_at']))) ?></p>
                                <h4 class="text-sm font-black text-primary mb-1 tracking-tight"><?= $log['action'] ?></h4>
                                <p class="text-[11px] text-on-surface-variant/60 font-medium leading-relaxed"><?= $log['details'] ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- AI Insights & Scheduler -->
            <div class="lg:col-span-4 space-y-10">
                <!-- AI INSIGHTS CARD -->
                <div class="bg-primary rounded-[40px] p-10 text-white relative overflow-hidden shadow-2xl shadow-primary/40">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-emerald-400 text-xl">psychology</span>
                        <h3 class="text-lg font-black tracking-tight uppercase"><?= __('AI INSIGHTS & SCRIPT') ?></h3>
                    </div>
                    
                    <?php 
                    $insights = json_decode($lead['ai_insights'] ?? '{}', true);
                    $profile = $insights['profile'] ?? 'Perfil en evaluación...';
                    $script = $insights['script'] ?? 'Guion no generado.';
                    ?>

                    <div class="mb-8">
                        <p class="text-[10px] font-black text-indigo-200/60 uppercase tracking-widest mb-2 border-b border-white/10 pb-2">Perfil Psicológico Operativo</p>
                        <p class="text-white text-[13px] leading-relaxed italic font-medium">
                            "<?= htmlspecialchars($profile) ?>"
                        </p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-emerald-400/80 uppercase tracking-widest mb-2 border-b border-white/10 pb-2">Micro-Guion Persuasivo (Generado por IA)</p>
                        <div class="bg-white/10 p-4 rounded-2xl border border-white/10 relative">
                            <span class="material-symbols-outlined absolute top-3 right-3 text-white/20 text-sm cursor-pointer hover:text-white transition-colors" title="Copiar guion">content_copy</span>
                            <p class="text-emerald-50 text-[12px] font-medium leading-relaxed">
                                <?= htmlspecialchars($script) ?>
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10">
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3 text-emerald-400 font-bold text-[10px] uppercase tracking-tighter">
                                <span class="material-symbols-outlined text-base">check_circle</span> <?= __('Análisis de Comportamiento LLaMA 3.1') ?>
                            </li>
                        </ul>
                    </div>
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-500 rounded-full opacity-10 blur-[100px]"></div>
                </div>

                <!-- Follow-up Scheduler -->
                <div class="bg-white rounded-[40px] p-10 shadow-2xl shadow-primary/5 border border-outline-variant/5">
                    <div class="flex items-center gap-3 mb-10">
                        <span class="material-symbols-outlined text-primary text-2xl">event_available</span>
                        <h3 class="text-xl font-black text-primary tracking-tight"><?= __('Agenda de Seguimiento') ?></h3>
                    </div>

                    <form class="space-y-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">FECHA DE LA CITA</label>
                                <div class="relative">
                                    <input type="text" class="w-full bg-indigo-50/50 border-none rounded-xl py-3.5 px-4 text-xs font-bold text-primary shadow-sm" placeholder="mm/dd/yyyy"/>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-primary/30 text-base">calendar_today</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">HORA</label>
                                <div class="relative">
                                    <input type="text" class="w-full bg-indigo-50/50 border-none rounded-xl py-3.5 px-4 text-xs font-bold text-primary shadow-sm" placeholder="--:-- --"/>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-primary/30 text-base">schedule</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">TIPO DE LLAMADA</label>
                            <div class="relative">
                                <select class="w-full bg-indigo-50/50 border-none rounded-xl py-3.5 px-4 text-xs font-bold text-primary shadow-sm appearance-none cursor-pointer focus:ring-2 focus:ring-primary">
                                    <option>Llamada Inicial / Introducción</option>
                                    <option>Presentación de Propuesta</option>
                                    <option>Cierre de Venta</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary/30 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">NOTAS DE PREPARACIÓN</label>
                            <textarea class="w-full bg-indigo-50/50 border-none rounded-xl py-4 px-5 text-xs font-medium text-primary shadow-sm h-32 resize-none" placeholder="Ej. El cliente está preocupado por la cobertura de enfermedades críticas..."></textarea>
                        </div>

                        <button type="submit" class="w-full mt-4 py-5 bg-primary text-white font-black rounded-xl hover:bg-primary-container transition-all shadow-xl shadow-primary/20 text-xs uppercase tracking-widest">
                            Agendar Seguimiento
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<footer class="w-full bg-white border-t border-outline-variant/10 px-12 py-8 mt-12 flex flex-col md:flex-row justify-between items-center gap-8">
    <p class="text-[9px] font-black text-on-surface-variant/30 uppercase tracking-widest opacity-60">© <?= date('Y') ?> <?= $COMPANY_NAME ?> FINANCIAL SYSTEMS. SECURE EDITORIAL STANDARD.</p>
    <div class="flex gap-10">
        <a href="#" class="text-[9px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Privacy Policy</a>
        <a href="#" class="text-[9px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Compliance Docs</a>
        <a href="#" class="text-[9px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Support</a>
    </div>
</footer>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
