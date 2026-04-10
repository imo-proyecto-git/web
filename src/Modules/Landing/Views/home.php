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
<section id="hero-section" class="relative min-h-screen flex items-center pt-24 pb-12 overflow-hidden">
    <!-- Large Background Image (Premium Feel with Parallax) -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img id="hero-dynamic-bg" src="<?= config('ui.assets.hero') ?>" class="w-full h-[120%] object-cover opacity-30 blur-[0.5px] transform transition-all duration-700 will-change-transform" style="top: -10%" alt="Family Legacy"/>
        <div class="absolute inset-0 bg-gradient-to-r from-surface via-surface/80 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-surface to-transparent"></div>
    </div>
    
    <div class="max-w-[1440px] mx-auto px-12 grid grid-cols-1 lg:grid-cols-12 gap-20 items-center relative z-10">
        <!-- Hero Text (Modular Scale) -->
        <div class="lg:col-span-7 pt-20">
            <div class="inline-flex items-center gap-3 px-4 py-2 bg-primary/5 rounded-full mb-10 border border-primary/10">
                <span class="w-2 h-2 bg-tertiary rounded-full animate-pulse"></span>
                <span class="text-[11px] font-black text-primary uppercase tracking-[0.3em] font-body">INTELIGENCIA FINANCIERA • LEGADO REAL</span>
            </div>
            <h1 class="font-headline text-7xl xl:text-8xl font-black text-primary leading-[0.9] tracking-[-0.04em] mb-12 uppercase">
                Compra un Término.<br/>
                <span class="text-tertiary">Invierte la Diferencia.</span>
            </h1>
            <p class="text-on-surface-variant/70 font-medium text-xl xl:text-2xl leading-relaxed max-w-2xl mb-16 px-4 border-l-4 border-tertiary/20">
                <?= __('Proporcionamos el blindaje que tu familia merece. No se trata de gastar más, se trata de hacerlo inteligente. Asegura tu futuro hoy mismo.') ?>
            </p>
            
            <!-- Strategic Triad (Icons from Image 1) -->
            <div class="flex flex-wrap gap-12 mb-16">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center text-primary border border-primary/5">
                        <span class="material-symbols-outlined text-3xl">shield</span>
                    </div>
                    <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em]"><?= __('Protege Hoy') ?></p>
                </div>
                <div class="flex flex-col items-center gap-4">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center text-primary border border-primary/5">
                        <span class="material-symbols-outlined text-3xl">trending_up</span>
                    </div>
                    <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em]"><?= __('Crece Mañana') ?></p>
                </div>
                <div class="flex flex-col items-center gap-4">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center text-primary border border-primary/5">
                        <span class="material-symbols-outlined text-3xl">groups</span>
                    </div>
                    <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em]"><?= __('Asegura Siempre') ?></p>
                </div>
            </div>

            <div class="flex flex-wrap gap-8 items-center pt-4">
                <button onclick="document.querySelector('#lead-form-anchor').scrollIntoView({behavior:'smooth'})" class="btn-primary px-12 py-5 text-xs uppercase tracking-[0.2em] shadow-2xl shadow-primary/40 hover:scale-105 transition-all">
                    <?= __('Blindar mi Familia Ahora') ?>
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
                
                <!-- Adaptive Toggle -->
                <div class="flex bg-surface-low p-2 rounded-2xl mb-10 border border-primary/5">
                    <button type="button" onclick="setFormGoal('blindaje')" id="toggle-blindaje" class="flex-1 py-3 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all bg-primary text-white">Blindaje Familiar</button>
                    <button type="button" onclick="setFormGoal('retiro')" id="toggle-retiro" class="flex-1 py-3 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all text-on-surface-variant/40 hover:text-primary">Libertad Retiro</button>
                </div>

                <form action="<?= config('app.url') ?>/api/v1/leads" method="POST" class="space-y-8">
                    <input type="hidden" name="goal" id="form-goal" value="blindaje">
                    
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-on-surface-variant/30 uppercase tracking-[0.2em] px-1 font-body">Nombre Completo</label>
                        <input name="full_name" required class="w-full bg-surface-low border-none rounded-xl py-5 px-8 text-sm font-bold text-primary placeholder:text-primary/10 transition-all focus:ring-2 focus:ring-primary" placeholder="Ej: Juan Pérez" type="text"/>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Correo Electrónico</label>
                            <input name="email" required class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all" placeholder="juan@<?= strtolower(str_replace(' ', '', config('app.company.name'))) ?>.com" type="email"/>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Teléfono</label>
                            <input name="phone" required class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all" placeholder="+1 (555) 000-0000" type="tel"/>
                        </div>
                    </div>

                    <!-- Adaptive Questions Area -->
                    <div id="adaptive-questions" class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Dependientes a proteger</label>
                            <select name="dependents" class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all">
                                <option value="0">Solo yo</option>
                                <option value="1-2">1 - 2 personas</option>
                                <option value="3+">3 o más personas</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full py-6 uppercase text-xs tracking-[0.2em] shadow-2xl shadow-primary/30 hover:scale-[1.02] active:scale-95 transition-all">
                        <?= __('Calcular mi Plan de Blindaje') ?> 
                    </button>
                    <p class="text-[9px] text-center text-on-surface-variant/30 font-black uppercase tracking-widest">Al clicar, aceptas nuestra política de privacidad HIPAA.</p>
                </form>
            </div>
            <!-- Architectural decor -->
            <div class="absolute -right-20 -bottom-20 w-[600px] h-[600px] bg-primary rounded-full opacity-[0.03] blur-[120px]"></div>
        </div>
    </div>
</section>

<!-- Split Screen B2B (Océano Rojo vs Azul) -->
<section id="oceano-section" class="min-h-[80vh] grid grid-cols-1 md:grid-cols-2">
    <!-- Océano Rojo -->
    <div class="bg-[#1f0b0f] text-[#ff8585] p-12 md:p-24 flex flex-col justify-center relative overflow-hidden group border-r border-[#ff8585]/10">
        <div class="relative z-10 max-w-xl mx-auto md:ml-auto md:mr-0 text-left md:text-right">
            <p class="text-[10px] font-black tracking-[0.3em] uppercase mb-8 text-[#ff8585]/60">Lo que conoces</p>
            <h2 class="text-5xl md:text-7xl font-black font-headline tracking-tighter uppercase mb-12 leading-[0.8] text-[#ff8585]">El Océano<br/>Rojo</h2>
            <ul class="space-y-6 mb-16 text-sm font-bold opacity-80 md:ml-auto">
                <li class="flex items-center md:flex-row-reverse gap-4 border-b border-[#ff8585]/10 pb-4"><span class="material-symbols-outlined line-through text-[#ff8585]/40 text-2xl">domain</span> Oficina de 9 a 5, cubículos sin vista</li>
                <li class="flex items-center md:flex-row-reverse gap-4 border-b border-[#ff8585]/10 pb-4"><span class="material-symbols-outlined line-through text-[#ff8585]/40 text-2xl">call</span> Rechazo constante y límite salarial</li>
                <li class="flex items-center md:flex-row-reverse gap-4"><span class="material-symbols-outlined line-through text-[#ff8585]/40 text-2xl">trending_down</span> Competir por precios, estrés y desgaste</li>
            </ul>
        </div>
        <!-- abstract background element -->
        <div class="absolute -left-20 bottom-10 md:bottom-20 w-80 h-80 bg-[#ff8585]/5 rounded-full blur-3xl"></div>
    </div>
    
    <!-- Océano Azul -->
    <div class="bg-[#051120] text-blue-100 p-12 md:p-24 flex flex-col justify-center relative overflow-hidden group">
        <div class="relative z-10 max-w-xl mx-auto md:ml-0 text-left">
            <p class="text-[10px] font-black tracking-[0.3em] uppercase text-sky-400 mb-8 animate-pulse shadow-sky-400">Lo que puedes crear</p>
            <h2 class="text-5xl md:text-7xl font-black font-headline tracking-tighter uppercase text-white mb-12 leading-[0.8]">Tu Océano<br/><span class="text-sky-400">Azul</span></h2>
            <ul class="space-y-6 mb-16 text-sm font-bold opacity-90">
                <li class="flex items-center gap-4 border-b border-sky-400/10 pb-4"><span class="material-symbols-outlined text-sky-400 text-2xl">landscape</span> Trabaja de donde quieras, cuando quieras (Mentally Free)</li>
                <li class="flex items-center gap-4 border-b border-sky-400/10 pb-4"><span class="material-symbols-outlined text-sky-400 text-2xl">groups</span> Lidera un equipo, construye sistema residual</li>
                <li class="flex items-center gap-4"><span class="material-symbols-outlined text-sky-400 text-2xl">military_tech</span> Diferenciación real: clientes que te buscan</li>
            </ul>
            <a href="<?= config('app.url') ?>/login" class="inline-block bg-sky-500 hover:bg-sky-400 text-white shadow-[0_0_50px_rgba(14,165,233,0.3)] hover:shadow-[0_0_80px_rgba(14,165,233,0.5)] px-10 py-5 rounded-none font-black text-xs uppercase tracking-[0.3em] transition-all duration-300">Únete a mi Equipo Automático</a>
        </div>
        <!-- abstract background element -->
        <div class="absolute -right-20 top-10 md:top-20 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl"></div>
    </div>
</section>

<!-- Gamification / Lifestyle (Ubicado después del Océano Azul) -->
<section class="py-40 relative overflow-hidden group">
    <!-- Background Luxury Resort con Parallax-like effect -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover brightness-50 contrast-125 transition-transform duration-1000 group-hover:scale-105" alt="Luxury Resort Background"/>
        <div class="absolute inset-0 bg-gradient-to-b from-primary/80 via-primary/40 to-primary/90"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-12 text-center">
        <p class="text-sky-400 font-black tracking-[0.4em] uppercase text-[11px] mb-6 drop-shadow-md">Bonos • Premios • Libertad Patrimonial</p>
        <h2 class="text-5xl md:text-7xl font-black font-headline text-white uppercase tracking-tighter mb-24 leading-[0.85]">No es un trabajo.<br><span class="text-transparent border-t-2 border-b-2 border-white/20 px-4 -rotate-1 inline-block mt-4 bg-clip-text bg-gradient-to-r from-amber-200 to-amber-500">Es un Estilo de Vida.</span></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Reconocimiento -->
            <div class="backdrop-blur-xl bg-white/5 p-12 rounded-[40px] border border-white/10 hover:border-amber-400/40 transition-all duration-500 hover:-translate-y-4 group/card">
                <div class="w-20 h-20 bg-amber-500/20 rounded-2xl flex items-center justify-center mx-auto mb-10 text-amber-500 shadow-[0_0_30px_rgba(245,158,11,0.2)] group-hover/card:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-5xl">workspace_premium</span>
                </div>
                <h3 class="font-black text-white text-2xl uppercase tracking-tighter mb-6 italic">Reconocimiento <span class="text-amber-400">Rolex</span></h3>
                <p class="text-sm text-white/60 font-medium leading-relaxed">Tus logros no pasan desapercibidos. Premiamos tu excelencia con símbolos de estatus y éxito que perduran.</p>
            </div>
            
            <!-- Viajes -->
            <div class="backdrop-blur-xl bg-white/5 p-12 rounded-[40px] border border-white/10 hover:border-sky-400/40 transition-all duration-500 hover:-translate-y-4 group/card">
                <div class="w-20 h-20 bg-sky-500/20 rounded-2xl flex items-center justify-center mx-auto mb-10 text-sky-500 shadow-[0_0_30px_rgba(14,165,233,0.2)] group-hover/card:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-5xl">flight_takeoff</span>
                </div>
                <h3 class="font-black text-white text-2xl uppercase tracking-tighter mb-6 italic">Viajes Élite <span class="text-sky-400">Resorts</span></h3>
                <p class="text-sm text-white/60 font-medium leading-relaxed">Desde las playas de la Riviera Maya hasta los horizontes de París. Tu pasaporte será tu mejor herramienta de trabajo.</p>
            </div>

            <!-- Bonos -->
            <div class="backdrop-blur-xl bg-white/5 p-12 rounded-[40px] border border-white/10 hover:border-emerald-400/40 transition-all duration-500 hover:-translate-y-4 group/card">
                <div class="w-20 h-20 bg-emerald-500/20 rounded-2xl flex items-center justify-center mx-auto mb-10 text-emerald-500 shadow-[0_0_30px_rgba(16,185,129,0.2)] group-hover/card:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-5xl">payments</span>
                </div>
                <h3 class="font-black text-white text-2xl uppercase tracking-tighter mb-6 italic">Bonos <span class="text-emerald-400">Predictibles</span></h3>
                <p class="text-sm text-white/60 font-medium leading-relaxed">Crea una base financiera sólida con bonos basados en impacto real. Dinero real para metas reales.</p>
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
                <div class="max-w-2xl">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center mb-10 text-emerald-500 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl FILL-1">verified_user</span>
                    </div>
                    <h3 class="text-3xl font-black text-primary mb-10 tracking-tight">Construye tu Libertad</h3>
                    
                    <!-- Checklist from Image 2 -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 text-primary font-bold">
                            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                            <span>Amplía tu cobertura significativamente.</span>
                        </div>
                        <div class="flex items-center gap-4 text-primary font-bold">
                            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                            <span>Reduce tu costo operativo y primas.</span>
                        </div>
                        <div class="flex items-center gap-4 text-primary font-bold">
                            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                            <span>Invierte para un mejor futuro patrimonial.</span>
                        </div>
                        <div class="flex items-center gap-4 text-primary font-bold">
                            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                            <span>Disfruta con tranquilidad tus años dorados.</span>
                        </div>
                    </div>
                </div>
                <div class="mt-14 flex items-center text-primary font-black gap-3 group-hover:gap-6 transition-all cursor-pointer uppercase tracking-widest text-[11px]">
                    Ver Planes Verificados <span class="material-symbols-outlined">arrow_forward</span>
                </div>
            </div>
            
            <div class="md:col-span-4 bg-primary p-12 rounded-[40px] text-white flex flex-col justify-between shadow-2xl shadow-primary/20 relative overflow-hidden">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-4xl text-blue-400 mb-10 block">auto_awesome</span>
                    <h3 class="text-3xl font-black mb-6 tracking-tight">Legado Real</h3>
                    <p class="text-white/60 leading-relaxed font-medium">No se trata de gastar más en seguros, sino de usar ese capital para crear libertad real para los tuyos.</p>
                </div>
                <div class="mt-14 text-white/40 text-[11px] font-black tracking-widest uppercase relative z-10">Metodología BTID Certificada</div>
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-500 rounded-full opacity-10 blur-[100px]"></div>
            </div>
        </div>

            </div>
        </div>

        <!-- Educación Financiera: El Principio "Término + Inversión" (Propuesta 4) -->
        <div class="mt-20 bg-white border-4 border-primary/5 rounded-[48px] p-12 md:p-20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-1/3 h-full bg-indigo-50/50 -skew-x-12 translate-x-1/2"></div>
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="px-4 py-1.5 bg-amber-500/10 text-amber-700 text-[10px] font-black uppercase tracking-[0.3em] rounded-lg mb-8 inline-block border border-amber-500/20">La Regla Dorada de Wall Street</span>
                    <h3 class="text-4xl md:text-5xl font-black text-primary tracking-tighter mb-10 leading-[0.9] italic">"Compra a término e invierte la diferencia"</h3>
                    <p class="text-lg text-on-surface-variant/70 font-medium leading-relaxed mb-10">
                        No somos vendedores de pólizas, somos tus <strong>educadores financieros</strong>. El seguro tradicional es costoso e ineficiente. Nuestra metodología te enseña no solo a estar protegido hoy, sino a ser rico mañana.
                    </p>
                    <div class="flex items-center gap-6">
                        <div class="flex flex-col">
                            <span class="text-3xl font-black text-primary italic">20X</span>
                            <span class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest">Protección superior</span>
                        </div>
                        <div class="w-px h-10 bg-outline-variant/10"></div>
                        <div class="flex flex-col">
                            <span class="text-3xl font-black text-emerald-500 italic">$0.00</span>
                            <span class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest">En costos ocultos</span>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-low rounded-3xl p-10 border border-outline-variant/10 shadow-2xl shadow-primary/5 relative">
                    <div class="flex justify-between items-center mb-10 border-b border-outline-variant/10 pb-6">
                        <p class="text-[11px] font-black uppercase tracking-widest text-primary">Comparativa de Acumulación</p>
                        <span class="material-symbols-outlined text-primary/30">insights</span>
                    </div>
                    <!-- Mock Graph simple para impacto visual -->
                    <div class="space-y-8">
                        <div>
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-2">
                                <span class="text-on-surface-variant/40">Seguro Tradicional</span>
                                <span class="text-red-500">Estancado</span>
                            </div>
                            <div class="h-3 bg-red-100 rounded-full overflow-hidden">
                                <div class="h-full bg-red-500 w-1/4 transition-all duration-1000 group-hover:w-1/3"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-2">
                                <span class="text-primary italic">Estrategia empresaIMO</span>
                                <span class="text-emerald-500 animate-pulse">Crecimiento Compuesto</span>
                            </div>
                            <div class="h-3 bg-emerald-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 w-full shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-10 text-[10px] text-on-surface-variant/40 font-bold italic text-center">Basado en proyecciones promedio de interés compuesto del 8% anual.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Manifiesto Latino -->
<section class="py-32 bg-primary text-white text-center px-6 md:px-12 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2000&auto=format&fit=crop')] bg-cover opacity-10 mix-blend-overlay"></div>
    <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-emerald-400 via-amber-400 to-sky-400"></div>
    <div class="max-w-4xl mx-auto relative z-10">
        <span class="material-symbols-outlined text-6xl text-emerald-400 mb-10 block">handshake</span>
        <h2 class="text-4xl md:text-5xl font-black tracking-tighter uppercase leading-[1.1] mb-8 font-headline">Estamos acostumbrados a hacer todo solos...<br/><span class="text-amber-400">pero juntos llegamos más lejos.</span></h2>
        <p class="text-lg md:text-xl text-white/80 font-medium leading-relaxed mb-12 max-w-3xl mx-auto">
            Somos Latinos. Entendemos nuestro camino, los retos y el sacrificio. Por eso aquí nadie se queda atrás. Nos apoyamos, nos enseñamos y crecemos juntos. Porque cuando uno gana, todos ganamos. <strong>Un equipo que te da familia.</strong>
        </p>
        <button class="bg-white text-primary hover:bg-surface-container hover:scale-105 shadow-[0_0_60px_rgba(255,255,255,0.15)] px-12 py-5 font-black text-[11px] uppercase tracking-[0.3em] transition-all rounded-xl border-4 border-white/10 relative group">
            SÉ EL EJEMPLO QUE OTROS NECESITAN VER
        </button>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonios" class="py-24 bg-surface/50">
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
                        <img src="<?= avatar_url($t['name']) ?>" class="w-full h-full object-cover"/>
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
<!-- Global Floating Assistant -->
<div id="floating-chat" class="fixed bottom-8 right-8 z-[60] flex flex-col items-end gap-4 transition-all duration-500 transform translate-y-10 opacity-0 pointer-events-none">
    <!-- Chat Window -->
    <div id="chat-window" class="w-72 bg-primary/95 backdrop-blur-2xl rounded-3xl shadow-[0_32px_64px_-16px_rgba(0,17,58,0.5)] p-5 border border-white/10 mb-2 scale-90 opacity-0 pointer-events-none origin-bottom-right transition-all duration-500">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-emerald-500/30 flex-shrink-0">
                    <img src="<?= config('ui.assets.asistente') ?>" class="w-full h-full object-cover" alt="Asistente Virtual"/>
                </div>
                <div>
                    <p class="text-white text-xs font-black tracking-tight"><?= __('Ana') ?></p>
                    <p class="text-emerald-400 text-[8px] font-bold tracking-widest uppercase">ASESORA SENIOR</p>
                </div>
            </div>
            <button onclick="toggleChat(false)" class="w-8 h-8 rounded-full hover:bg-white/10 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-white/40 text-lg">close</span>
            </button>
        </div>
        <div class="space-y-4 mb-6">
            <div class="bg-indigo-500/20 p-4 rounded-2xl rounded-tl-none border border-white/5">
                <p class="text-white/80 text-[10px] leading-relaxed">Hola 👋 Soy Ana. ¿Estás buscando proteger tu patrimonio o planificar tu retiro? Te guiaré paso a paso.</p>
            </div>
            <div class="bg-emerald-500/20 p-3 rounded-2xl text-center border border-white/10 cursor-pointer hover:bg-emerald-500/40 transition-all">
                <p class="text-white font-black text-[9px]"><?= __('Hablar con Ana') ?></p>
            </div>
        </div>
        <div class="relative">
            <input class="w-full bg-white/10 border-none rounded-xl py-3 pl-4 pr-12 text-[10px] text-white placeholder:text-white/20 focus:ring-1 focus:ring-emerald-500/50" placeholder="Pregunta algo..."/>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-white/50 text-sm">send</span>
        </div>
    </div>
    
    <!-- Bubble Toggle -->
    <button onclick="toggleChat()" class="w-16 h-16 bg-primary rounded-full shadow-2xl flex items-center justify-center group relative hover:scale-110 transition-all duration-300">
        <div class="absolute inset-0 bg-primary rounded-full animate-ping opacity-20 group-hover:opacity-40"></div>
        <span id="chat-icon-open" class="material-symbols-outlined text-white text-3xl">chat</span>
        <span id="chat-icon-close" class="material-symbols-outlined text-white text-3xl hidden">close</span>
    </button>
</div>

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
/**
 * Lógica de Formulario Adaptativo (Blindaje vs Retiro)
 */
function setFormGoal(goal) {
    const hiddenInput = document.getElementById('form-goal');
    const adaptiveArea = document.getElementById('adaptive-questions');
    const btnBlindaje = document.getElementById('toggle-blindaje');
    const btnRetiro = document.getElementById('toggle-retiro');
    const submitBtn = document.querySelector('#lead-form-anchor button[type="submit"]');
    const heroBg = document.getElementById('hero-dynamic-bg');
    
    hiddenInput.value = goal;
    
    if (goal === 'blindaje') {
        heroBg.src = "<?= config('ui.assets.hero') ?>";
        btnBlindaje.className = "flex-1 py-3 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all bg-primary text-white";
        btnRetiro.className = "flex-1 py-3 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all text-on-surface-variant/40 hover:text-primary";
        submitBtn.innerText = "<?= __('Calcular mi Plan de Blindaje') ?>";
        
        adaptiveArea.innerHTML = `
            <div class="space-y-4 animate-in fade-in slide-in-from-left-4 duration-500">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Dependientes a proteger</label>
                    <select name="dependents" class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all">
                        <option value="0">Solo yo</option>
                        <option value="1-2">1 - 2 personas</option>
                        <option value="3+">3 o más personas</option>
                    </select>
                </div>
                <div class="p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-500 text-lg">verified</span>
                    <p class="text-[9px] font-bold text-emerald-700 uppercase tracking-widest">Prioridad: Blindaje contra inflación</p>
                </div>
            </div>
        `;
    } else {
        heroBg.src = "<?= config('ui.assets.legacy') ?>";
        btnRetiro.className = "flex-1 py-3 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all bg-primary text-white";
        btnBlindaje.className = "flex-1 py-3 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all text-on-surface-variant/40 hover:text-primary";
        submitBtn.innerText = "<?= __('Construir mi Libertad de Retiro') ?>";

        adaptiveArea.innerHTML = `
            <div class="space-y-4 animate-in fade-in slide-in-from-right-4 duration-500">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Edad Actual (aprox)</label>
                    <select name="current_age" class="w-full bg-white border-none ring-1 ring-primary/5 focus:ring-2 focus:ring-primary rounded-xl py-4 px-5 text-sm font-bold shadow-sm transition-all">
                        <option value="20-35">20 a 35 años</option>
                        <option value="36-50">36 a 50 años</option>
                        <option value="50+">Más de 50 años</option>
                    </select>
                </div>
                <div class="p-4 bg-indigo-500/5 border border-indigo-500/10 rounded-2xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-indigo-500 text-lg">wb_sunny</span>
                    <p class="text-[9px] font-bold text-indigo-700 uppercase tracking-widest">Enfoque: Rendimiento de Interés Compuesto</p>
                </div>
            </div>
        `;
    }
}

/**
 * Lógica de Asistente Flotante
 */
function toggleChat(force) {
    const windowEl = document.getElementById('chat-window');
    const iconOpen = document.getElementById('chat-icon-open');
    const iconClose = document.getElementById('chat-icon-close');
    
    const isOpen = (force !== undefined) ? force : windowEl.classList.contains('opacity-0');
    
    if (isOpen) {
        windowEl.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
    } else {
        windowEl.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }
}

/**
 * Orquestación del Asistente Virtual (IntersectionObserver & Parallax)
 */
document.addEventListener('DOMContentLoaded', () => {
    const heroBg = document.getElementById('hero-dynamic-bg');
    const floatingChat = document.getElementById('floating-chat');
    const heroSection = document.getElementById('hero-section');
    const sectionNosotros = document.getElementById('nosotros');
    const sectionTestimonios = document.getElementById('testimonios');
    
    let hasAutoOpened = false;

    // 1. Optimised Parallax fallback (solo para el hero visual)
    window.addEventListener('scroll', () => {
        if (!heroBg) return;
        const scrolled = window.pageYOffset;
        if (scrolled < window.innerHeight) {
            heroBg.style.transform = `translateY(${scrolled * 0.4}px) scale(1.1)`;
        }
    }, { passive: true });
    
    if (!floatingChat) return;

    // 2. Observer para Ocultar en Hero y Mostrar icono después
    if (heroSection) {
        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio > 0.4) {
                    floatingChat.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
                    floatingChat.classList.remove('opacity-100', 'translate-y-0');
                } else {
                    floatingChat.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
                    floatingChat.classList.add('opacity-100', 'translate-y-0');
                }
            });
        }, { threshold: [0.1, 0.4, 0.5] });
        heroObserver.observe(heroSection);
    }

    // 3. Observer para el Auto-Apertura (Invitación permanente una vez vista)
    const oceanoSection = document.getElementById('oceano-section');
    if (oceanoSection) {
        const oceanoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasAutoOpened) {
                    toggleChat(true);
                    hasAutoOpened = true; 
                    oceanoObserver.disconnect();
                }
            });
        }, { threshold: 0.1 });
        oceanoObserver.observe(oceanoSection);
    }

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
