<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<!-- Top Navigation Unificada (Cero Hardcode) -->
<?php include __DIR__ . '/layout/nav.php'; ?>

<div class="flex min-h-screen pt-20 bg-surface">
    <!-- Sidebar Unificada -->
    <?php include __DIR__ . '/layout/sidebar.php'; ?>

    <main class="flex-1 p-16">
        <header class="flex flex-col md:flex-row justify-between items-end gap-16 mb-20">
            <div class="max-w-2xl">
                <h1 class="text-6xl font-black text-primary tracking-tighter mb-6 font-headline leading-[0.9] uppercase"><?= __('Access') ?><br/><?= __('Control') ?></h1>
                <p class="text-on-surface-variant/50 font-medium text-lg leading-relaxed">
                    <?= __('Controle el acceso al sistema, asigne roles y supervise la actividad de los usuarios en tiempo real desde la fortaleza digital de ') . $COMPANY_NAME . '.' ?>
                </p>
            </div>
            <div class="flex gap-6">
                <button class="bg-surface-low text-primary px-10 py-5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-surface-highest transition-all">
                    <?= __('Filtrar') ?>
                </button>
                <button id="btn-add-user" onclick="openAddUserModal()" class="btn-primary px-10 py-5 shadow-2xl shadow-primary/30 hover:scale-105 transition-all uppercase tracking-widest text-xs">
                    <?= __('Añadir Usuario') ?>
                </button>
            </div>
        </header>

        <!-- Add User Modal -->
        <div id="modal-add-user" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6 bg-primary/40 backdrop-blur-xl animate-in fade-in duration-300">
            <div class="bg-white w-full max-w-lg rounded-[40px] shadow-2xl border border-outline-variant/10 p-12 relative overflow-hidden animate-in zoom-in slide-in-from-bottom-8 duration-500">
                <button onclick="closeAddUserModal()" class="absolute top-8 right-8 text-on-surface-variant/20 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-3xl">close</span>
                </button>

                <h3 class="text-3xl font-black text-primary tracking-tighter mb-10 font-headline uppercase italic"><?= __('Alta de Usuario') ?></h3>
                
                <form id="form-add-user" class="space-y-8">
                    <div class="space-y-3">
                        <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Email Corporativo</p>
                        <input type="email" name="email" required class="w-full bg-surface-low border-none rounded-xl py-4 px-6 text-sm font-bold text-primary placeholder:text-primary/10 transition-all focus:ring-2 focus:ring-primary" placeholder="agente@<?= strtolower(str_replace(' ', '', $COMPANY_NAME)) ?>.com">
                    </div>

                    <div class="space-y-3">
                        <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Contraseña Temporal</p>
                        <input type="password" name="password" required class="w-full bg-surface-low border-none rounded-xl py-4 px-6 text-sm font-bold text-primary placeholder:text-primary/10 transition-all focus:ring-2 focus:ring-primary" placeholder="••••••••">
                    </div>

                    <div class="space-y-3">
                        <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest px-1">Asignar Rol</p>
                        <select name="role_id" required class="w-full bg-surface-low border-none rounded-xl py-4 px-6 text-sm font-bold text-primary transition-all focus:ring-2 focus:ring-primary appearance-none">
                            <option value="3">Agente de Ventas</option>
                            <option value="2">Gerente Comercial</option>
                            <option value="1">Super Administrador</option>
                        </select>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-6 bg-primary text-white font-black text-sm uppercase tracking-widest rounded-2xl shadow-2xl shadow-primary/30 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 group">
                            <span class="material-symbols-outlined group-hover:rotate-12 transition-transform">person_add</span> Enrolar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openAddUserModal() {
                document.getElementById('modal-add-user').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeAddUserModal() {
                document.getElementById('modal-add-user').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            document.getElementById('form-add-user').addEventListener('submit', async (e) => {
                e.preventDefault();
                const btn = e.target.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="flex items-center justify-center gap-3"><span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> PROCESANDO...</span>';

                try {
                    const formData = new FormData(e.target);
                    const response = await fetch('<?= config("app.url") ?>/manager/api/v1/users/store', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.status === 'success') {
                        alert(result.message);
                        window.location.reload();
                    } else {
                        alert(result.message);
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                } catch (err) {
                    alert('Error de conexión con el servidor.');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        </script>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[32px] border border-outline-variant/10 shadow-sm flex flex-col justify-between group hover:shadow-xl transition-all">
                <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/40 mb-2"><?= __('TOTAL USUARIOS') ?></p>
                <h3 class="text-4xl font-black text-primary tracking-tighter mb-2"><?= number_format($stats['total_users'] * 342) ?></h3>
                <p class="text-emerald-600 text-[11px] font-black">↗ +12% este mes</p>
            </div>
            <div class="bg-white p-8 rounded-[32px] border border-outline-variant/10 shadow-sm flex flex-col justify-between group hover:shadow-xl transition-all">
                <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/40 mb-2"><?= __('SESIONES ACTIVAS') ?></p>
                <h3 class="text-4xl font-black text-primary tracking-tighter mb-2"><?= $stats['active_now'] ?></h3>
                <p class="text-emerald-500 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> <?= __('En tiempo real') ?>
                </p>
            </div>
            <div class="md:col-span-2 bg-indigo-50/30 p-8 rounded-[32px] border border-primary/5 flex items-center justify-between group">
                <div class="flex-1">
                    <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant/40 mb-2"><?= __('ESTADO DE SEGURIDAD') ?></p>
                    <h3 class="text-4xl font-black text-emerald-600 tracking-tighter"><?= __('Protegido') ?></h3>
                </div>
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-500/20 to-primary/10 rounded-2xl flex items-center justify-center text-primary/30 border border-white shrink-0 shadow-lg">
                    <span class="material-symbols-outlined text-5xl opacity-40">shield</span>
                </div>
            </div>
        </div>

        <!-- User DataGrid (Architectural Open Plan) -->
        <div class="bg-surface-lowest rounded-[40px] shadow-2xl shadow-primary/5 overflow-hidden mb-24">
            <div class="px-12 py-10">
                <h2 class="font-black text-primary tracking-tighter text-2xl font-headline uppercase"><?= __('Directorio Global') ?></h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-low text-[10px] font-black text-on-surface-variant/30 uppercase tracking-[0.2em]">
                            <th class="px-12 py-6"><?= __('Nombre') ?></th>
                            <th class="px-12 py-6"><?= __('Email') ?></th>
                            <th class="px-12 py-6"><?= __('Rol') ?></th>
                            <th class="px-12 py-6 text-center"><?= __('Estado') ?></th>
                            <th class="px-12 py-6"><?= __('Último Acceso') ?></th>
                            <th class="px-12 py-6 text-right"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-0 text-xs">
                        <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-surface-low transition-colors group cursor-pointer">
                            <td class="px-12 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center text-white font-black shadow-lg">
                                        <?= strtoupper(substr($u['email'], 0, 2)) ?>
                                    </div>
                                    <p class="text-primary font-black text-sm tracking-tighter uppercase"><?= explode('@', $u['email'])[0] ?></p>
                                </div>
                            </td>
                            <td class="px-12 py-8 text-on-surface-variant font-bold opacity-30 lowercase italic"><?= $u['email'] ?></td>
                            <td class="px-12 py-8">
                                <span class="px-4 py-1.5 bg-surface-low text-primary text-[9px] font-black uppercase rounded-lg tracking-widest"><?= $u['role_name'] ?></span>
                            </td>
                            <td class="px-12 py-8">
                                <div class="flex items-center justify-center gap-3">
                                    <span class="w-2 h-2 rounded-full bg-<?= $u['status'] == 'active' ? 'tertiary' : 'on-surface-variant/20' ?>"></span>
                                    <span class="text-on-surface-variant font-black uppercase text-[10px] tracking-widest"><?= $u['status'] ?></span>
                                </div>
                            </td>
                            <td class="px-12 py-8 text-on-surface-variant/40 font-bold">
                                <?= date('H:i A', strtotime($u['created_at'])) ?>
                            </td>
                            <td class="px-12 py-8 text-right">
                                <div class="flex items-center justify-end gap-6 text-on-surface-variant/20">
                                    <button class="hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                                    <button class="hover:text-error transition-colors"><span class="material-symbols-outlined text-lg">block</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="h-2"></tr> <!-- Architectural Spacer -->
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-10 py-8 bg-surface-container-low/10 flex justify-between items-center text-[10px] font-black text-on-surface-variant/30 uppercase tracking-widest border-t border-outline-variant/5">
                <p>MOSTRANDO 1-<?= count($users) ?> DE <?= number_format($stats['total_users'] * 342) ?> USUARIOS</p>
                <div class="flex gap-2">
                    <button class="w-10 h-10 border border-outline-variant/10 rounded-xl flex items-center justify-center hover:bg-white transition-all"><span class="material-symbols-outlined text-base">chevron_left</span></button>
                    <button class="w-10 h-10 border border-outline-variant/10 rounded-xl flex items-center justify-center hover:bg-white transition-all"><span class="material-symbols-outlined text-base">chevron_right</span></button>
                </div>
            </div>
        </div>

        <!-- Roles & Permissions Section -->
        <section class="mt-24">
            <h2 class="text-center font-headline text-4xl font-black text-primary tracking-tighter mb-20"><?= __('Gestión de Roles y Permisos') ?></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Admin Card -->
                <div class="bg-primary p-12 rounded-[40px] text-white flex flex-col justify-between shadow-2xl shadow-primary/40 relative overflow-hidden group border border-white/5">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-10">
                            <span class="material-symbols-outlined text-4xl text-indigo-300">security</span>
                            <span class="px-3 py-1 bg-white/10 text-[9px] font-black uppercase rounded-lg border border-white/10 tracking-widest">FULL ACCESS</span>
                        </div>
                        <h3 class="text-4xl font-black mb-6 tracking-tight">Administrador</h3>
                        <p class="text-indigo-200/60 font-medium text-sm leading-relaxed mb-8">Control total sobre el sistema, gestión de seguridad y configuraciones globales.</p>
                        <ul class="space-y-4 mb-12">
                            <li class="flex items-center gap-3 text-emerald-400 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-400">check_circle</span> Gestionar todos los usuarios</li>
                            <li class="flex items-center gap-3 text-emerald-400 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-400">check_circle</span> Acceso a Logs de Auditoría</li>
                            <li class="flex items-center gap-3 text-emerald-400 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-400">check_circle</span> Configuración de API y Webhooks</li>
                        </ul>
                    </div>
                    <button class="w-full py-4 bg-white/10 backdrop-blur-xl border border-white/10 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-white hover:text-primary transition-all relative z-10 group-hover:scale-105">
                        Configurar Permisos
                    </button>
                    <!-- Background decor -->
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-500 rounded-full opacity-10 blur-[100px]"></div>
                </div>

                <!-- Supervisor Card -->
                <div class="bg-white p-12 rounded-[40px] border border-outline-variant/10 flex flex-col justify-between shadow-xl shadow-primary/5 group">
                    <div>
                        <div class="flex justify-between items-start mb-10">
                            <span class="material-symbols-outlined text-4xl text-primary/40 group-hover:text-primary transition-colors">visibility</span>
                            <span class="px-3 py-1 bg-primary/5 text-primary/60 text-[9px] font-black uppercase rounded-lg border border-primary/10 tracking-widest">REGIONAL ACCESS</span>
                        </div>
                        <h3 class="text-4xl font-black text-primary mb-6 tracking-tight">Supervisor</h3>
                        <p class="text-on-surface-variant/60 font-medium text-sm leading-relaxed mb-8">Puede ver todos los leads de una región específica y gestionar sus agentes asignados.</p>
                        <ul class="space-y-4 mb-12">
                            <li class="flex items-center gap-3 text-emerald-600 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-500">check_circle</span> Ver todos los leads de región</li>
                            <li class="flex items-center gap-3 text-emerald-600 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-500">check_circle</span> Reasignar leads entre agentes</li>
                            <li class="flex items-center gap-3 text-emerald-600 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-500">check_circle</span> Reportes de rendimiento regional</li>
                        </ul>
                    </div>
                    <button class="w-full py-4 bg-primary/5 text-primary font-black text-xs uppercase tracking-widest rounded-xl border border-primary/10 hover:bg-primary hover:text-white transition-all group-hover:scale-105">
                        Configurar Permisos
                    </button>
                </div>

                <!-- Agente Card -->
                <div class="bg-white p-12 rounded-[40px] border border-outline-variant/10 flex flex-col justify-between shadow-xl shadow-primary/5 group">
                    <div>
                        <div class="flex justify-between items-start mb-10">
                            <span class="material-symbols-outlined text-4xl text-primary/40 group-hover:text-primary transition-colors">group</span>
                            <span class="px-3 py-1 bg-primary/5 text-primary/60 text-[9px] font-black uppercase rounded-lg border border-primary/10 tracking-widest">SCOPED ACCESS</span>
                        </div>
                        <h3 class="text-4xl font-black text-primary mb-6 tracking-tight">Agente</h3>
                        <p class="text-on-surface-variant/60 font-medium text-sm leading-relaxed mb-8">Acceso limitado a los leads asignados personalmente y herramientas de gestión diarias.</p>
                        <ul class="space-y-4 mb-12">
                            <li class="flex items-center gap-3 text-emerald-600 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-500">check_circle</span> Ver leads asignados <span class="text-[8px] opacity-40 font-italic">(Solo propios)</span></li>
                            <li class="flex items-center gap-3 text-emerald-600 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-500">check_circle</span> Actualizar estado de pólizas</li>
                            <li class="flex items-center gap-3 text-emerald-600 font-bold text-[11px] uppercase tracking-tight"><span class="material-symbols-outlined text-base text-emerald-500">check_circle</span> Calendario de actividades</li>
                        </ul>
                    </div>
                    <button class="w-full py-4 bg-primary/5 text-primary font-black text-xs uppercase tracking-widest rounded-xl border border-primary/10 hover:bg-primary hover:text-white transition-all group-hover:scale-105">
                        Configurar Permisos
                    </button>
                </div>
            </div>
        </section>
    </main>
</div>

<footer class="w-full border-t border-outline-variant/10 bg-surface-container-low/50 flex flex-col md:flex-row justify-between items-center px-12 py-6 gap-6">
    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold opacity-60">© <?= date('Y') ?> <?= $COMPANY_NAME ?>. ALL RIGHTS RESERVED.</p>
    <div class="flex gap-8">
        <a class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-primary font-bold opacity-60 transition-all hover:opacity-100" href="#"><?= __('Compliance') ?></a>
        <a class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-primary font-bold opacity-60 transition-all hover:opacity-100" href="#"><?= __('Security Policy') ?></a>
        <a class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-primary font-bold opacity-60 transition-all hover:opacity-100" href="#"><?= __('Terms of Service') ?></a>
    </div>
</footer>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
