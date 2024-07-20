<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();

if (!isset($_GET['booking_id'])) {
    header('Location: mybookings.php');
    exit();
}

$booking_id = $_GET['booking_id'];
$result = $conn->query("SELECT * FROM bookings WHERE id='$booking_id' AND user_id='{$_SESSION['user']['id']}'");

if ($result->num_rows == 0) {
    header('Location: mybookings.php');
    exit();
}

$booking = $result->fetch_assoc();

$date = new DateTime($booking['date']);
$formatted_date = $date->format('d-m-Y');

$time = new DateTime($booking['time']);
$formatted_time = $time->format('H:i');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Invoice</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"># <?= htmlspecialchars($booking_id) ?></h5>
            <p class="card-text"><strong>Nama:</strong> <?= htmlspecialchars($booking['name']) ?></p>
            <p class="card-text"><strong>Nomor Telepon:</strong> <?= htmlspecialchars($booking['nomor_telepon']) ?></p>
            <p class="card-text"><strong>Layanan:</strong> <?= htmlspecialchars($booking['service']) ?></p>
            <p class="card-text"><strong>Harga:</strong> Rp <?= number_format($booking['harga'], 3, '.', ',') ?></p>
            <p class="card-text"><strong>Tanggal:</strong> <?= htmlspecialchars($formatted_date) ?></p>
            <p class="card-text"><strong>Waktu:</strong> <?= htmlspecialchars($formatted_time) ?> WIB</p>
            <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($booking['status']) ?></p>
        </div>
    </div>
    <a href="mybookings.php" class="btn btn-primary mt-3">Kembali ke Pemesanan Saya</a>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
