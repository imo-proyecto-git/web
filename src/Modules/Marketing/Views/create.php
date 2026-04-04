<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<!-- Top Navigation (Architectural Glass) -->
<nav class="fixed top-0 w-full z-50 glass-card h-20 flex justify-between items-center px-12">
    <div class="flex items-center gap-12">
        <span class="text-3xl font-black text-primary tracking-tighter font-headline lowercase"><?= $COMPANY_NAME ?></span>
        <nav class="hidden md:flex items-center gap-4 text-on-surface-variant/30 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="#" class="hover:text-primary transition-colors"><?= __('Campaigns') ?></a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-primary"><?= __('Nueva Campaña') ?></span>
        </nav>
    </div>
    <div class="flex items-center gap-6">
        <div class="relative hidden lg:block">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant/30 text-sm">search</span>
            <input class="bg-surface-container-low/50 border-none rounded-xl pl-12 pr-6 py-2 text-xs font-bold focus:ring-2 focus:ring-primary w-64 transition-all placeholder:text-on-surface-variant/20" placeholder="<?= __('Search campaigns...') ?>" type="text"/>
        </div>
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-primary cursor-pointer relative">notifications<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-white"></span></span>
            <span class="material-symbols-outlined text-primary cursor-pointer">settings</span>
        </div>
    </div>
</nav>

<div class="flex min-h-screen pt-20 bg-surface">
    <!-- Sidebar (Secondary Context - No Border) -->
    <aside class="h-screen w-80 bg-surface-low flex flex-col py-12 px-10 gap-12 sticky top-20">
        <div class="mb-4">
            <p class="text-lg font-black text-primary tracking-tighter"><?= $COMPANY_NAME ?></p>
            <p class="text-[9px] text-on-surface-variant/40 font-black uppercase tracking-widest"><?= __('MARKETING MODULE') ?></p>
        </div>
        
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-3 px-4 py-3.5 bg-primary/10 text-primary font-black text-xs rounded-xl shadow-sm transition-all" href="#">
                <span class="material-symbols-outlined text-lg">send</span> <?= __('Campaigns') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">insights</span> <?= __('Analytics') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">group</span> <?= __('Audience') ?>
            </a>
            <a class="flex items-center gap-3 px-4 py-3.5 text-on-surface-variant/60 font-bold text-xs hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined text-lg">dashboard_customize</span> <?= __('Templates') ?>
            </a>
        </nav>

        <div class="mt-auto space-y-4">
            <a href="#" class="flex items-center gap-3 px-3 py-2 text-on-surface-variant/60 hover:text-primary transition-all text-xs font-bold uppercase tracking-widest">
                <span class="material-symbols-outlined text-lg">contact_support</span> <?= __('Support') ?>
            </a>
            <div class="p-4 bg-indigo-50/50 rounded-2xl border border-primary/5 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white text-xs font-bold">IA</div>
                <div>
                    <p class="text-[11px] font-black tracking-tighter text-primary leading-none"><?= $COMPANY_NAME ?> Administrator</p>
                    <p class="text-[9px] text-on-surface-variant/40 font-bold uppercase tracking-widest mt-1"><?= __('Account Settings') ?></p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-16">
        <form id="campaign-form" action="<?= config('app.url') ?>/api/v1/marketing/campaigns" method="POST" enctype="multipart/form-data">
        <header class="mb-20">
            <h1 class="text-6xl font-black text-primary tracking-tighter mb-6 font-headline leading-[0.9] uppercase"><?= __('Mass') ?><br/><?= __('Communication') ?></h1>
            <p class="text-on-surface-variant/50 font-medium text-lg leading-relaxed max-w-2xl">
                <?= __('Configura los parámetros, carga tus recursos y programa el envío de tu próxima campaña de marketing masivo.') ?>
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Section: Basic Info & Assets -->
            <div class="lg:col-span-8 space-y-10">
                <!-- Información Básica Card (Tonal Layering) -->
                <div class="bg-surface-lowest rounded-[48px] p-12 shadow-2xl shadow-primary/5">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary"><span class="material-symbols-outlined text-2xl">edit_note</span></div>
                        <h3 class="text-2xl font-black text-primary tracking-tighter uppercase font-headline"><?= __('INFORMACIÓN BÁSICA') ?></h3>
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-on-surface-variant/30 uppercase tracking-[0.2em] px-1 font-body">Campaign Name</label>
                        <input name="campaign_name" required class="w-full bg-surface-low border-none rounded-2xl py-5 px-8 text-sm font-bold text-primary placeholder:text-primary/10 transition-all focus:ring-2 focus:ring-primary" placeholder="Ej: Lanzamiento Verano 2024"/>
                    </div>
                </div>

                <!-- Visual Mail Builder Card -->
                <div class="bg-white rounded-[40px] p-10 shadow-2xl shadow-primary/5 border border-outline-variant/10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-2xl">format_paint</span>
                            <h3 class="text-xl font-black text-primary tracking-tight uppercase"><?= __('VISUAL MAIL BUILDER') ?></h3>
                        </div>
                        <div class="flex gap-4">
                           <button type="button" onclick="setTemplate('welcome')" class="text-[9px] font-black uppercase tracking-widest px-4 py-2 bg-indigo-50 text-primary rounded-lg hover:bg-primary hover:text-white transition-all">Welcome</button>
                           <button type="button" onclick="setTemplate('promo')" class="text-[9px] font-black uppercase tracking-widest px-4 py-2 bg-indigo-50 text-primary rounded-lg hover:bg-primary hover:text-white transition-all">Promo</button>
                        </div>
                    </div>
                    
                    <!-- GrapesJS Container -->
                    <div id="gjs" class="border border-outline-variant/10 rounded-2xl overflow-hidden min-h-[600px] bg-surface-low/30"></div>
                    <input type="hidden" name="html_body" id="html_body">

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Campaign Subject -->
                        <div class="space-y-4">
                            <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Email Subject Line</p>
                            <input name="campaign_subject" required class="w-full bg-surface-low border-none rounded-xl py-4 px-6 text-sm font-bold text-primary placeholder:text-primary/10 transition-all focus:ring-2 focus:ring-primary" placeholder="Ej: Asegura el bienestar de tu familia hoy"/>
                        </div>
                        <!-- Recipient List Upload -->
                        <div class="space-y-4">
                            <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Lista de Destinatarios (CSV/JSON)</p>
                            <label class="border-2 border-dashed border-outline-variant/20 rounded-xl p-4 flex items-center justify-center gap-4 hover:border-primary transition-all cursor-pointer group relative">
                                <input type="file" name="recipient_list" accept=".csv,.json" class="absolute inset-0 opacity-0 cursor-pointer">
                                <span class="material-symbols-outlined text-primary">person_add</span>
                                <span class="text-xs font-black text-primary">Cargar lista</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section: Programación & Resumen -->
            <div class="lg:col-span-4 space-y-10">
                <!-- Programación Card -->
                <div class="bg-white rounded-[40px] p-10 shadow-2xl shadow-primary/5 border border-outline-variant/10">
                    <div class="flex items-center gap-3 mb-10">
                        <span class="material-symbols-outlined text-primary text-2xl">event</span>
                        <h3 class="text-xl font-black text-primary tracking-tight uppercase"><?= __('PROGRAMACIÓN') ?></h3>
                    </div>
                    <div class="flex items-center gap-4 mb-8 bg-indigo-50/30 p-4 rounded-xl border border-primary/5">
                        <input type="checkbox" name="is_scheduled" class="w-5 h-5 rounded border-primary/20 text-primary focus:ring-primary"/>
                        <p class="text-xs font-black text-primary"><?= __('Programar envío') ?></p>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">FECHA</label>
                            <div class="relative">
                                <input name="schedule_date" type="date" class="w-full bg-indigo-50/50 border-none rounded-xl py-3.5 px-4 text-xs font-bold text-primary shadow-sm"/>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">HORA</label>
                            <div class="relative">
                                <input name="schedule_time" type="time" class="w-full bg-indigo-50/50 border-none rounded-xl py-3.5 px-4 text-xs font-bold text-primary shadow-sm"/>
                            </div>
                        </div>
                    </div>
                    <p class="text-[9px] text-center text-on-surface-variant/40 font-bold uppercase tracking-widest mt-10 leading-relaxed italic px-4">
                        Selecciona el huso horario correspondiente a tu audiencia principal para optimizar la tasa de apertura.
                    </p>
                </div>

                <!-- Resumen de Campaña Card (Full Dark) -->
                <div class="bg-primary rounded-[40px] p-10 text-white relative overflow-hidden shadow-2xl shadow-primary/40">
                    <h3 class="text-3xl font-black mb-10 tracking-tight">Resumen de Campaña</h3>
                    <div class="space-y-6 mb-12">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-indigo-200/60 font-bold">Estado actual</span>
                            <span class="font-black uppercase tracking-widest">Borrador</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-indigo-200/60 font-bold">Créditos estimados</span>
                            <span class="font-black text-2xl tracking-tighter leading-none">0</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-5 bg-white/10 backdrop-blur-xl border border-white/20 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-white hover:text-primary transition-all flex items-center justify-center gap-3">
                        Generar y Vista Previa <span class="material-symbols-outlined text-base">east</span>
                    </button>
                    <p class="text-center mt-6">
                        <a href="#" class="text-[10px] font-black text-white/40 hover:text-white uppercase tracking-widest transition-all">Guardar como borrador</a>
                    </p>
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-500 rounded-full opacity-10 blur-[100px]"></div>
                </div>

                <!-- Pro-Tip Card (Tertiary System) -->
                <div class="bg-tertiary-container rounded-[32px] p-10 flex gap-8 items-start">
                    <div class="w-12 h-12 rounded-2xl bg-tertiary flex items-center justify-center text-white shrink-0 shadow-xl shadow-tertiary/20">
                        <span class="material-symbols-outlined text-2xl font-black">insights</span>
                    </div>
                    <div>
                        <p class="text-on-tertiary-container font-black text-[11px] uppercase tracking-[0.2em] mb-2"><?= __('Pro-Tip de Optimización') ?></p>
                        <p class="text-on-tertiary-container opacity-60 font-medium text-xs leading-relaxed italic">
                            Las campañas enviadas los Martes a las 10:00 AM tienen un 22% más de tasa de apertura promedio en el sector seguros.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </form>

    <!-- GrapesJS Scripts & Templates -->
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <script src="https://unpkg.com/grapesjs"></script>

    <script>
    const editor = grapesjs.init({
        container: '#gjs',
        fromElement: true,
        height: '600px',
        width: 'auto',
        storageManager: false,
        panels: { defaults: [] },
        blockManager: {
            appendTo: '#blocks',
            blocks: [
                {
                    id: 'section',
                    label: '<b>Section</b>',
                    attributes: { class: 'gjs-block-section' },
                    content: `<section style="padding: 20px; font-family: sans-serif;">
                        <h1 style="color: #00113a;">Headline Here</h1>
                        <p style="color: #667085;">Your text goes here...</p>
                    </section>`,
                },
                {
                    id: 'text',
                    label: 'Text',
                    content: '<div data-gjs-type="text">Insert your text here...</div>',
                },
                {
                    id: 'image',
                    label: 'Image',
                    select: true,
                    content: { type: 'image' },
                    activate: true,
                }
            ]
        },
    });

    const templates = {
        welcome: `
            <div style="padding: 40px; background-color: #f8fafc; font-family: sans-serif; text-align: center;">
                <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                    <h1 style="color: #00113a; font-size: 32px; font-weight: 800; margin-bottom: 20px;">¡Bienvenido a <?= $COMPANY_NAME ?>!</h1>
                    <p style="color: #64748b; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">Estamos encantados de tenerte con nosotros. Prepárate para una experiencia de seguros de nivel empresarial.</p>
                    <a href="<?= config('app.url') ?>/login" style="background: #00113a; color: white; padding: 16px 32px; border-radius: 12px; text-decoration: none; font-weight: 700;">Empezar ahora</a>
                </div>
            </div>
        `,
        promo: `
            <div style="padding: 40px; background-color: #fdf2f2; font-family: sans-serif; text-align: center;">
                <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 20px; padding: 40px; border: 2px solid #fee2e2;">
                    <span style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 99px; font-size: 12px; font-weight: 800; text-transform: uppercase;">Oferta Limitada</span>
                    <h1 style="color: #991b1b; font-size: 32px; font-weight: 800; margin: 20px 0;">20% de Descuento en Pólizas de Vida</h1>
                    <p style="color: #7f1d1d; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">Asegura tu futuro hoy mismo con nuestra tarifa especial de temporada.</p>
                    <a href="<?= config('app.url') ?>/leads" style="background: #ef4444; color: white; padding: 16px 32px; border-radius: 12px; text-decoration: none; font-weight: 700;">Reclamar Descuento</a>
                </div>
            </div>
        `
    };

    function setTemplate(type) {
        if (templates[type]) {
            editor.setComponents(templates[type]);
        }
    }

    // Default Template
    setTemplate('welcome');

    document.addEventListener('DOMContentLoaded', () => {
        const campaignForm = document.getElementById('campaign-form');
        if (!campaignForm) return;

        campaignForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Sync GrapesJS content to hidden input
            document.getElementById('html_body').value = editor.getHtml() + '<style>' + editor.getCss() + '</style>';

            const btn = campaignForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="flex items-center justify-center gap-3"><span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> PROCESANDO...</span>';

            const formData = new FormData(campaignForm);
            try {
                const response = await fetch(campaignForm.action, {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    campaignForm.innerHTML = `
                        <div class="py-24 text-center animate-in fade-in zoom-in duration-700 bg-white rounded-[48px] shadow-2xl">
                            <div class="w-32 h-32 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-12 text-emerald-500">
                                <span class="material-symbols-outlined text-6xl font-black">send_and_archive</span>
                            </div>
                            <h3 class="font-headline text-5xl font-black text-primary mb-8 tracking-tighter uppercase italic">${result.message}</h3>
                            <p class="text-on-surface-variant/40 font-bold uppercase tracking-[0.2em] text-xs mb-8">CAMPAIGN ID: ${result.campaign_id}</p>
                            <a href="${result.status_url}" class="text-primary font-black uppercase text-[10px] tracking-widest bg-primary/5 px-8 py-4 rounded-full hover:bg-primary/10 transition-all inline-block">Ver Progreso del Envío</a>
                        </div>
                    `;
                } else {
                    alert(result.message || 'Fallo en la creación de la campaña.');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            } catch (err) {
                console.error(err);
                alert('Connection error.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    });
    </script>
</div>

<footer class="w-full bg-white border-t border-outline-variant/10 px-12 py-8 mt-12 flex flex-col md:flex-row justify-between items-center gap-8">
    <div class="flex gap-10">
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Términos de Envío</a>
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Privacidad</a>
        <a href="#" class="text-[10px] font-black text-on-surface-variant/40 hover:text-primary uppercase tracking-widest transition-all">Cumplimiento GDPR</a>
    </div>
    <div class="flex items-center gap-3">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        <p class="text-[10px] font-black text-on-surface-variant/30 uppercase tracking-widest">Servidores operacionales: Conexión segura (TLS 1.3)</p>
    </div>
</footer>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
