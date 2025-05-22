<?php
// Database configuration
$host = 'localhost';
$dbname = 'praktikum4';
$username = 'root';
$password = '';

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 