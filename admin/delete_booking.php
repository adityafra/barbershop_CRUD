<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();
requireAdmin();

if (!isset($_GET['id'])) {
    header("Location: bookings.php");
    exit();
}

$id = $_GET['id'];

$conn->query("DELETE FROM bookings WHERE id='$id'");

header("Location: bookings.php");
exit();
?>
