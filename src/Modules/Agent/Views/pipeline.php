<?php include __DIR__ . '/layout/nav.php'; ?>

<style>
/* CSS para Kanban Drag & Drop Visual Effect */
.kanban-col { min-height: 500px; }
.kanban-card { transition: transform 0.2s, box-shadow 0.2s; cursor: grab; }
.kanban-card:active { cursor: grabbing; transform: scale(0.98); }
.kanban-ghost { opacity: 0.4; border: 2px dashed #1a56db; background: transparent; }
</style>

<div class="flex-1 bg-surface min-h-screen pt-24 px-10 pb-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-black text-primary tracking-tighter mb-2 font-headline uppercase"><?= __('Lead Pipeline') ?></h1>
            <p class="text-on-surface-variant/60 font-bold text-sm tracking-widest uppercase"><?= __('Tablero Kanban Operativo') ?></p>
        </div>
        <div class="flex items-center gap-4">
            <button class="bg-white border border-outline-variant/10 text-primary px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest shadow-sm hover:bg-surface-low transition-all">Vista Lista</button>
            <button class="btn-primary px-6 py-2 shadow-lg shadow-primary/20 hover:scale-105 transition-all text-xs uppercase tracking-widest"><span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">add</span> Nuevo Lead</span></button>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 overflow-x-auto pb-8">
        
        <!-- NEW -->
        <div class="bg-surface-lowest rounded-3xl p-5 border border-outline-variant/5 shadow-2xl shadow-primary/5 kanban-col flex flex-col gap-4">
            <div class="flex justify-between items-center px-2 mb-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                    <h3 class="font-black text-primary uppercase tracking-widest text-[11px]"><?= __('Recientes') ?></h3>
                </div>
                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[9px] font-bold"><?= count($leads['new']) ?></span>
            </div>
            
            <?php foreach($leads['new'] as $lead): ?>
            <div class="kanban-card bg-white p-4 rounded-2xl shadow-sm border border-outline-variant/10 hover:shadow-xl hover:border-primary/20 group">
                <div class="flex justify-between items-start mb-3">
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[8px] font-black uppercase tracking-widest">ID: #<?= substr($lead['uuid'], 0, 6) ?></span>
                    <span class="text-[10px] font-black <?= $lead['score'] > 75 ? 'text-emerald-500' : 'text-amber-500' ?>"><?= $lead['score'] ?> SCORE</span>
                </div>
                <h4 class="font-black text-primary text-sm truncate mb-1"><?= $lead['name'] ?></h4>
                <p class="text-xs text-on-surface-variant opacity-60 font-medium truncate mb-4"><?= $lead['email'] ?></p>
                
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <div class="flex -space-x-2">
                        <img class="w-6 h-6 rounded-full border border-white" src="<?= avatar_url($lead['name']) ?>"/>
                    </div>
                    <a href="<?= config('app.url') . '/agent/leads/' . $lead['uuid'] ?>" class="text-[9px] font-black text-primary uppercase hover:text-blue-600 tracking-widest">Atender →</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CONTACTED -->
        <div class="bg-surface-lowest rounded-3xl p-5 border border-outline-variant/5 shadow-2xl shadow-primary/5 kanban-col flex flex-col gap-4">
            <div class="flex justify-between items-center px-2 mb-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></span>
                    <h3 class="font-black text-primary uppercase tracking-widest text-[11px]"><?= __('En Contacto') ?></h3>
                </div>
                <span class="px-2 py-1 bg-amber-50 text-amber-600 rounded text-[9px] font-bold"><?= count($leads['contacted']) ?></span>
            </div>
            
            <?php foreach($leads['contacted'] as $lead): ?>
            <div class="kanban-card bg-white p-4 rounded-2xl shadow-sm border border-outline-variant/10 hover:shadow-xl hover:border-primary/20 group">
                <h4 class="font-black text-primary text-sm truncate mb-1"><?= $lead['name'] ?></h4>
                <p class="text-xs text-on-surface-variant opacity-60 font-medium truncate mb-4"><?= $lead['email'] ?></p>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <a href="<?= config('app.url') . '/agent/leads/' . $lead['uuid'] ?>" class="text-[9px] font-black text-primary uppercase hover:text-blue-600 tracking-widest">Seguimiento →</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- QUALIFIED / CONTRACT SENT -->
        <div class="bg-surface-lowest rounded-3xl p-5 border border-outline-variant/5 shadow-2xl shadow-primary/5 kanban-col flex flex-col gap-4">
            <div class="flex justify-between items-center px-2 mb-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.8)]"></span>
                    <h3 class="font-black text-primary uppercase tracking-widest text-[11px]"><?= __('En Evaluación') ?></h3>
                </div>
                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded text-[9px] font-bold"><?= count($leads['qualified']) ?></span>
            </div>
            
            <?php foreach($leads['qualified'] as $lead): ?>
            <div class="kanban-card bg-white p-4 rounded-2xl shadow-sm border border-indigo-500/30 hover:shadow-xl group">
                <h4 class="font-black text-primary text-sm truncate mb-1"><?= $lead['name'] ?></h4>
                <p class="text-xs text-on-surface-variant opacity-60 font-medium truncate mb-4"><?= $lead['email'] ?></p>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <a href="<?= config('app.url') . '/contracts/' . $lead['uuid'] ?>" class="text-[9px] font-black text-indigo-600 uppercase tracking-widest flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">draw</span> Ver Contrato</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CLOSED / CONVERTED -->
        <div class="bg-surface-lowest rounded-3xl p-5 border border-outline-variant/5 shadow-2xl shadow-primary/5 kanban-col flex flex-col gap-4">
            <div class="flex justify-between items-center px-2 mb-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                    <h3 class="font-black text-primary uppercase tracking-widest text-[11px]"><?= __('Cerrados') ?></h3>
                </div>
                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-[9px] font-bold"><?= count($leads['converted']) ?></span>
            </div>
            
            <?php foreach($leads['converted'] as $lead): ?>
            <div class="kanban-card bg-emerald-50/50 p-4 rounded-2xl shadow-sm border border-emerald-500/20 group">
                <h4 class="font-black text-emerald-900 text-sm truncate mb-1"><?= $lead['name'] ?></h4>
                <p class="text-xs text-emerald-700/60 font-medium truncate mb-4 text-[10px] uppercase tracking-widest"><span class="material-symbols-outlined text-[10px] align-middle mr-1">task_alt</span> Póliza Activa</p>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cols = document.querySelectorAll('.kanban-col');
    cols.forEach(col => {
        new Sortable(col, {
            group: 'shared', // set both lists to same group
            animation: 150,
            ghostClass: 'kanban-ghost'
        });
    });
});
</script>
