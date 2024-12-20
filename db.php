<?php
$host = 'localhost';
$db = 'hotel_reservation';
$user = 'root';
$pass = 'Root1234!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Utility function for logging errors
function log_error($message) {
    error_log("Debugging message: " . print_r($message, true)); // Log to file
    // var_dump($message); // Display to screen (for development only)
}
?>
