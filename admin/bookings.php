<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();
requireAdmin();

$bookings = $conn->query("SELECT bookings.*, users.username FROM bookings JOIN users ON bookings.user_id = users.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

    <h2>Kelola Pemesanan</h2>
    <!-- <a href="add_booking.php" class="btn btn-primary mb-3">Add Booking</a> -->
    <a href="report.php" class="btn btn-info mb-2" style="margin-left: 15px;">Cetak Laporan</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Nomor Telepon</th>
                    <th>Layanan</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?= $booking['username'] ?></td>
                        <td><?= $booking['name'] ?></td>
                        <td><?= $booking['nomor_telepon'] ?></td>
                        <td><?= $booking['service'] ?></td>
                        <td>Rp <?= number_format($booking['harga'], 3, '.', ',') ?></td>
                        <td><?= date('d-m-Y', strtotime($booking['date'])) ?></td>
                        <td><?= date('H:i', strtotime($booking['time'])) ?></td>
                        <td><?= $booking['status'] ?></td>
                        <td>
                            <a href="edit_booking.php?id=<?= $booking['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_booking.php?id=<?= $booking['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
