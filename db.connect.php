<?php
// Database configuration
$host = "localhost";      // Database host
$username = "root";       // Database username
$password = "";           // Database password
$database = "uhashr";     // Database name

// Establish connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
