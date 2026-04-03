<?php
/**
 * Configuración de Inteligencia Artificial (GAI)
 * empresaIMO - Lead Scoring Engine
 */

return [
    'provider' => env('AI_PROVIDER', 'groq'),
    'model'    => env('AI_MODEL', 'llama-3.1-8b-instant'),
    'api_key'  => env('AI_API_KEY', ''),
    
    // Configuración del motor de reglas de scoring
    'scoring' => [
        'enabled'             => (bool) env('LEAD_SCORING_ENABLED', true),
        'qualified_threshold' => (int)  env('LEAD_QUALIFIED_THRESHOLD', 70),
        'min_score'           => (int)  env('LEAD_MIN_SCORE', 50),
        'rules' => [
            'email_corporate'    => (int) env('RULE_EMAIL_CORP', 15),
            'complete_profile'   => (int) env('RULE_PROFILE_COMP', 10),
            'high_value_service' => (int) env('RULE_HIGH_VALUE', 25),
        ],
    ]
];
