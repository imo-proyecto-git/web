<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte_Lead_<?= $lead['uuid'] ?></title>
    <style>
        @media print { .no-print { display: none; } }
        body { font-family: sans-serif; color: #333; padding: 40px; line-height: 1.5; }
        .header { border-bottom: 2px solid #00113a; padding-bottom: 20px; margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end; }
        .logo { font-size: 24px; font-weight: 800; color: #00113a; }
        .title { font-size: 18px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; color: #666; }
        .grid { display: grid; grid-template-cols: 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .section-title { font-size: 14px; font-weight: bold; border-left: 4px solid #00113a; padding-left: 10px; margin-bottom: 15px; text-transform: uppercase; color: #00113a; }
        .data-row { margin-bottom: 10px; font-size: 13px; }
        .label { font-weight: bold; color: #888; display: block; font-size: 10px; text-transform: uppercase; }
        .value { border-bottom: 1px solid #eee; display: block; padding-bottom: 3px; }
        .score-box { background: #f4f7ff; padding: 20px; border-radius: 10px; text-align: center; border: 1px solid #dbe1ff; }
        .score-value { font-size: 32px; font-weight: 900; color: #00113a; }
        .footer { margin-top: 60px; font-size: 10px; color: #999; text-align: center; border-top: 1px solid #eee; pt: 20px; }
        .phi-badge { font-size: 8px; background: #00113a; color: #fff; padding: 2px 5px; border-radius: 3px; font-weight: bold; margin-left: 10px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <div>
            <div class="logo"><?= $COMPANY_NAME ?></div>
            <div class="title">Reporte de Calificación de Prospecto</div>
        </div>
        <div style="text-align: right; font-size: 10px; color: #666;">
            Ref: <?= $lead['uuid'] ?><br>
            Fecha: <?= date('d/m/Y H:i') ?>
        </div>
    </div>

    <div class="grid">
        <div>
            <div class="section-title">Información del Solicitante <span class="phi-badge">PHI-SECURE</span></div>
            <div class="data-row">
                <span class="label">Nombre Completo</span>
                <span class="value"><?= $phi['name'] ?></span>
            </div>
            <div class="data-row">
                <span class="label">Email de Contacto</span>
                <span class="value"><?= $phi['email'] ?></span>
            </div>
            <div class="data-row">
                <span class="label">Teléfono Registrado</span>
                <span class="value"><?= $phi['phone'] ?></span>
            </div>
        </div>
        <div>
            <div class="section-title">Detalles de la Gestión</div>
            <div class="data-row">
                <span class="label">Producto Solicitado</span>
                <span class="value"><?= strtoupper($lead['insurance_type']) ?></span>
            </div>
            <div class="data-row">
                <span class="label">Estado del Pipeline</span>
                <span class="value"><?= strtoupper($lead['status']) ?></span>
            </div>
            <div class="score-box">
                <span class="label">Lead Score (IA Analytics)</span>
                <div class="score-value"><?= $lead['score'] ?>%</div>
            </div>
        </div>
    </div>

    <div class="section-title">Análisis de Comisiones (Proyección)</div>
    <div class="grid" style="grid-template-cols: 1fr 1fr 1fr; gap: 20px;">
        <div class="data-row">
            <span class="label">Tasa Base</span>
            <span class="value"><?= $commissions['base_rate'] ?></span>
        </div>
        <div class="data-row">
            <span class="label">Bonos IA</span>
            <span class="value"><?= $commissions['lead_bonus'] ?></span>
        </div>
        <div class="data-row">
            <span class="label">Estimado Total</span>
            <span class="value"><?= $commissions['total_amount'] ?> <?= $commissions['currency'] ?></span>
        </div>
    </div>

    <div class="footer">
        Documento generado bajo norma HIPAA por <?= $COMPANY_NAME ?> SecureShield.<br>
        Esta información es confidencial y para uso exclusivo del personal autorizado.
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px; background: #00113a; color: #fff; padding: 10px 20px; border-radius: 30px; cursor: pointer; box-shadow: 0 10px 30px rgba(0,0,0,0.3); font-weight: bold;" onclick="window.close()">
        Cerrar Ventana
    </div>
</body>
</html>
