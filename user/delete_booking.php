<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    
    $conn->query("DELETE FROM bookings WHERE id='$booking_id'");
    header("Location: mybookings.php");
    exit();
} else {
    die("Booking ID is required.");
}
?>
