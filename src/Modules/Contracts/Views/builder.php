<?php 
// Usaremos el panel nav del agente o del manager dependiendo del rol
if ($user['role'] === 'manager' || $user['role'] === 'superadmin') {
    include __DIR__ . '/../../Landing/Views/layout/header.php';
} else {
    include __DIR__ . '/../../Agent/Views/layout/nav.php';
}
?>

<div class="flex-1 bg-surface min-h-screen <?= ($user['role'] === 'agent') ? 'pt-24' : 'pt-32' ?> px-10 pb-10">
    <div class="max-w-7xl mx-auto">
        
        <header class="mb-10 flex justify-between items-end gap-6">
            <div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-4xl text-indigo-500">draw</span>
                    <h1 class="text-4xl font-black text-primary tracking-tighter uppercase font-headline">Contract Builder</h1>
                </div>
                <p class="text-on-surface-variant/60 font-bold text-sm mt-2 ml-[3.25rem]">Generador dinámico de Contratos con Firma OTP (Cumplimiento HIPAA)</p>
            </div>
            <div class="flex gap-4">
                <button class="bg-white border border-outline-variant/10 text-primary px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-sm hover:bg-surface-low transition-all">Vista Previa</button>
                <button class="btn-primary px-8 py-3 rounded-xl shadow-2xl shadow-primary/30 hover:scale-105 transition-all uppercase tracking-widest text-[10px] font-black"><span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">send</span> Emitir a Lead</span></button>
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
                <div class="bg-white rounded-[40px] shadow-2xl shadow-primary/10 border border-outline-variant/5 min-h-[800px] flex flex-col overflow-hidden relative">
                    
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
                    <div class="flex-1 p-16" id="canvas-area">
                        <!-- Default Template Loaded -->
                        <div class="border border-dashed border-outline-variant/20 rounded-2xl p-10 hover:border-indigo-500/50 transition-colors group cursor-text relative mb-6">
                            <button class="absolute top-4 right-4 text-on-surface-variant/20 group-hover:text-error transition-colors"><span class="material-symbols-outlined text-sm">delete</span></button>
                            <h2 class="text-2xl font-black text-primary font-headline uppercase tracking-tighter mb-4 outline-none" contenteditable="true">ACUERDO DE BLINDAJE PATRIMONIAL</h2>
                            <p class="text-sm font-medium text-on-surface-variant/70 leading-relaxed outline-none" contenteditable="true">
                                Este acuerdo se celebra en el día [FECHA] entre <?= $COMPANY_NAME ?? 'IMO-OS' ?> y el cliente amparado. Los fondos aportados se gestionarán bajo la estructura B.T.I.D.
                            </p>
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

<?php 
if ($user['role'] === 'manager' || $user['role'] === 'superadmin') {
    include __DIR__ . '/../../Landing/Views/layout/footer.php';
}
?>
