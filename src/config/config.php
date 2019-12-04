<?php

return [

    /**
     * Storage Adapters
     * The storage adapter
     */
    'storage' => [
        'enabled' => true,
        'driver' => 'file', // redis, file, pdo, eloquent, custom
        'path' => storage_path('app/runtime.json'), // For file driver
        'connection' => null, // leave null for default connection
        'table' => 'runtime_config', //Table name when using database driving drivers
        'provider' => '', // instance of StorageInterface for custom driver
        // KnightAR\Laravel\Config\Adapters\Db::class,
    ],

    /**
     * The list of modifiers you want to allow into your Config instance
     */
    'modifiers' => [
        KnightAR\Laravel\Config\Modifiers\Json::class,
        KnightAR\Laravel\Config\Modifiers\Boolean::class,
    ]
];
