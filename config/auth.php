<?php

return [
    'defaults' => [
        'guard' => 'warga',
        'passwords' => 'wargas'
    ],
    
    'guards' => [
        'warga' => [
            'driver' => 'session',
            'provider' => 'wargas'
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins'
        ],
    ],

    'providers' => [
        'wargas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Warga::class
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class
        ],
    ],

    'passwords' => [
        'wargas' => [
            'provider' => 'wargas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60
        ],
    ],
    'password_timeout' => 10800,
];
