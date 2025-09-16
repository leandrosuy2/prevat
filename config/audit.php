<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações de Auditoria
    |--------------------------------------------------------------------------
    |
    | Este arquivo contém as configurações para o sistema de auditoria
    | do Prevat, incluindo retenção de logs e configurações de segurança.
    |
    */

    // Configurações gerais
    'enabled' => env('AUDIT_ENABLED', true),
    
    // Retenção de logs (em dias)
    'retention' => [
        'audit_logs' => env('AUDIT_RETENTION_LOGS', 90),
        'user_sessions' => env('AUDIT_RETENTION_SESSIONS', 60),
        'certificate_reissues' => env('AUDIT_RETENTION_REISSUES', 365),
    ],

    // Configurações de segurança
    'security' => [
        // Horário comercial (formato 24h)
        'business_hours' => [
            'start' => env('AUDIT_BUSINESS_HOURS_START', 8),
            'end' => env('AUDIT_BUSINESS_HOURS_END', 18),
        ],
        
        // Dias da semana (0 = domingo, 6 = sábado)
        'business_days' => [1, 2, 3, 4, 5], // Segunda a sexta
        
        // IPs considerados seguros (rede interna)
        'safe_networks' => [
            '192.168.0.0/16',
            '10.0.0.0/8',
            '172.16.0.0/12',
        ],
        
        // Limite de acessos suspeitos por usuário por semana
        'suspicious_limit' => env('AUDIT_SUSPICIOUS_LIMIT', 3),
    ],

    // Ações que devem ser registradas
    'tracked_actions' => [
        'auth' => [
            'login_success',
            'login_failed',
            'logout',
            'password_reset',
            'password_change',
        ],
        'user' => [
            'user_created',
            'user_updated',
            'user_deleted',
            'user_restored',
            'role_changed',
        ],
        'certificate' => [
            'certificate_generated',
            'certificate_downloaded',
            'certificate_reissued',
            'certificate_validated',
        ],
        'training' => [
            'training_scheduled',
            'training_cancelled',
            'participant_registered',
            'participant_removed',
        ],
        'financial' => [
            'payment_received',
            'invoice_generated',
            'refund_processed',
        ],
        'system' => [
            'backup_created',
            'maintenance_mode',
            'config_changed',
        ],
    ],

    // Configurações de notificação
    'notifications' => [
        'enabled' => env('AUDIT_NOTIFICATIONS_ENABLED', true),
        'channels' => [
            'email' => env('AUDIT_NOTIFY_EMAIL', true),
            'slack' => env('AUDIT_NOTIFY_SLACK', false),
            'webhook' => env('AUDIT_NOTIFY_WEBHOOK', false),
        ],
        
        // Eventos que geram notificações
        'events' => [
            'multiple_suspicious_access',
            'external_ip_access',
            'after_hours_access',
            'certificate_reissue',
            'user_creation',
            'role_change',
        ],
    ],

    // Configurações de exportação
    'export' => [
        'enabled' => env('AUDIT_EXPORT_ENABLED', true),
        'formats' => ['csv', 'xlsx', 'pdf'],
        'max_records' => env('AUDIT_EXPORT_MAX_RECORDS', 10000),
    ],

    // Configurações de API de geolocalização
    'geolocation' => [
        'enabled' => env('AUDIT_GEOLOCATION_ENABLED', true),
        'provider' => env('AUDIT_GEOLOCATION_PROVIDER', 'ip-api'),
        'timeout' => env('AUDIT_GEOLOCATION_TIMEOUT', 5),
        'cache_duration' => env('AUDIT_GEOLOCATION_CACHE', 86400), // 24 horas
    ],

    // Configurações de limpeza automática
    'cleanup' => [
        'enabled' => env('AUDIT_CLEANUP_ENABLED', true),
        'schedule' => env('AUDIT_CLEANUP_SCHEDULE', 'daily'),
        'time' => env('AUDIT_CLEANUP_TIME', '02:00'),
    ],
];
