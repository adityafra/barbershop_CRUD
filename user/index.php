<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h1>Welcome, <?= $_SESSION['user']['username'] ?></h1>
    <p>Anda telah masuk ke dashboard pengguna Barbershop. Di sini, Anda dapat melakukan pemesanan layanan kami dengan mudah dan melihat riwayat pemesanan Anda sebelumnya. Jika ada yang bisa kami bantu, jangan ragu untuk menghubungi kami.</p>
</div>
</div>
</body>
</html>
