<?php
$host = 'localhost';
$db = 'hotel_reservation';
$user = 'root';
$pass = 'Root1234!';
try {
 $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
 die("Koneksi gagal: " . $e->getMessage());
}
?>