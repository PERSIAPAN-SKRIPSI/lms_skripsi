<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Notify Theme
    |--------------------------------------------------------------------------
    |
    | You can change the theme of notifications by specifying the desired theme.
    | By default the theme light is activated, but you can change it by
    | specifying the dark mode. To change theme, update the global variable to `dark`
    |
    */

    'theme' => env('NOTIFY_THEME', 'dark'), // Default dark theme untuk match UI

    /*
    |--------------------------------------------------------------------------
    | Notification timeout
    |--------------------------------------------------------------------------
    |
    | Defines the number of seconds during which the notification will be visible.
    |
    */

    'timeout' => 5000,

    /*
    |--------------------------------------------------------------------------
    | Toast Notification Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how toast notifications should be displayed
    |
    */

    'toast' => [
        'position' => [
            'x' => 'right', // left, center, right
            'y' => 'top' // top, bottom
        ],
        'animation' => [
            'in' => 'fade-in-up', // fade-in, fade-in-up, slide-in-right
            'out' => 'fade-out' // fade-out, fade-out-down, slide-out-right
        ],
        'styles' => [
            'container' => 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg rounded-lg p-4',
            'title' => 'text-lg font-semibold text-gray-800 dark:text-gray-200',
            'message' => 'mt-1 text-sm text-gray-600 dark:text-gray-400',
            'success' => [
                'container' => 'border-green-500',
                'title' => 'text-green-600 dark:text-green-400',
                'icon' => '✅'
            ],
            'error' => [
                'container' => 'border-red-500',
                'title' => 'text-red-600 dark:text-red-400',
                'icon' => '❌'
            ],
            'warning' => [
                'container' => 'border-yellow-500',
                'title' => 'text-yellow-600 dark:text-yellow-400',
                'icon' => '⚠️'
            ],
            'info' => [
                'container' => 'border-blue-500',
                'title' => 'text-blue-600 dark:text-blue-400',
                'icon' => 'ℹ️'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Preset Messages
    |--------------------------------------------------------------------------
    |
    | Define any preset messages here that can be reused.
    | Available model: connect, drake, emotify, smiley, toast
    |
    */

    'preset-messages' => [
        'login-success' => [
            'message' => 'Anda telah berhasil login!',
            'type' => 'success',
            'model' => 'toast',
            'title' => 'Selamat Datang'
        ],
        'login-error' => [
            'message' => 'Email atau password salah!',
            'type' => 'error',
            'model' => 'toast',
            'title' => 'Gagal Login'
        ],
        'logout-success' => [
            'message' => 'Anda telah berhasil logout!',
            'type' => 'success',
            'model' => 'toast',
            'title' => 'Sampai Jumpa'
        ],
        'password-reset' => [
            'message' => 'Link reset password telah dikirim ke email Anda!',
            'type' => 'success',
            'model' => 'toast',
            'title' => 'Reset Password'
        ]
    ],
];
