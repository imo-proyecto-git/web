<footer class="bg-surface-container-low border-t border-outline-variant/30">
    <div class="max-w-7xl mx-auto py-12 px-8 flex flex-col md:flex-row justify-between items-start gap-12">
        <div class="space-y-6 max-w-sm">
            <div class="font-bold text-primary text-2xl font-headline"><?= $COMPANY_NAME ?></div>
            <p class="text-on-surface-variant text-sm leading-relaxed">
                <?= config('app.company.slogan') ?>. 
                Líderes en tecnología insurtech para el mercado hispano. 
                Proporcionamos infraestructura resiliente para el manejo de riesgos financieros globales.
            </p>
            <div class="flex gap-4">
                <div class="px-2 py-1 bg-white border border-outline-variant/30 rounded text-[10px] font-bold text-on-surface-variant/50">HIPAA COMPLIANT</div>
                <div class="px-2 py-1 bg-white border border-outline-variant/30 rounded text-[10px] font-bold text-on-surface-variant/50">GDPR READY</div>
                <div class="px-2 py-1 bg-white border border-outline-variant/30 rounded text-[10px] font-bold text-on-surface-variant/50">SSL SECURE</div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-12 gap-y-8">
            <div class="space-y-4">
                <p class="font-bold text-primary text-sm uppercase tracking-wider">Enlaces</p>
                <ul class="space-y-2">
                    <li><a class="text-on-surface-variant hover:text-primary transition-all text-sm" href="#">Privacy Policy</a></li>
                    <li><a class="text-on-surface-variant hover:text-primary transition-all text-sm" href="#">Terms of Service</a></li>
                    <li><a class="text-on-surface-variant hover:text-primary transition-all text-sm" href="#">Compliance</a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <p class="font-bold text-primary text-sm uppercase tracking-wider">Soporte</p>
                <ul class="space-y-2">
                    <li><a class="text-on-surface-variant hover:text-primary transition-all text-sm" href="#">Contact Support</a></li>
                    <li><a class="text-on-surface-variant hover:text-primary transition-all text-sm" href="#">Ayuda 24/7</a></li>
                    <li><a class="text-on-surface-variant hover:text-primary transition-all text-sm" href="#">FAQ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-8 py-6 border-t border-outline-variant/10 flex flex-col md:flex-row justify-between items-center text-on-surface-variant/60 text-[11px] font-medium">
        <p>© <?= date('Y') ?> <?= $COMPANY_NAME ?>. All rights reserved. HIPAA Compliant. SSL Secured.</p>
        <p>Operado por <?= $COMPANY_NAME ?> Group. <?= config('app.company.address') ?>.</p>
    </div>
</footer>
</body></html>
