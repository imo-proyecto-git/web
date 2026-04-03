<?php include __DIR__ . '/layout/header.php'; ?>

<!-- Top Navigation Bar -->
<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-md shadow-xl shadow-primary/5 h-16 flex justify-between items-center px-8">
    <div class="text-xl font-black text-primary font-headline"><?= $COMPANY_NAME ?></div>
    <div class="hidden md:flex space-x-8 items-center">
        <a class="text-primary border-b-2 border-primary font-bold pb-1 text-sm tracking-tight" href="#">Inicio</a>
        <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#productos">Productos</a>
        <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#nosotros">Nosotros</a>
        <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#contacto">Contacto</a>
    </div>
    <div class="flex items-center space-x-6">
        <a href="<?= config('app.url') ?>/login" class="px-5 py-2.5 bg-primary text-white font-black rounded-xl hover:scale-105 hover:shadow-xl hover:shadow-primary/20 transition-all text-xs uppercase tracking-widest">
            Portal Agente
        </a>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-primary to-primary-container opacity-5"></div>
        <img alt="Modern architectural background" class="w-full h-full object-cover opacity-10 grayscale" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCNxjpEpAGVhjzGHzrftZ1ks0ITjzUN5Z2gUsNpaXDSxoHM_WyMtqS7H0x_EANvnN_Ln8zCDV_ifcc3qdnL5oTPFl-zZ6tN3IStzIUIIjV2JeTKdVtKe3BemAClegJS1J7caPOoz61CY7FUAIO1Sx9WQCBYveyKHbBAsso7WDsPU0WXvXOY7YTlERh-P8kqHI20eYyNPNP3KNYbIC7XzrGf40-5DuzDnxZVjOaBSHQREq_592X9-_wU2NaIuJwSTyQetcNB7H6wNP7"/>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8">
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-surface-container-high text-on-tertiary-container text-xs font-bold tracking-widest uppercase">
                Protección de Nivel Institucional
            </div>
            <h1 class="font-headline text-5xl md:text-7xl font-extrabold tracking-tight text-primary leading-[1.1]">
                <?= $title ?>
            </h1>
            <p class="text-lg text-on-surface-variant max-w-lg leading-relaxed">
                <?= $subtitle ?> Resiliencia financiera diseñada para el mercado de EE.UU. y LatAm. Tecnología <strong>Azure Shield</strong> para la máxima seguridad.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="px-10 py-5 bg-on-tertiary-container text-white font-black rounded-2xl shadow-2xl shadow-on-tertiary-container/30 hover:scale-105 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Empezar Cotización
                </button>
                <button class="px-10 py-5 bg-white/10 backdrop-blur-xl border border-primary/20 text-primary font-black rounded-2xl hover:bg-primary hover:text-white transition-all shadow-sm uppercase tracking-widest text-xs">
                    Ver Planes
                </button>
            </div>
        </div>
        
        <!-- Integrated Lead Form -->
        <div id="quote-form-container" class="glass-card p-8 rounded-xl shadow-2xl border border-white/20">
            <h3 class="font-headline text-2xl font-bold text-primary mb-6">Obtén tu estimado rápido</h3>
            <form action="<?= $APP_URL ?>/api/v1/leads" method="POST" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-[0.75rem] font-medium text-on-surface-variant tracking-tight uppercase px-1">Nombre Completo</label>
                    <input name="full_name" required class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/20 focus:ring-2 focus:ring-primary rounded-xl py-3 px-4 transition-all" placeholder="Ej: Juan Pérez" type="text"/>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[0.75rem] font-medium text-on-surface-variant tracking-tight uppercase px-1">Correo Electrónico</label>
                        <input name="email" required class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/20 focus:ring-2 focus:ring-primary rounded-xl py-3 px-4 transition-all" placeholder="juan@empresa.com" type="email"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[0.75rem] font-medium text-on-surface-variant tracking-tight uppercase px-1">Teléfono</label>
                        <input name="phone" required class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/20 focus:ring-2 focus:ring-primary rounded-xl py-3 px-4 transition-all" placeholder="+1 (555) 000-0000" type="tel"/>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[0.75rem] font-medium text-on-surface-variant tracking-tight uppercase px-1">Tipo de Seguro</label>
                    <select name="service_type" class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/20 focus:ring-2 focus:ring-primary rounded-xl py-3 px-4 transition-all">
                        <option value="life">Seguro de Vida</option>
                        <option value="health">Gastos Médicos Mayores</option>
                        <option value="wealth">Protección Patrimonial</option>
                    </select>
                </div>
                <button type="submit" class="w-full mt-4 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-container transition-colors shadow-lg">
                    Solicitar Información
                </button>
                <p class="text-[10px] text-center text-on-surface-variant mt-4">
                    Al enviar, aceptas nuestros términos y el procesamiento seguro de datos HIPAA.
                </p>
            </form>
        </div>
    </div>
</section>

<!-- Bento Grid Features -->
<section id="nosotros" class="py-24 bg-surface-container-low">
    <div class="max-w-7xl mx-auto px-8">
        <div class="mb-16">
            <h2 class="font-headline text-4xl font-extrabold text-primary mb-4">¿Por qué elegir <?= $COMPANY_NAME ?>?</h2>
            <div class="h-1 w-20 bg-on-tertiary-container rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-surface-container-lowest p-10 rounded-xl flex flex-col justify-between group hover:shadow-xl transition-all border border-transparent hover:border-outline-variant/20">
                <div class="max-w-md">
                    <span class="material-symbols-outlined text-4xl text-on-tertiary-container mb-6 block" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    <h3 class="text-2xl font-bold text-primary mb-4">Seguridad Institucional</h3>
                    <p class="text-on-surface-variant leading-relaxed">Implementamos protocolos de seguridad avanzada, garantizando que su información financiera y personal permanezca blindada bajo los estándares HIPAA más estrictos.</p>
                </div>
                <div class="mt-8 flex items-center text-primary font-bold gap-2 group-hover:gap-4 transition-all cursor-pointer">
                    Saber más <span class="material-symbols-outlined">arrow_forward</span>
                </div>
            </div>
            <div class="bg-primary p-10 rounded-xl text-white flex flex-col justify-between">
                <div>
                    <span class="material-symbols-outlined text-4xl text-tertiary-fixed-dim mb-6 block">bolt</span>
                    <h3 class="text-2xl font-bold mb-4">Rapidez Extrema</h3>
                    <p class="text-white/80 leading-relaxed">Cotizaciones en tiempo real impulsadas por IA. Sin papeleo innecesario, solo resultados inmediatos.</p>
                </div>
                <div class="mt-8 text-white/60 text-sm font-medium tracking-wide">98% Eficiencia Operativa</div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>
