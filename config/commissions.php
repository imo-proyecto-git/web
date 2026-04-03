<?php
/**
 * Configuración de Comisiones (Agent Rewards)
 * empresaIMO - Arquitectura Zero-Hardcode
 */

return [
    'default_rate' => (float) env('COMMISSION_DEFAULT_RATE', 0.10),
    
    'rates_by_service' => [
        'life'   => (float) env('RATE_LIFE', 0.15),
        'health' => (float) env('RATE_HEALTH', 0.12),
        'wealth' => (float) env('RATE_WEALTH', 0.20),
    ],
    
    'bonuses' => [
        'high_score_lead'      => (float) env('BONUS_HIGH_SCORE', 0.05),
        'high_score_threshold' => (int)   env('BONUS_SCORE_THRESHOLD', 85),
        'speed_to_lead'        => (float) env('BONUS_SPEED', 0.02),
    ],
    
    'currency'   => env('COMMISSION_CURRENCY', 'USD'),
    'min_payout' => (float) env('COMMISSION_MIN_PAYOUT', 50.00),
    'simulated_premium_base' => (float) env('SIMULATED_PREMIUM', 1200.00),
];
