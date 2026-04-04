<?php
/**
 * config/ai.php — Configuración Avanzada del Módulo GAI
 * empresaIMO — Zero-Hardcode Architecture
 */
return [

    // ─── Proveedor Activo (configurable desde .env) ────────────────────────────
    'provider' => env('AI_PROVIDER', 'groq'),
    'model'    => env('AI_MODEL', 'llama-3.1-8b-instant'),
    'api_key'  => env('AI_API_KEY', ''),

    // ─── Parámetros de Inferencia ──────────────────────────────────────────────
    'temperature'  => (float) env('AI_TEMPERATURE', '0.3'),
    'max_tokens'   => (int)   env('AI_MAX_TOKENS',  '512'),
    'timeout'      => (int)   env('AI_TIMEOUT',     '15'),

    // ─── URLs de los Proveedores Soportados ────────────────────────────────────
    'endpoints' => [
        'groq'    => 'https://api.groq.com/openai/v1/chat/completions',
        'openai'  => 'https://api.openai.com/v1/chat/completions',
        'ollama'  => env('OLLAMA_URL', 'http://localhost:11434/api/chat'),
    ],

    // ─── Prompts del Sistema (Scoring de Leads) ────────────────────────────────
    'scoring_system_prompt' => implode(' ', [
        'Eres un agente de inteligencia comercial experto en IMOs (Insurance Marketing Organizations) del mercado hispano de EE.UU.',
        'Tu objetivo es calificar prospectos interesados en seguros de Vida, Gastos Médicos y Protección Patrimonial.',
        'Analiza el JSON del lead y devuelve ÚNICAMENTE un JSON válido con:',
        '{"score": <0-100>, "priority": "<Standard|VIP>", "analysis": "<resumen en 1 oración>", "recommended_action": "<acción recomendada>"}.',
        'Criterios VIP: Interés en Vida/Patrimonio, leads entre 35-55 años, horario laboral EE.UU.',
        'NO incluyas texto adicional fuera del JSON.',
    ]),

    // ─── Umbrales de Scoring ───────────────────────────────────────────────────
    'thresholds' => [
        'vip'      => (int) env('AI_THRESHOLD_VIP',    '80'),
        'standard' => (int) env('AI_THRESHOLD_STD',    '40'),
    ],

    // ─── Habilitación por Entorno ──────────────────────────────────────────────
    'enabled'         => env('LEAD_SCORING_ENABLED', true),
    'fallback_score'  => (int) env('AI_FALLBACK_SCORE', '50'),

];
