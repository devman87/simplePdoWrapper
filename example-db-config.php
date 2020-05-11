<?php

return [
    'default' => 'config1',
    'config1' => [
        'dsn' => 'mysql:host=localhost;dbname=testdb;charset=utf8mb4',
        'username' => 'test',
        'password' => 'test',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],
    'config2' => [
        'hostname' => "pgsql:dbname=testdb;host=localhost options='--client_encoding=UTF8';",
        'username' => 'test',
        'password' => 'test',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ]
];
