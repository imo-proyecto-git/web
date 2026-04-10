<header class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm h-16 flex justify-between items-center px-10 border-b border-outline-variant/5">
    <div class="flex items-center gap-10">
        <span class="text-2xl font-black text-primary tracking-tighter font-headline"><?= $COMPANY_NAME ?></span>
        <nav class="hidden md:flex items-center gap-8">
            <a class="text-on-surface-variant/70 hover:text-primary transition-colors text-sm font-bold <?= strpos($_SERVER['REQUEST_URI'], '/agent/dashboard') !== false ? 'text-primary border-b-2 border-primary pb-1' : '' ?>" href="<?= $APP_URL ?>/agent/dashboard"><?= __('Dashboard') ?></a>
            <a class="text-on-surface-variant/70 hover:text-primary transition-colors text-sm font-bold <?= strpos($_SERVER['REQUEST_URI'], '/agent/pipeline') !== false ? 'text-primary border-b-2 border-primary pb-1' : '' ?>" href="<?= $APP_URL ?>/agent/pipeline"><?= __('Pipeline Kanban') ?></a>
            <a class="text-on-surface-variant/70 hover:text-primary transition-colors text-sm font-bold <?= strpos($_SERVER['REQUEST_URI'], '/agent/incomes') !== false ? 'text-primary border-b-2 border-primary pb-1' : '' ?>" href="<?= $APP_URL ?>/agent/incomes"><?= __('Mis Ingresos') ?></a>
            <!-- Removed dead links (Policies, Performance) as per UX Audit Phase 1 -->
        </nav>
    </div>
    <div class="flex items-center gap-6">
        <div class="relative hidden lg:block">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant/50 text-sm">search</span>
            <input class="bg-surface-container-low/50 border-none rounded-xl pl-12 pr-6 py-2.5 text-xs font-bold focus:ring-2 focus:ring-primary w-80 transition-all placeholder:text-on-surface-variant/30" placeholder="<?= __('Search leads...') ?>" type="text"/>
        </div>
        <div class="flex items-center gap-3">
            <button class="p-2.5 hover:bg-primary/5 rounded-full transition-colors relative group">
                <span class="material-symbols-outlined text-primary text-xl">notifications</span>
                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-error rounded-full border-2 border-white shadow-sm"></span>
            </button>
            <a href="<?= config('app.url') ?>/settings/security" class="p-2.5 hover:bg-primary/5 rounded-full transition-colors inline-block" title="Security Settings">
                <span class="material-symbols-outlined text-primary text-xl font-bold align-middle">settings</span>
            </a>
            <div class="h-10 w-10 rounded-xl overflow-hidden shadow-lg shadow-primary/10 border-2 border-white mx-2 cursor-pointer hover:scale-105 transition-all">
                <img src="<?= avatar_url($user['name'] ?? 'U') ?>" alt="<?= $user['name'] ?? 'User' ?>" class="w-full h-full object-cover"/>
            </div>
            <!-- Logout Button -->
            <a href="<?= config('app.url') ?>/logout" class="p-2.5 hover:bg-error/10 text-error/80 hover:text-error rounded-full transition-colors flex items-center justify-center" title="Cerrar sesión">
                <span class="material-symbols-outlined text-xl">logout</span>
            </a>
        </div>
    </div>
</header>
