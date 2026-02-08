<?php
// Database configuration
$servername = "localhost";
$db_username = "root";
$db_password = "root@123";
$dbname = "engine_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");
?>