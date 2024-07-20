<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();

// Ambil tanggal dari parameter URL atau gunakan tanggal hari ini
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Ambil pemesanan dengan status "Dikonfirmasi" atau "Selesai" untuk tanggal yang dipilih
$queue = $conn->query("SELECT * FROM bookings WHERE date='$date' AND status IN ('Dikonfirmasi', 'Selesai') ORDER BY time");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Antrian - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2>Antrian Pemesanan</h2>
    <form method="GET" action="queue.php" class="mb-4">
        <div class="form-group">
            <label for="date">Pilih Tanggal:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>No. Urut</th>
                <th>Nama</th>
                <th>Nomor Telepon</th>
                <th>Layanan</th>
                <th>Harga</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($queue->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($booking = $queue->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($booking['name']) ?></td>
                        <td><?= htmlspecialchars($booking['nomor_telepon']) ?></td>
                        <td><?= htmlspecialchars($booking['service']) ?></td>
                        <td><?= 'Rp ' . number_format($booking['harga'], 3) ?></td>
                        <td><?= date('H:i', strtotime($booking['time'])) ?></td>
                        <td><?= htmlspecialchars($booking['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Belum ada pemesanan untuk hari ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
