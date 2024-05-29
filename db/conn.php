<?php require_once __DIR__ . "/../private/index.php";

/** Open Up A PHP-MySQL connection with OOP MySQLi */
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_errno)
{
    echo "Database Connection Failed: " . $conn->connect_error;
    exit();
}

?>