<?php
$host = 'localhost';        // or your server host name
$db   = 'student_system';   // your database name
$user = 'root';             // your DB username (often 'root' in XAMPP/WAMP)
$pass = '';                 // your DB password ('' if none on localhost)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Use native prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $conn = new mysqli($host, $user, $pass, $db); // Also include mysqli for compatibility
    if ($conn->connect_error) {
        die("MySQLi Connection failed: " . $conn->connect_error);
    }
} catch (PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}
?>
