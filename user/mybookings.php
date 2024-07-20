<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user']['id'];
$bookings = $conn->query("SELECT * FROM bookings WHERE user_id='$user_id'");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_booking_id'])) {
    $booking_id = $_POST['cancel_booking_id'];
    $conn->query("UPDATE bookings SET status='Dibatalkan' WHERE id='$booking_id' AND user_id='$user_id'");
    header("Location: mybookings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2>Pemesanan Saya</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor Telepon</th>
                <th>Layanan</th>
                <th>Harga</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($bookings->num_rows > 0): ?>
                <?php while ($booking = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['name']) ?></td>
                        <td><?= htmlspecialchars($booking['nomor_telepon']) ?></td>
                        <td><?= htmlspecialchars($booking['service']) ?></td>
                        <td><?= 'Rp ' . number_format($booking['harga'], 3) ?></td>
                        <td><?= date('d-m-Y', strtotime($booking['date'])) ?></td>
                        <td><?= date('H:i', strtotime($booking['time'])) ?></td>
                        <td><?= htmlspecialchars($booking['status']) ?></td>
                        <td>
                            <?php if ($booking['status'] == 'Selesai'): ?>
                                <button class="btn btn-primary btn-sm" disabled>Edit</button>
                                <button class="btn btn-danger btn-sm" disabled>Batalkan</button>
                            <?php else: ?>
                                <a href="edit_booking.php?id=<?= $booking['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form action="mybookings.php" method="post" style="display:inline;">
                                    <input type="hidden" name="cancel_booking_id" value="<?= $booking['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?');">Batalkan</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Anda belum memiliki pemesanan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
