<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h1>Welcome, <?= $_SESSION['user']['username'] ?></h1>
    <p>Anda telah masuk ke dashboard admin Barbershop. Di sini, Anda dapat mengelola pemesanan dan melihat laporan kegiatan. Pastikan untuk menjaga segala sesuatunya berjalan dengan lancar untuk pengalaman pelanggan yang optimal.</p>
</div>
</body>
</html>
