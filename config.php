<?php
require_once "support/Helpers.php";

createEnv();

$config = [
    'database' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'host' => env('HOST', 'localhost'),
        'database' => env('DB_NAME'),
        'username' => env('DB_USER_NAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
    ],
];
