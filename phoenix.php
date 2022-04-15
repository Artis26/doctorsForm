<?php

return [
    'migration_dirs' => [
        'first' => __DIR__ . '/Migrations',
        'second' => __DIR__ . '/MigrationsTwo',
    ],
    'environments' => [
        'local' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'port' => 3306, // optional
            'username' => 'admin',
            'password' => 'admin',
            'db_name' => 'doctor',
            'charset' => 'utf8mb4',
        ],
        'production' => [
            'adapter' => 'mysql',
            'host' => 'production_host',
            'port' => 3306, // optional
            'username' => 'user',
            'password' => 'pass',
            'db_name' => 'my_production_db',
            'charset' => 'utf8mb4',
        ],
    ],
    'default_environment' => 'local',
    'log_table_name' => 'phoenix_log',
];
