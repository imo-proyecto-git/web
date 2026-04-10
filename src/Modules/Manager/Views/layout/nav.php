<nav class="fixed top-0 w-full z-50 glass-card flex justify-between items-center px-12 h-20">
    <div class="flex items-center gap-12">
        <span class="text-3xl font-black text-primary tracking-tighter font-headline lowercase"><?= $COMPANY_NAME ?></span>
        <div class="hidden md:flex gap-10 items-center">
            <a class="text-on-surface-variant font-bold hover:text-primary transition-colors text-xs uppercase tracking-widest <?= strpos($_SERVER['REQUEST_URI'], '/manager/dashboard') !== false ? 'text-primary' : '' ?>" href="<?= config('app.url') ?>/manager/dashboard"><?= __('Dashboard') ?></a>
            <a class="text-on-surface-variant font-bold hover:text-primary transition-colors text-xs uppercase tracking-widest <?= strpos($_SERVER['REQUEST_URI'], '/manager/users') !== false ? 'text-primary' : '' ?>" href="<?= config('app.url') ?>/manager/users"><?= __('Usuarios') ?></a>
            <a class="text-on-surface-variant font-bold hover:text-primary transition-colors text-xs uppercase tracking-widest <?= strpos($_SERVER['REQUEST_URI'], '/manager/roles') !== false ? 'text-primary' : '' ?>" href="<?= config('app.url') ?>/manager/roles"><?= __('Roles') ?></a>
            <!-- Audit link removed from here to reduce redundancy as per Audit report -->
        </div>
    </div>
    <div class="flex items-center gap-6">
        <span class="material-symbols-outlined text-primary cursor-pointer relative">notifications<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-white"></span></span>
        <div class="flex items-center gap-3">
             <div class="text-right hidden sm:block">
                 <p class="text-[10px] font-black text-primary leading-none uppercase italic"><?= $user['role_name'] ?? 'Manager' ?></p>
                 <p class="text-[9px] text-on-surface-variant/40 font-bold uppercase tracking-widest mt-1"><?= $user['email'] ?></p>
             </div>
             <span class="material-symbols-outlined text-primary cursor-pointer text-3xl">account_circle</span>
        </div>
    </div>
</nav>
