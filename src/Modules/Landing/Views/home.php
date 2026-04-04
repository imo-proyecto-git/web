<?php include __DIR__ . '/layout/header.php'; ?>

<!-- Unified Navigation (Architectural Glass) -->
<nav class="fixed top-0 w-full z-50 glass-card h-20 flex justify-between items-center px-12">
    <div class="flex items-center gap-16">
        <span class="text-3xl font-black text-primary tracking-tighter font-headline lowercase"><?= $COMPANY_NAME ?></span>
        <div class="hidden md:flex gap-10 items-center">
            <a class="text-primary font-black uppercase text-xs tracking-[0.2em]" href="<?= config('app.url') ?>/"><?= __('Directorio') ?></a>
            <a class="text-on-surface-variant/40 font-black uppercase text-xs tracking-[0.2em] hover:text-primary transition-colors" href="#nosotros"><?= __('Nosotros') ?></a>
            <a class="text-on-surface-variant/40 font-black uppercase text-xs tracking-[0.2em] hover:text-primary transition-colors" href="#coberturas"><?= __('Coberturas') ?></a>
            <a class="text-on-surface-variant/40 font-black uppercase text-xs tracking-[0.2em] hover:text-primary transition-colors" href="#testimonios"><?= __('Testimonios') ?></a>
        </div>
    </div>
    <div class="flex items-center gap-8">
        <a href="<?= config('app.url') ?>/login" class="text-primary font-black text-xs uppercase tracking-widest hover:opacity-60 transition-all"><?= __('Portal Acceso') ?></a>
        <button onclick="document.querySelector('#lead-form-anchor').scrollIntoView({behavior:'smooth'})" class="btn-primary px-8 py-3.5 uppercase text-[10px] tracking-widest shadow-2xl shadow-primary/20 hover:scale-105 transition-all"><?= __('Comenzar Ahora') ?></button>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-32 pb-24 overflow-hidden bg-surface">
    <!-- Grid pattern background -->
    <div class="absolute inset-x-0 bottom-0 h-80 bg-gradient-to-t from-primary/5 to-transparent pointer-events-none"></div>
    
    <div class="max-w-[1440px] mx-auto px-12 grid grid-cols-1 lg:grid-cols-12 gap-20 items-center">
        <!-- Hero Text (Scale Leap) -->
        <div class="lg:col-span-7 pt-20">
            <div class="inline-flex items-center gap-3 px-4 py-2 bg-primary/5 rounded-full mb-10">
                <span class="w-2 h-2 bg-tertiary rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em] font-body"><?= __('Infraestructura FinTech Certificada') ?></span>
            </div>
            <h1 class="font-headline text-[7.5rem] font-black text-primary leading-[0.8] tracking-[-0.04em] mb-12 uppercase">
                Asegura tu<br/>
                <span class="text-tertiary">Legado Ahora.</span>
            </h1>
            <p class="text-on-surface-variant/60 font-medium text-2xl leading-relaxed max-w-2xl mb-16 px-1 border-l-4 border-primary/5">
                <?= __('Proporcionamos el motor tecnológico que impulsa a las IMOs más exitosas. No asuma riesgos innecesarios. Proteja el futuro de su familia con nuestra arquitectura financiera blindada (HIPAA/GDPR). Cupos de evaluación premium limitados este mes.') ?>
            </p>
            <div class="flex flex-wrap gap-8 items-center pt-4">
                <button class="btn-primary px-12 py-5 text-xs uppercase tracking-[0.2em] shadow-2xl shadow-primary/40 hover:scale-105 transition-all">
                    <?= __('Iniciar Auditoría') ?>
                </button>
                <button class="text-primary font-black text-xs uppercase tracking-[0.2em] hover:translate-x-2 transition-transform flex items-center gap-3">
                    <?= __('Ver Documentación') ?> <span class="material-symbols-outlined">east</span>
                </button>
            </div>
        </div>
        
        <!-- Form Architectural Box (Tonal Layering: Surface-Lowest on Surface-Low) -->
        <div id="lead-form-anchor" class="lg:col-span-5 relative pt-20">
            <div class="bg-surface-lowest p-12 rounded-[48px] shadow-[0_80px_120px_-20px_rgba(0,17,58,0.12)] relative z-10 border border-primary/5 cursor-crosshair">
                <div class="flex items-center gap-3 mb-8">
                    <span class="w-3 h-3 bg-red-500 rounded-full animate-ping"></span> <span class="text-xs font-black text-primary uppercase tracking-widest">En Vivo</span>
                </div>
                <h3 class="font-headline text-3xl font-black text-primary mb-10 tracking-tighter uppercase leading-none"><?= __('Protege tu Patrimonio Hoy') ?></h3>
                <form action="<?= config('app.url') ?>/api/v1/leads" method="POST" class="space-y-10">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-on-surface-variant/30 uppercase tracking-[0.2em] px-1 font-body">Nombre Completo</label>
                        <input name="full_name" required class="w-full bg-surface-low border-none rounded-xl py-5 px-8 text-sm font-bold text-primary placeholder:text-primary/10 transition-all focus:ring-2 focus:ring-primary" placeholder="Ej: Juan Pérez" type="text"/>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Correo Electrónico</label>
                            <input name="email" required class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all" placeholder="juan@empresa.com" type="email"/>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Teléfono</label>
                            <input name="phone" required class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all" placeholder="+1 (555) 000-0000" type="tel"/>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Tipo de Seguro</label>
                        <div class="relative">
                            <select name="service_type" class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all appearance-none cursor-pointer">
                                <option value="life">Seguro de Vida</option>
                                <option value="health">Gastos Médicos Mayores</option>
                                <option value="wealth">Protección Patrimonial</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary/30 pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full py-6 uppercase text-xs tracking-[0.2em] shadow-2xl shadow-primary/30 hover:scale-[1.02] active:scale-95 transition-all">
                        <?= __('Calcular Cobertura') ?> 
                    </button>
                    <p class="text-[9px] text-center text-on-surface-variant/30 font-black uppercase tracking-widest">Al clicar, aceptas nuestra política de privacidad HIPAA.</p>
                </form>
            </div>
            <!-- Architectural decor -->
            <div class="absolute -right-20 -bottom-20 w-[600px] h-[600px] bg-primary rounded-full opacity-[0.03] blur-[120px]"></div>
        </div>
            <!-- Chat Widget Overlay -->
            <div class="absolute -bottom-8 -right-8 z-20 w-80 bg-primary/95 backdrop-blur-xl rounded-3xl shadow-2xl p-6 border border-white/10 hidden md:block">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center relative">
                            <span class="material-symbols-outlined text-emerald-400 text-lg">chat</span>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-primary"></span>
                        </div>
                        <div>
                            <p class="text-white text-xs font-black tracking-tight"><?= __('Asistente Virtual') ?></p>
                            <p class="text-emerald-400 text-[10px] font-bold tracking-widest uppercase">EN LÍNEA</p>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-white/40 cursor-pointer">close</span>
                </div>
                <div class="space-y-4 mb-6">
                    <div class="bg-indigo-500/20 p-4 rounded-2xl rounded-tl-none border border-white/5">
                        <p class="text-white/80 text-[11px] leading-relaxed">Hola 👋 ¿Estás buscando proteger tu patrimonio? Te puedo ayudar a pre-calificar en 2 minutos.</p>
                    </div>
                    <div class="bg-indigo-500/10 p-3 rounded-2xl text-center border border-white/5 cursor-pointer hover:bg-indigo-500/30 transition-all">
                        <p class="text-white font-black text-[11px]"><?= __('Sí, busco seguro de vida.') ?></p>
                    </div>
                </div>
                <div class="relative">
                    <input class="w-full bg-white/10 border-none rounded-xl py-3 pl-4 pr-12 text-[10px] text-white placeholder:text-white/20 focus:ring-1 focus:ring-emerald-500/50" placeholder="Escribe tu mensaje..."/>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-white/50 text-sm">send</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Bastion Section -->
<section id="nosotros" class="py-24 bg-white">
    <div class="max-w-[1440px] mx-auto px-12">
        <div class="mb-20">
            <h2 class="font-headline text-5xl font-black text-primary tracking-tighter mb-4"><?= __('¿Por qué elegir ') . $COMPANY_NAME . '?' ?></h2>
            <div class="h-1.5 w-24 bg-emerald-500 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-8">
            <div class="md:col-span-8 bg-surface-container-low/30 p-12 rounded-[40px] border border-outline-variant/5 flex flex-col justify-between group hover:shadow-2xl hover:shadow-primary/5 transition-all">
                <div class="max-w-md">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center mb-10 text-emerald-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl FILL-1">verified_user</span>
                    </div>
                    <h3 class="text-3xl font-black text-primary mb-6 tracking-tight">Seguridad Institucional</h3>
                    <p class="text-on-surface-variant leading-relaxed font-medium opacity-70">Implementamos protocolos de seguridad Azure Shield, garantizando que su información financiera y personal permanezca blindada bajo los estándares HIPAA y GDPR más estrictos.</p>
                </div>
                <div class="mt-14 flex items-center text-primary font-black gap-3 group-hover:gap-6 transition-all cursor-pointer uppercase tracking-widest text-[11px]">
                    Saber más <span class="material-symbols-outlined">arrow_forward</span>
                </div>
            </div>
            
            <div class="md:col-span-4 bg-primary p-12 rounded-[40px] text-white flex flex-col justify-between shadow-2xl shadow-primary/20 relative overflow-hidden">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-4xl text-blue-400 mb-10 block">bolt</span>
                    <h3 class="text-3xl font-black mb-6 tracking-tight">Rapidez Extrema</h3>
                    <p class="text-white/60 leading-relaxed font-medium">Cotizaciones en tiempo real impulsadas por IA. Sin papeleo innecesario, solo resultados inmediatos.</p>
                </div>
                <div class="mt-14 text-white/40 text-[11px] font-black tracking-widest uppercase relative z-10">98% Eficiencia Operativa</div>
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-500 rounded-full opacity-10 blur-[100px]"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <div class="md:col-span-4 bg-indigo-50 p-12 rounded-[40px] border border-primary/5 flex flex-col justify-between group">
                <div>
                    <span class="material-symbols-outlined text-4xl text-primary mb-10 block">groups</span>
                    <h3 class="text-3xl font-black text-primary mb-6 tracking-tight">Resiliencia</h3>
                    <p class="text-primary/60 leading-relaxed font-medium">Modelos de cobertura adaptables que crecen con usted, asegurando su patrimonio ante cualquier imprevisto global.</p>
                </div>
            </div>
            <div class="md:col-span-8 relative rounded-[40px] overflow-hidden group shadow-2xl shadow-primary/20 border border-outline-variant/10">
                <img src="<?= config('app.url') ?>/assets/img/imo_fintech_hero.png" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 group-hover:-rotate-1" alt="Fintech Data Center Concept"/>
                <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/30 to-transparent"></div>
                <div class="absolute bottom-12 left-12">
                    <p class="text-emerald-400 font-bold uppercase tracking-[0.2em] text-[10px] mb-2 px-2 py-1 bg-emerald-500/10 inline-block rounded-md border border-emerald-500/20">AI LEAD SCORING</p>
                    <p class="text-white font-black text-3xl tracking-tight leading-tight">Analítica predictiva para tu futuro.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-24 bg-surface/50">
    <div class="max-w-[1440px] mx-auto px-12">
        <h2 class="text-center font-headline text-4xl font-black text-primary tracking-tighter mb-20"><?= __('Lo que dicen nuestros asegurados') ?></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php 
            $testimonials = [
                ['name' => 'Carlos Méndez', 'role' => 'Dueño de Empresa, Miami', 'text' => '"La rapidez del proceso me sorprendió. En menos de 10 minutos ya tenía mi póliza de vida configurada y lista para firmar."'],
                ['name' => 'Elena Rodríguez', 'role' => 'Consultora Senior, CDMX', 'text' => '"Busqué protección que funcionara tanto en México como en EE.UU. ' . $COMPANY_NAME . ' fue el único que entendió mis necesidades binacionales."'],
                ['name' => 'Roberto G.', 'role' => 'Arquitecto, Texas', 'text' => '"La transparencia en los costos y la claridad de la póliza me dieron la tranquilidad que buscaba para mi familia."'],
            ];
            foreach ($testimonials as $t): 
            ?>
            <div class="bg-white p-10 rounded-[32px] shadow-xl shadow-primary/5 border-l-[6px] border-emerald-500/30 flex flex-col justify-between">
                <div>
                    <div class="flex text-emerald-500 mb-6 gap-0.5">
                        <span class="material-symbols-outlined FILL-1 text-sm">star</span>
                        <span class="material-symbols-outlined FILL-1 text-sm">star</span>
                        <span class="material-symbols-outlined FILL-1 text-sm">star</span>
                        <span class="material-symbols-outlined FILL-1 text-sm">star</span>
                        <span class="material-symbols-outlined FILL-1 text-sm">star</span>
                    </div>
                    <p class="text-on-surface-variant font-medium italic leading-relaxed text-sm opacity-80 mb-10"><?= $t['text'] ?></p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl overflow-hidden border-2 border-primary/5">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($t['name']) ?>&background=00113a&color=fff" class="w-full h-full object-cover"/>
                    </div>
                    <div>
                        <p class="text-primary font-black text-sm tracking-tight"><?= $t['name'] ?></p>
                        <p class="text-[10px] text-on-surface-variant/40 font-bold uppercase tracking-widest"><?= $t['role'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-white border-t border-outline-variant/5 py-24">
    <div class="max-w-[1440px] mx-auto px-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-16 mb-24">
            <div class="md:col-span-6 space-y-8">
                <h2 class="text-2xl font-black text-primary tracking-tighter"><?= $COMPANY_NAME ?></h2>
                <p class="text-sm text-on-surface-variant leading-relaxed max-w-sm font-medium opacity-60">
                    <?= config('app.company.description', 'Líderes en tecnología Insurtech para el mercado hispano.') ?>
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <span class="px-3 py-1.5 bg-surface-container-low text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest border border-outline-variant/10 rounded-lg">HIPAA COMPLIANT</span>
                    <span class="px-3 py-1.5 bg-surface-container-low text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest border border-outline-variant/10 rounded-lg">GDPR READY</span>
                    <span class="px-3 py-1.5 bg-surface-container-low text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest border border-outline-variant/10 rounded-lg">MIL SECURE</span>
                </div>
            </div>
            <div class="md:col-span-3">
                <h4 class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest mb-8">ENLACES</h4>
                <ul class="space-y-4">
                    <li><a href="#" class="text-xs font-bold text-on-surface-variant/60 hover:text-primary transition-all">Privacy Policy</a></li>
                    <li><a href="#" class="text-xs font-bold text-on-surface-variant/60 hover:text-primary transition-all">Terms of Service</a></li>
                    <li><a href="#" class="text-xs font-bold text-on-surface-variant/60 hover:text-primary transition-all">Compliance</a></li>
                </ul>
            </div>
            <div class="md:col-span-3">
                <h4 class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest mb-8">SOPORTE</h4>
                <ul class="space-y-4">
                    <li><a href="#" class="text-xs font-bold text-on-surface-variant/60 hover:text-primary transition-all">Contact Support</a></li>
                    <li><a href="#" class="text-xs font-bold text-on-surface-variant/60 hover:text-primary transition-all">Ayuda 24/7</a></li>
                    <li><a href="#" class="text-xs font-bold text-on-surface-variant/60 hover:text-primary transition-all">FAQ</a></li>
                </ul>
            </div>
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-center pt-10 border-t border-outline-variant/5 gap-8">
            <p class="text-[9px] font-black text-on-surface-variant/30 uppercase tracking-widest">© <?= date('Y') ?> <?= $COMPANY_NAME ?>. All rights reserved. HIPAA Compliant. SSL Secured.</p>
            <p class="text-[9px] font-black text-on-surface-variant/30 uppercase tracking-widest"><?= __('Operated by ') . config('app.company.legal_name', $COMPANY_NAME . ' Risk Management LLC') ?></p>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const leadForm = document.querySelector('form[action$="/api/v1/leads"]');
    if (!leadForm) return;

    // Resilient Offline Queue (IndexedDB/localStorage alternative)
    const OFFLINE_QUEUE_KEY = 'imo_offline_leads';
    
    const syncOfflineQueue = async () => {
        if (!navigator.onLine) return;
        const queue = JSON.parse(localStorage.getItem(OFFLINE_QUEUE_KEY) || '[]');
        if (queue.length === 0) return;
        
        console.log(`[IMO-OS] Re-syncing ${queue.length} offline leads...`);
        try {
            await fetch('<?= config('app.url') ?>/api/v1/sync/offline', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ batch: queue })
            });
            localStorage.removeItem(OFFLINE_QUEUE_KEY);
            console.log('[IMO-OS] Offline sync complete.');
        } catch(e) {
            console.warn('[IMO-OS] Sync failed, keeping in queue.');
        }
    };

    window.addEventListener('online', syncOfflineQueue);

    leadForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btn = leadForm.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center gap-3"><span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> <?= __("PROCESANDO...") ?></span>';

        const formData = new FormData(leadForm);
        const dataObj = Object.fromEntries(formData.entries());
        dataObj.timestamp = new Date().toISOString();
        
        if (!navigator.onLine) {
            // Guarda localmente si no hay red (Resiliencia)
            const queue = JSON.parse(localStorage.getItem(OFFLINE_QUEUE_KEY) || '[]');
            queue.push(dataObj);
            localStorage.setItem(OFFLINE_QUEUE_KEY, JSON.stringify(queue));
            
            leadForm.parentElement.innerHTML = `
                <div class="py-12 text-center animate-in fade-in zoom-in duration-500">
                    <div class="w-24 h-24 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-10 text-amber-500 shadow-2xl shadow-amber-500/20">
                        <span class="material-symbols-outlined text-5xl font-black">wifi_off</span>
                    </div>
                    <h3 class="font-headline text-3xl font-black text-primary mb-6 tracking-tighter uppercase leading-none italic">Recibido (Modo Offline)</h3>
                    <p class="text-on-surface-variant/40 font-bold uppercase tracking-widest text-[10px] mb-6">Tus datos están seguros. Se procesarán automáticamente al reconectar.</p>
                </div>
            `;
            return;
        }

        try {
            const response = await fetch(leadForm.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                leadForm.parentElement.innerHTML = `
                    <div class="py-12 text-center animate-in fade-in zoom-in duration-500">
                        <div class="w-24 h-24 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-10 text-emerald-500 shadow-2xl shadow-emerald-500/20">
                            <span class="material-symbols-outlined text-5xl font-black">verified</span>
                        </div>
                        <h3 class="font-headline text-4xl font-black text-primary mb-6 tracking-tighter uppercase leading-none italic">${result.message}</h3>
                        <p class="text-on-surface-variant/40 font-bold uppercase tracking-[0.2em] text-[10px] mb-12">REF: ${result.ref || 'SECURE-001'} • HIPAA CERTIFIED</p>
                        <div class="h-1.5 w-24 bg-emerald-500 rounded-full mx-auto"></div>
                    </div>
                `;
            } else {
                alert(result.message || 'Error en el sistema.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Lead submission failure:', error);
            // Fallback for unexpected failures:
            const queue = JSON.parse(localStorage.getItem(OFFLINE_QUEUE_KEY) || '[]');
            queue.push(dataObj);
            localStorage.setItem(OFFLINE_QUEUE_KEY, JSON.stringify(queue));
            alert('Fallo de red detectado. Tu cobertura será procesada en segundo plano y te contactaremos.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
    
    // Initial sync intent
    syncOfflineQueue();
});
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
