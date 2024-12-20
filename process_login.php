<?php
session_start();
$_SESSION['user_id'] = $user['id']; // Assuming `$user['id']` is fetched from the database
$_SESSION['username'] = $user['username']; // Set any other relevant data
header("Location: form_reservasi.php");
exit();

?>