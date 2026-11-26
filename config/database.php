
<?php
declare(strict_types=1);

function database(): PDO {
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $databaseUrl = getenv('DATABASE_URL');

    if ($databaseUrl) {
        $parts = parse_url($databaseUrl);

        if (!$parts || empty($parts['host']) || empty($parts['path'])) {
            throw new RuntimeException('Invalid database connection URL.');
        }

        $host = $parts['host'];
        $port = $parts['port'] ?? 3306;
        $name = rawurldecode(ltrim($parts['path'], '/'));
        $user = rawurldecode($parts['user'] ?? '');
        $pass = rawurldecode($parts['pass'] ?? '');

    } else {
        $host = getenv('SMS_DB_HOST') ?: '127.0.0.1';
        $port = getenv('SMS_DB_PORT') ?: '3306';
        $name = getenv('SMS_DB_NAME') ?: 'student_management_system';
        $user = getenv('SMS_DB_USER') ?: 'root';
        $pass = getenv('SMS_DB_PASSWORD') ?: '';
    }

    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    return $pdo;
}
