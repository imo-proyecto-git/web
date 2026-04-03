<?php

namespace IMO\Modules\Agent\Services;

use Exception;

/**
 * CommissionService - Calculadora Estructural de Comisiones
 * empresaIMO - Arquitectura Zero-Hardcode
 */
class CommissionService
{
    /**
     * Calcula la comisión estimada para un prospecto basado en reglas de negocio.
     * 
     * @param string $serviceType Tipo de servicio (life, health, wealth)
     * @param float $premiumAmount Monto de la prima vendida/estimada
     * @param int $leadScore Puntaje IA asignado al lead
     * @return array Detalle del cálculo
     */
    public static function calculate(string $serviceType, float $premiumAmount, int $leadScore = 0): array
    {
        // 1. Obtener tasa base según tipo de servicio
        $baseRates = config('commissions.rates_by_service', []);
        $rate = $baseRates[$serviceType] ?? config('commissions.default_rate', 0.10);
        
        // 2. Aplicar Bonos por Calidad de Lead (IA Incentive)
        $bonuses = config('commissions.bonuses', []);
        $appliedBonus = 0;
        
        $scoreThreshold = $bonuses['high_score_threshold'] ?? 85;
        if ($leadScore >= $scoreThreshold) {
            $appliedBonus += $bonuses['high_score_lead'] ?? 0;
        }

        // 3. Cálculo Final
        $finalRate  = $rate + $appliedBonus;
        $commission = $premiumAmount * $finalRate;

        return [
            'base_rate'     => ($rate * 100) . '%',
            'lead_bonus'    => ($appliedBonus * 100) . '%',
            'final_rate'    => ($finalRate * 100) . '%',
            'total_amount'  => $commission,
            'currency'      => config('commissions.currency', 'USD'),
            'payout_ready'  => $commission >= config('commissions.min_payout', 50.00)
        ];
    }
}
