<?php

return [
    'database' => [
        'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
        'host' => $_ENV['DB_HOST'],
        'user' => $_ENV['DB_USERNAME'],
        'pass' => $_ENV['DB_PASSWORD'],
        'database' => $_ENV['DB_DATABASE'],
        'port' => $_ENV['DB_PORT']
    ],
    'app' => [
        'name' => $_ENV['APP_NAME'],
        'url' => $_ENV['APP_URL'],
        'port' => $_ENV['APP_PORT']
    ],
];
