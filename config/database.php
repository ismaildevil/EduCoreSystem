
<?php
declare(strict_types=1);

function database(): PDO {
    static $pdo = null;

    if ($pdo instanceof PDO) return $pdo;

    $url = getenv('DATABASE_URL');

    if ($url) {
        $db = parse_url($url);

        $host = $db['host'];
        $port = $db['port'] ?? 3306;
        $name = rawurldecode(ltrim($db['path'], '/'));
        $user = rawurldecode($db['user'] ?? '');
        $pass = rawurldecode($db['pass'] ?? '');
    } else {
        $host = getenv('SMS_DB_HOST') ?: '127.0.0.1';
        $port = getenv('SMS_DB_PORT') ?: 3306;
        $name = getenv('SMS_DB_NAME') ?: 'student_management_system';
        $user = getenv('SMS_DB_USER') ?: 'root';
        $pass = getenv('SMS_DB_PASSWORD') ?: '';
    }

    return $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}
