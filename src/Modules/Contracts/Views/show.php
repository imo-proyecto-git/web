<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<main class="min-h-screen bg-surface-container-low py-20 px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header del Contrato -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 bg-white p-8 rounded-2xl shadow-sm border border-outline-variant/10">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-primary-container text-white px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest"><?= __('Documento Legal') ?></span>
                    <span class="text-xs text-on-surface-variant font-mono"><?= $contract['uuid'] ?></span>
                </div>
                <h1 class="text-3xl font-black text-primary font-headline tracking-tighter"><?= $contract['title'] ?></h1>
                <p class="text-on-surface-variant text-sm mt-1"><?= __('Emitido el:') ?> <?= date('d M, Y', strtotime($contract['created_at'])) ?></p>
            </div>
            
            <div class="flex items-center gap-3">
                <?php if ($isSigned): ?>
                    <div class="bg-on-tertiary-container/10 text-on-tertiary-container px-4 py-2 rounded-xl flex items-center gap-2 font-bold text-sm">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                        <?= __('FIRMADO DIGITALMENTE') ?>
                    </div>
                <?php else: ?>
                    <div class="bg-error-container text-error px-4 py-2 rounded-xl flex items-center gap-2 font-bold text-sm">
                        <span class="material-symbols-outlined text-sm">pending_actions</span>
                        <?= __('PENDIENTE DE FIRMA') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cuerpo del Contrato -->
        <div class="bg-white p-12 rounded-2xl shadow-sm border border-outline-variant/10 mb-8 min-h-[600px] font-body leading-relaxed text-on-surface/80 text-sm">
            <div class="prose max-w-none">
                <?= nl2br($contract['content']) ?>
            </div>
            
            <?php if ($isSigned): ?>
                <div class="mt-20 pt-8 border-t-2 border-dashed border-outline-variant/20 flex flex-col items-center text-center">
                    <div class="text-primary opacity-20 mb-4">
                        <span class="material-symbols-outlined text-8xl">signature</span>
                    </div>
                    <p class="text-xs font-black uppercase text-on-surface-variant tracking-widest"><?= __('Firma Electrónica Verificada') ?></p>
                    <p class="text-[10px] font-mono text-primary/40 mt-2">HASH: <?= $contract['signature_hash'] ?></p>
                    <p class="text-[10px] text-on-surface-variant mt-1">IP: <?= $contract['ip_address'] ?> | <?= $contract['signed_at'] ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Acciones -->
        <?php if (!$isSigned): ?>
        <div class="bg-primary p-8 rounded-2xl shadow-2xl flex flex-col md:flex-row items-center justify-between gap-8 text-white">
            <div class="flex-1">
                <h3 class="text-xl font-bold mb-2"><?= __('Consentimiento de Firma Digital') ?></h3>
                <p class="text-blue-200 text-xs leading-tight">
                    Al hacer clic en "Confirmar Firma", usted acepta los términos y condiciones del contrato de forma vinculante bajo los estándares de firma electrónica avanzada.
                </p>
            </div>
            <button id="btn-sign" class="bg-gold-color text-primary px-10 py-4 rounded-xl font-black text-sm uppercase tracking-widest hover:scale-105 transition-all shadow-lg active:scale-95 whitespace-nowrap">
                <?= __('Confirmar Firma') ?>
            </button>
        </div>
        <?php endif; ?>

        <div class="mt-8 text-center">
            <p class="text-[10px] text-on-surface-variant font-medium uppercase tracking-widest">Powered by <span class="text-primary font-black"><?= $COMPANY_NAME ?> SecureShield</span></p>
        </div>
    </div>
</main>

<script>
document.getElementById('btn-sign')?.addEventListener('click', async function() {
    if(!confirm('¿Está seguro que desea firmar este documento legalmente?')) return;
    
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Procesando...';

    try {
        const response = await fetch('<?= $APP_URL ?>/contracts/<?= $contract['uuid'] ?>/sign', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            alert('¡Contrato firmado con éxito!');
            location.reload();
        } else {
            alert('Error: ' + result.message);
            btn.disabled = false;
            btn.innerText = '<?= __('Confirmar Firma') ?>';
        }
    } catch (e) {
        alert('Error de conexión.');
        btn.disabled = false;
        btn.innerText = '<?= __('Confirmar Firma') ?>';
    }
});
</script>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
