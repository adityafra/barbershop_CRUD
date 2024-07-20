<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();
requireAdmin();

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$bookings = $conn->query("SELECT bookings.*, users.username FROM bookings JOIN users ON bookings.user_id = users.id WHERE bookings.date = '$date'");
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-5">Laporan Barbershop</h2>
    <form method="GET" action="report.php" class="mb-4">
        <div class="form-group no-print">
            <label for="date">Pilih Tanggal:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>">
        </div>
        <button type="submit" class="btn btn-primary no-print">Tampilkan</button>
    </form>
    <button onclick="window.print()" class="btn btn-danger no-print">Cetak</button>
    <a href="bookings.php" class="btn btn-dark no-print">Kembali</a>
    <table class="table mt-3 table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor Telepon</th>
                <th>Layanan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($bookings->num_rows > 0): ?>
                <?php while ($booking = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['name']) ?></td>
                        <td><?= htmlspecialchars($booking['nomor_telepon']) ?></td>
                        <td><?= htmlspecialchars($booking['service']) ?></td>
                        <td><?= date('d-m-Y', strtotime($booking['date'])) ?></td>
                        <td><?= date('H:i', strtotime($booking['time'])) ?></td>
                        <td><?= htmlspecialchars($booking['status']) ?></td>
                        <td>Rp <?= number_format($booking['harga'], 3, '.', ',') ?></td>
                    </tr>
                    <?php $totalPrice += $booking['harga']; ?>
                <?php endwhile; ?>
                <tr>
                    <td colspan="6" class="text-left"><strong>Total Harga</strong></td>
                    <td><strong>Rp <?= number_format($totalPrice, 3, '.', ',') ?></strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada pemesanan untuk hari ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
