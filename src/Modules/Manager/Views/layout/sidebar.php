<aside class="h-screen w-80 bg-surface-low flex flex-col py-12 px-10 gap-12 sticky top-20">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-primary/90 rounded-xl flex items-center justify-center text-white"><span class="material-symbols-outlined">shield</span></div>
        <div>
            <p class="text-[11px] font-black tracking-tighter text-primary"><?= __('Admin Panel') ?></p>
            <p class="text-[9px] text-on-surface-variant/40 font-bold uppercase tracking-widest"><?= __('System Oversight') ?></p>
        </div>
    </div>
    
    <a href="<?= config('app.url') ?>/manager/marketing/campaigns/create" class="w-full bg-primary text-white py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
        <span class="material-symbols-outlined text-sm">add_circle</span> <?= __('New Campaign') ?>
    </a>

    <nav class="flex flex-col gap-2 pt-4">
        <p class="text-[9px] font-black text-on-surface-variant/20 uppercase tracking-[0.2em] mb-2 ml-4">Monitor & Compliance</p>
        <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant/60 font-medium text-xs rounded-xl hover:bg-white hover:text-primary transition-all <?= strpos($_SERVER['REQUEST_URI'], '/manager/audit') !== false ? 'bg-white shadow-sm text-primary font-black' : '' ?>" href="<?= config('app.url') ?>/manager/audit">
            <span class="material-symbols-outlined text-sm">history_edu</span> <?= __('Audit Trail') ?>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant/60 font-medium text-xs rounded-xl hover:bg-white hover:text-primary transition-all" href="<?= config('app.url') ?>/manager/audit/export">
            <span class="material-symbols-outlined text-sm">cloud_download</span> <?= __('Export Data CSV') ?>
        </a>
        
        <p class="text-[9px] font-black text-on-surface-variant/20 uppercase tracking-[0.2em] mb-2 ml-4 mt-6">Growth Engine</p>
        <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant/60 font-medium text-xs rounded-xl hover:bg-white hover:text-primary transition-all <?= strpos($_SERVER['REQUEST_URI'], '/marketing/analytics') !== false ? 'bg-white shadow-sm text-primary font-black' : '' ?>" href="<?= config('app.url') ?>/manager/marketing/campaigns/analytics">
            <span class="material-symbols-outlined text-sm">insights</span> <?= __('Analytics') ?>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant/60 font-medium text-xs rounded-xl hover:bg-white hover:text-primary transition-all <?= strpos($_SERVER['REQUEST_URI'], '/marketing/campaigns/create') !== false ? 'bg-white shadow-sm text-primary font-black' : '' ?>" href="<?= config('app.url') ?>/manager/marketing/campaigns/create">
            <span class="material-symbols-outlined text-sm">campaign</span> <?= __('Launch Campaign') ?>
        </a>
    </nav>

    <a href="<?= config('app.url') ?>/logout" class="mt-auto flex items-center gap-3 px-4 py-3 text-on-surface-variant/40 hover:text-error transition-all text-[11px] font-black uppercase tracking-widest border-t border-outline-variant/5">
        <span class="material-symbols-outlined text-lg">logout</span> <?= __('Sign Out') ?>
    </a>
</aside>
