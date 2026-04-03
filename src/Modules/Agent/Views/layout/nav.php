<header class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-md shadow-xl shadow-primary/5 h-16 flex justify-between items-center px-8 border-b border-surface-container">
    <div class="flex items-center gap-8">
        <span class="text-xl font-black text-primary tracking-tight font-headline"><?= $COMPANY_NAME ?></span>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-primary border-b-2 border-primary font-bold pb-1 text-sm tracking-tight transition-all duration-300" href="<?= $APP_URL ?>/agent/dashboard"><?= __('Dashboard') ?></a>
            <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#"><?= __('Pólizas') ?></a>
            <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#"><?= __('Leads') ?></a>
            <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#"><?= __('Performance') ?></a>
        </nav>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative hidden sm:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
            <input class="bg-surface-container-low border-none rounded-xl pl-10 pr-4 py-1.5 text-sm focus:ring-2 focus:ring-primary w-64 transition-all" placeholder="<?= __('Buscar cuentas...') ?>" type="text"/>
        </div>
        <button class="p-2 hover:bg-primary/5 rounded-full transition-colors relative">
            <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border border-white"></span>
        </button>
        <button class="p-2 hover:bg-primary/5 rounded-full transition-colors">
            <span class="material-symbols-outlined text-on-surface-variant">settings</span>
        </button>
        <div class="flex items-center gap-3 ml-2 border-l border-outline-variant/30 pl-4">
            <div class="text-right hidden md:block">
                <p class="text-xs font-bold text-primary"><?= $user['name'] ?></p>
                <p class="text-[10px] text-on-surface-variant uppercase font-bold"><?= $user['role'] ?></p>
            </div>
            <a href="<?= $APP_URL ?>/logout" class="h-8 w-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary hover:bg-error hover:text-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-sm">logout</span>
            </a>
        </div>
    </div>
</header>
