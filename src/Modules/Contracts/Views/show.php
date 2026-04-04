<?php include __DIR__ . '/../../Landing/Views/layout/header.php'; ?>

<main class="min-h-screen bg-surface-low pt-24 pb-16 px-12 flex flex-col items-center">
    <!-- Header Context -->
    <div class="max-w-4xl w-full text-center mb-16">
        <div class="inline-flex items-center gap-3 px-4 py-2 bg-primary/5 rounded-full mb-8">
            <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
            <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]"><?= __('DOCUMENTO SEGURO • HIPAA COMPLIANT') ?></span>
        </div>
        <h1 class="font-headline text-5xl font-black text-primary tracking-tighter mb-4 uppercase italic"><?= $contract['title'] ?></h1>
        <p class="text-on-surface-variant/40 font-bold text-xs uppercase tracking-widest"><?= __('REVISIÓN DE CONSENTIMIENTO Y FIRMA DIGITAL') ?></p>
    </div>

    <!-- Contract Container (Paper Aesthetic) -->
    <div class="max-w-4xl w-full bg-white rounded-[40px] shadow-[0_80px_120px_-20px_rgba(0,17,58,0.08)] border border-outline-variant/10 relative overflow-hidden flex flex-col">
        <!-- Document Toolbar -->
        <div class="bg-surface-lowest border-b border-outline-variant/5 px-10 py-6 flex justify-between items-center sticky top-0 z-10">
            <div class="flex items-center gap-6">
                <span class="material-symbols-outlined text-primary/30">description</span>
                <p class="text-[11px] font-black text-primary uppercase tracking-widest"><?= $contract['uuid'] ?></p>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
                    <span class="material-symbols-outlined text-lg">download</span>
                </button>
                <button class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
                    <span class="material-symbols-outlined text-lg">print</span>
                </button>
            </div>
        </div>

        <!-- Document Content (Editorial Type) -->
        <div class="p-16 md:p-24 prose prose-indigo max-w-none prose-headings:font-headline prose-headings:font-black prose-headings:text-primary prose-p:text-on-surface-variant/80 prose-p:leading-relaxed">
            <?= $contract['content'] ?>
            
            <?php if ($isSigned): ?>
            <!-- Verification Seal -->
            <div class="mt-20 p-10 bg-emerald-50 rounded-[32px] border-2 border-emerald-500/20 text-center relative overflow-hidden">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-white shadow-xl shadow-emerald-500/20">
                        <span class="material-symbols-outlined text-3xl font-black">verified</span>
                    </div>
                    <h3 class="text-2xl font-black text-emerald-900 tracking-tight mb-2"><?= __('Documento Firmado Digitalmente') ?></h3>
                    <p class="text-emerald-700/60 font-bold text-[10px] uppercase tracking-widest mb-6 italic"><?= __('Identidad Verificada vía IP & Timestamp') ?></p>
                    <div class="font-mono text-[9px] text-emerald-900/40 break-all bg-white/50 p-4 rounded-xl border border-emerald-500/10"><?= $contract['signature_hash'] ?></div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!$isSigned): ?>
        <!-- Signature Action Area -->
        <div id="signature-area" class="p-16 md:p-20 bg-surface-low/50 border-t border-outline-variant/5">
            <div class="max-w-xl mx-auto space-y-10 text-center">
                
                <!-- OTP Verification Step -->
                <div id="otp-section" class="mb-10">
                    <button id="otp-request-btn" onclick="requestOtp()" class="btn-secondary py-4 px-10 text-[10px] uppercase tracking-widest shadow-xl shadow-primary/5 border-2 border-primary/10 hover:border-primary transition-all">
                        <span class="material-symbols-outlined text-base">mail</span> Solicitar Código de Verificación OTP
                    </button>

                    <div id="otp-step" class="hidden mt-6 flex flex-col items-center gap-4 animate-in fade-in slide-in-from-top duration-500">
                        <p class="text-[10px] font-black text-on-surface-variant/40 uppercase tracking-widest">Ingresa el código enviado </p>
                        <div class="flex gap-4">
                            <input type="text" id="otp-input" maxlength="6" class="w-48 bg-white border-2 border-primary/20 rounded-xl py-4 text-center text-2xl font-black tracking-[0.5em] focus:border-primary transition-all outline-none" placeholder="000000">
                            <button onclick="verifyOtp()" class="bg-primary text-white p-4 rounded-xl hover:scale-105 active:scale-95 transition-all">
                                <span class="material-symbols-outlined">key</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Consent Area (Locked until OTP) -->
                <div id="consent-area" class="opacity-20 pointer-events-none transition-all duration-700 space-y-10">
                    <div class="space-y-6 text-left">
                        <label class="flex items-start gap-4 cursor-pointer group">
                            <input type="checkbox" id="consent-1" class="w-6 h-6 rounded-lg border-primary/20 text-primary focus:ring-primary mt-1">
                            <span class="text-xs font-bold text-on-surface-variant/60 leading-relaxed group-hover:text-primary transition-colors">
                                He leído y acepto los términos de esta póliza y los métodos de compensación detallados anteriormente.
                            </span>
                        </label>
                        <label class="flex items-start gap-4 cursor-pointer group">
                            <input type="checkbox" id="consent-2" class="w-6 h-6 rounded-lg border-primary/20 text-primary focus:ring-primary mt-1">
                            <span class="text-xs font-bold text-on-surface-variant/60 leading-relaxed group-hover:text-primary transition-colors">
                                Autorizo a <?= $COMPANY_NAME ?> procesar este documento bajo los estándares HIPAA y firma digital electrónica (Click-to-Sign).
                            </span>
                        </label>
                    </div>

                    <div class="pt-6">
                        <button id="sign-button" disabled onclick="handleSignature()" class="w-full py-6 bg-primary text-white font-black text-sm uppercase tracking-widest rounded-2xl shadow-2xl shadow-primary/30 opacity-50 cursor-not-allowed hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined">edit_document</span> <?= __('FIRMAR DOCUMENTO DIGITALMENTE') ?>
                        </button>
                        <p class="text-center mt-6 text-[9px] font-black text-on-surface-variant/30 uppercase tracking-widest italic">
                            Esta acción es legalmente vinculante bajo la Ley ESIGN de EE.UU. y leyes locales.
                        </p>
                    </div>
                </div>

            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Security Badges -->
    <div class="mt-16 flex flex-wrap justify-center gap-10 opacity-30 grayscale hover:grayscale-0 hover:opacity-60 transition-all">
        <div class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest"><span class="material-symbols-outlined">shield</span> HIPAA CERTIFIED</div>
        <div class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest"><span class="material-symbols-outlined">lock</span> TLS 1.3 SECURE</div>
        <div class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest"><span class="material-symbols-outlined">history</span> AUDIT LEDGER</div>
    </div>
</main>

<script>
    async function requestOtp() {
        const email = prompt("Confirma tu email para recibir el código:");
        if (!email) return;

        try {
            const response = await fetch('<?= config("app.url") ?>/contracts/<?= $contract["uuid"] ?>/otp/request', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });
            const result = await response.json();
            if (result.status === 'success') {
                document.getElementById('otp-step').classList.remove('hidden');
                document.getElementById('otp-request-btn').classList.add('hidden');
                alert(result.message);
            } else {
                alert(result.message);
            }
        } catch (err) {
            alert('Error al solicitar OTP');
        }
    }

    async function verifyOtp() {
        const otp = document.getElementById('otp-input').value;
        if (otp.length !== 6) return alert('Ingresa los 6 dígitos');

        try {
            const response = await fetch('<?= config("app.url") ?>/contracts/<?= $contract["uuid"] ?>/otp/verify', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ otp })
            });
            const result = await response.json();
            if (result.status === 'success') {
                document.getElementById('otp-step').innerHTML = `<div class="text-emerald-500 font-black text-xs uppercase tracking-widest flex items-center gap-2"><span class="material-symbols-outlined">verified_user</span> IDENTIDAD VERIFICADA</div>`;
                document.getElementById('consent-area').classList.remove('opacity-20', 'pointer-events-none');
                alert(result.message);
            } else {
                alert(result.message);
            }
        } catch (err) {
            alert('Error al verificar OTP');
        }
    }

    async function handleSignature() {
        const btn = document.getElementById('sign-button');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center gap-3"><span class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> GENERANDO FIRMA HASH...</span>';

        try {
            const response = await fetch('<?= config("app.url") ?>/contracts/<?= $contract["uuid"] ?>/sign', {
                method: 'POST'
            });
            const result = await response.json();

            if (result.status === 'success') {
                document.getElementById('signature-area').innerHTML = `
                    <div class="py-12 text-center animate-in fade-in zoom-in duration-500">
                        <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-8 text-white shadow-2xl shadow-emerald-500/40">
                            <span class="material-symbols-outlined text-5xl font-black">check</span>
                        </div>
                        <h3 class="font-headline text-3xl font-black text-primary mb-4 tracking-tighter uppercase italic">${result.message}</h3>
                        <p class="text-on-surface-variant/40 font-bold uppercase tracking-[0.2em] text-[10px] mb-10">DOCUMENTO VERIFICADO Y ARCHIVADO SUCESSFULLY</p>
                        <button onclick="window.location.reload()" class="btn-primary py-4 px-10 text-[10px] uppercase tracking-widest shadow-xl shadow-primary/20">Finalizar y Cerrar</button>
                    </div>
                `;
            } else {
                alert(result.message);
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } catch (err) {
            console.error(err);
            alert('Falló el servidor de firma.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    const btn = document.getElementById('sign-button');
    const c1 = document.getElementById('consent-1');
    const c2 = document.getElementById('consent-2');

    const updateBtn = () => {
        if (c1 && c2 && c1.checked && c2.checked) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else if(btn) {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    };

    if(c1 && c2) {
        c1.addEventListener('change', updateBtn);
        c2.addEventListener('change', updateBtn);
    }
</script>

<?php include __DIR__ . '/../../Landing/Views/layout/footer.php'; ?>
