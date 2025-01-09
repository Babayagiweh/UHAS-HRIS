<?php
// Database connection
$host = 'localhost'; // Change to your database host
$dbname = 'uhashr'; // Change to your database name
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password



try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
    
?>
