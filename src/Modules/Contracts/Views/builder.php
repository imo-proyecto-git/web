<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>
<?php 
// Usaremos el panel nav del agente o del manager dependiendo del rol
if ($user['role'] === 'manager' || $user['role'] === 'superadmin') {
    // Ya incluye el nav en el dashboard, pero si es necesario lo podemos forzar aquí si no viene de layout
} else {
    include __DIR__ . '/../../Agent/Views/layout/nav.php';
}
?>

<div class="flex-1 bg-surface min-h-screen <?= ($user['role'] === 'agent') ? 'pt-24' : 'pt-32' ?> px-10 pb-10">
    <div class="max-w-7xl mx-auto">
        
        <header class="mb-12 flex flex-col md:flex-row justify-between items-end gap-10">
            <div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-500/20">
                        <span class="material-symbols-outlined text-2xl">draw</span>
                    </div>
                    <div>
                        <h1 class="text-5xl font-black text-primary tracking-tighter uppercase font-headline italic leading-none">Constructor</h1>
                        <p class="text-on-surface-variant/40 font-black text-[10px] tracking-[0.4em] uppercase mt-2">Ingeniería Legal & Compliance HIPAA</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                <div class="flex-1 md:flex-none">
                    <p class="text-[9px] font-black uppercase text-on-surface-variant/40 mb-2 ml-1">Seleccionar Lead</p>
                    <select id="lead-selector" class="w-full md:w-64 bg-white border border-outline-variant/10 rounded-xl py-3 px-4 text-xs font-bold text-primary shadow-sm appearance-none cursor-pointer focus:ring-2 focus:ring-primary h-[46px]">
                        <?php foreach($leads as $l): ?>
                            <?php $selected = ($preselected_lead_id == $l['id']) ? 'selected' : ''; ?>
                            <option value="<?= $l['id'] ?>" <?= $selected ?>><?= $l['name'] ?> (ID: #<?= substr($l['uuid'], 0, 8) ?>)</option>
                        <?php endforeach; ?>
                        <?php if(empty($leads)): ?>
                            <option value="">No hay leads disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>
                <button id="emit-contract-btn" class="btn-primary px-8 py-3 rounded-xl shadow-2xl shadow-primary/30 hover:scale-105 transition-all uppercase tracking-widest text-[10px] font-black h-[46px] mt-auto"><span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">send</span> Emitir a Lead</span></button>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Herramientas (Left Sidebar) -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Bloques Disponibles -->
                <div class="bg-surface-lowest rounded-3xl p-6 border border-outline-variant/5 shadow-2xl shadow-primary/5">
                    <h3 class="font-black text-primary uppercase tracking-widest text-[10px] mb-6">Bloques Estructurales</h3>
                    <div class="space-y-3" id="draggables">
                        <div class="p-3 bg-white border border-outline-variant/10 rounded-xl flex items-center gap-3 cursor-grab hover:border-primary/30 transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-on-surface-variant/40">title</span>
                            <span class="text-xs font-bold text-primary">Cabecera Legal</span>
                        </div>
                        <div class="p-3 bg-white border border-outline-variant/10 rounded-xl flex items-center gap-3 cursor-grab hover:border-primary/30 transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-on-surface-variant/40">notes</span>
                            <span class="text-xs font-bold text-primary">Cláusulas Standard</span>
                        </div>
                        <div class="p-3 bg-white border border-outline-variant/10 rounded-xl flex items-center gap-3 cursor-grab hover:border-primary/30 transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-on-surface-variant/40">checklist</span>
                            <span class="text-xs font-bold text-primary">Variables de Póliza</span>
                        </div>
                        <div class="p-3 bg-white border border-indigo-500/20 rounded-xl flex items-center gap-3 cursor-grab hover:bg-indigo-50 transition-colors shadow-sm relative overflow-hidden group">
                            <div class="absolute inset-0 bg-indigo-500/10 scale-x-0 group-hover:scale-x-100 origin-left transition-transform"></div>
                            <span class="material-symbols-outlined text-indigo-500 relative z-10">verified</span>
                            <span class="text-xs font-bold text-indigo-700 relative z-10">Bloque Firma O.T.P.</span>
                        </div>
                    </div>
                </div>

                <!-- Plantillas -->
                <div class="bg-surface-lowest rounded-3xl p-6 border border-outline-variant/5 shadow-xl shadow-primary/5">
                    <h3 class="font-black text-primary uppercase tracking-widest text-[10px] mb-6">Plantillas Predefinidas</h3>
                    <select class="w-full bg-white border-none ring-1 ring-primary/5 rounded-xl py-3 px-4 text-xs font-bold text-primary shadow-sm appearance-none cursor-pointer">
                        <option>Blindaje Patrimonial (BTID)</option>
                        <option>Plan de Retiro (IUL)</option>
                        <option>Renovación de Salud (B2B)</option>
                    </select>
                </div>
            </div>

            <!-- Workspace / Documento (Right Area) -->
            <div class="lg:col-span-9">
                <div class="bg-white rounded-[48px] shadow-[0_40px_100px_-20px_rgba(0,17,58,0.15)] border border-outline-variant/10 min-h-[900px] flex flex-col overflow-hidden relative">
                    <!-- Blueprint Grid Overlay (Subtle) -->
                    <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(#00113a 0.5px, transparent 0.5px); background-size: 20px 20px;"></div>
                    
                    <!-- Toolbar Editor -->
                    <div class="bg-surface-low border-b border-outline-variant/10 px-8 py-4 flex items-center gap-6">
                        <div class="flex items-center gap-2 text-on-surface-variant/40">
                            <button class="w-8 h-8 rounded hover:bg-surface-highest transition-colors flex items-center justify-center"><span class="material-symbols-outlined text-sm">format_bold</span></button>
                            <button class="w-8 h-8 rounded hover:bg-surface-highest transition-colors flex items-center justify-center"><span class="material-symbols-outlined text-sm">format_italic</span></button>
                            <button class="w-8 h-8 rounded hover:bg-surface-highest transition-colors flex items-center justify-center"><span class="material-symbols-outlined text-sm">format_list_bulleted</span></button>
                        </div>
                        <div class="w-px h-6 bg-outline-variant/10"></div>
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-emerald-500 flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Auto-Guardado</span>
                        </div>
                    </div>

                    <!-- Lienzo (Canvas) -->
                    <div class="flex-1 p-20 relative z-10" id="canvas-area">
                        <!-- Default Template Loaded -->
                        <div id="contract-wrapper" class="bg-white border border-outline-variant/10 rounded-[32px] p-16 shadow-2xl shadow-primary/5 hover:border-indigo-500/30 transition-all group cursor-text relative mb-10 overflow-hidden">
                            <div class="absolute top-0 left-0 w-1 h-full bg-indigo-500/10 group-hover:bg-indigo-500 transition-colors"></div>
                            <button class="absolute top-6 right-6 text-on-surface-variant/10 group-hover:text-error transition-colors"><span class="material-symbols-outlined text-sm">delete</span></button>
                            <h2 id="editable-title" class="text-4xl font-black text-primary font-headline uppercase tracking-tighter mb-8 outline-none leading-none" contenteditable="true">ACUERDO DE BLINDAJE PATRIMONIAL</h2>
                            <div class="w-20 h-1 bg-primary/10 mb-12"></div>
                            <div id="editable-content" class="text-[15px] font-medium text-on-surface-variant/70 leading-[1.8] outline-none min-h-[400px]" contenteditable="true">
                                <p class="mb-8">Este acuerdo se celebra en el día <span class="bg-indigo-50 px-2 py-0.5 rounded text-indigo-600 font-bold">[FECHA]</span> entre <span class="text-primary font-black"><?= $COMPANY_NAME ?? 'IMO-OS' ?></span> y el cliente amparado. Los fondos aportados se gestionarán bajo la estructura <span class="border-b-2 border-indigo-500/30 text-primary">B.T.I.D.</span></p>
                                <h3 class="font-black text-primary uppercase tracking-[0.2em] text-[11px] mb-6 flex items-center gap-2">
                                    <span class="w-6 h-px bg-primary/20"></span> 1. OBJETO DEL CONTRATO
                                </h3>
                                <p class="mb-10">El presente documento tiene como fin establecer los t&eacute;rminos de protecci&oacute;n patrimonial y gesti&oacute;n de activos en modalidad de seguros a t&eacute;rmino con inversi&oacute;n de excedentes.</p>
                                <h3 class="font-black text-primary uppercase tracking-[0.2em] text-[11px] mb-6 flex items-center gap-2">
                                    <span class="w-6 h-px bg-primary/20"></span> 2. COMPROMISO HIPAA
                                </h3>
                                <p class="mb-12">Todas las partes aceptan el manejo de Informaci&oacute;n de Salud Protegida (PHI) bajo los est&aacute;ndares federales vigentes.</p>
                                
                                <div class="mt-32 p-12 border-2 border-dashed border-indigo-500/20 rounded-[40px] bg-indigo-50/20 text-center relative group/sig">
                                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-white px-6 py-1 border border-indigo-100 rounded-full shadow-sm">
                                        <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest leading-none">Protocolo de Seguridad O.T.P.</p>
                                    </div>
                                    <div class="h-16 w-64 bg-white rounded-2xl mx-auto border border-indigo-500/10 shadow-inner flex items-center justify-center">
                                        <span class="text-[10px] font-black text-primary/20 uppercase tracking-[0.4em]">Sello Digital</span>
                                    </div>
                                    <p class="text-[9px] text-on-surface-variant/30 font-bold mt-6 uppercase tracking-widest italic">Validación biométrica requerida mediante dispositivo móvil del suscriptor.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Drop Zone -->
                        <div class="h-32 border-2 border-dashed border-indigo-500/30 rounded-2xl flex flex-col items-center justify-center bg-indigo-500/5 text-indigo-500">
                            <span class="material-symbols-outlined mb-2">add_circle</span>
                            <span class="text-[10px] font-black uppercase tracking-widest">Arrastra bloques aquí</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
/**
 * Lógica del Constructor de Contratos (Emission AJAX)
 */
document.addEventListener('DOMContentLoaded', () => {
    const emitBtn = document.getElementById('emit-contract-btn');
    const leadSelector = document.getElementById('lead-selector');
    const titleEl = document.getElementById('editable-title');
    const contentEl = document.getElementById('editable-content');

    if (!emitBtn) return;

    emitBtn.addEventListener('click', async () => {
        const leadId = leadSelector.value;
        const title = titleEl.innerText;
        const content = contentEl.innerHTML;

        if (!leadId) {
            alert('Por favor, selecciona un Lead para emitir el contrato.');
            return;
        }

        const originalHTML = emitBtn.innerHTML;
        emitBtn.disabled = true;
        emitBtn.innerHTML = '<span class="flex items-center gap-2"><span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> Emitiendo...</span>';

        try {
            const response = await fetch('<?= config("app.url") ?>/api/v1/contracts', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    lead_id: leadId,
                    title: title,
                    content: content
                })
            });

            const result = await response.json();

            if (result.status === 'success') {
                // Notificación de éxito
                const workspace = document.getElementById('canvas-area');
                workspace.innerHTML = `
                    <div class="py-20 text-center animate-in fade-in zoom-in duration-500">
                        <div class="w-24 h-24 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-10 text-emerald-500 shadow-2xl shadow-emerald-500/20">
                            <span class="material-symbols-outlined text-5xl font-black">verified</span>
                        </div>
                        <h3 class="font-headline text-4xl font-black text-primary mb-6 tracking-tighter uppercase leading-none italic">Contrato Emitido</h3>
                        <p class="text-on-surface-variant/40 font-bold uppercase tracking-[0.2em] text-[10px] mb-8">UUID: ${result.uuid}</p>
                        <div class="p-6 bg-surface-low rounded-2xl max-w-md mx-auto mb-10 border border-outline-variant/10">
                            <p class="text-xs font-bold text-primary mb-2 uppercase tracking-widest">Enlace de Firma (Sello HIPAA):</p>
                            <input readonly value="${result.link}" class="w-full bg-white border-none text-[10px] text-primary p-3 rounded font-black tracking-widest select-all text-center"/>
                        </div>
                        <div class="h-1.5 w-24 bg-emerald-500 rounded-full mx-auto"></div>
                        <button onclick="window.location.reload()" class="mt-12 text-primary font-black text-[10px] uppercase tracking-[0.3em] hover:opacity-60 transition-all">Crear otro documento</button>
                    </div>
                `;
            } else {
                alert(result.message || 'Error al emitir contrato.');
                emitBtn.disabled = false;
                emitBtn.innerHTML = originalHTML;
            }
        } catch (e) {
            console.error(e);
            alert('Error crítico de red. Verifica la consola.');
            emitBtn.disabled = false;
            emitBtn.innerHTML = originalHTML;
        }
    });

    // Auto-Save simulation UI
    let timeout = null;
    const observer = new MutationObserver(() => {
        clearTimeout(timeout);
        const autoSaveTxt = document.querySelector('.text-emerald-500');
        if (autoSaveTxt) autoSaveTxt.innerText = ' Guardando cambios...';
        timeout = setTimeout(() => {
            if (autoSaveTxt) autoSaveTxt.innerText = ' Auto-Guardado';
        }, 1000);
    });
    
    observer.observe(titleEl, { childList: true, characterData: true, subtree: true });
    observer.observe(contentEl, { childList: true, characterData: true, subtree: true });
});
</script>

<?php 
if ($user['role'] === 'manager' || $user['role'] === 'superadmin') {
    include __DIR__ . '/../../Landing/Views/layout/footer.php';
}
?>
