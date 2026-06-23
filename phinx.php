<?php

declare(strict_types=1);

// Load DB credentials from /etc/vscz.env
$envFile = '/etc/vscz.env';

if (file_exists($envFile)) {
    foreach (file($envFile, \FILE_IGNORE_NEW_LINES | \FILE_SKIP_EMPTY_LINES) as $line) {
        if (!str_starts_with(trim($line), '#') && str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

$host = $_ENV['DB_HOST'] ?? 'localhost';
$port = (int) ($_ENV['DB_PORT'] ?? 3306);
$name = $_ENV['DB_DATABASE'] ?? 'vscz';
$user = $_ENV['DB_USERNAME'] ?? 'vscz';
$pass = $_ENV['DB_PASSWORD'] ?? '';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds'      => [
            '%%PHINX_CONFIG_DIR%%/db/seeds',
            '%%PHINX_CONFIG_DIR%%/db/seeds/releases',
        ],
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'development',
        'production'              => [
            'adapter' => 'mysql',
            'host'    => $host,
            'name'    => $name,
            'user'    => $user,
            'pass'    => $pass,
            'port'    => $port,
            'charset' => 'utf8mb4',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host'    => $host,
            'name'    => $name,
            'user'    => $user,
            'pass'    => $pass,
            'port'    => $port,
            'charset' => 'utf8mb4',
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host'    => 'localhost',
            'name'    => 'vitexsoftware',
            'user'    => 'vitexsoftware',
            'pass'    => 'vitexsoftware',
            'port'    => 5432,
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation',
];
