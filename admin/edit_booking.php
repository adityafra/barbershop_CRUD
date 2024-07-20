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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $conn->query("UPDATE bookings SET status='$status' WHERE id='$id'");
    header("Location: bookings.php");
    exit();
}

$booking = $conn->query("SELECT * FROM bookings WHERE id='$id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking Status - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Edit Booking Status</h2>
    <form action="edit_booking.php?id=<?= $id ?>" method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($booking['name']) ?>" disabled>
        </div>
        <div class="form-group">
            <label>Service</label>
            <input type="text" name="service" class="form-control" value="<?= htmlspecialchars($booking['service']) ?>" disabled>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($booking['date']) ?>" disabled>
        </div>
        <div class="form-group">
            <label>Time</label>
            <input type="time" name="time" class="form-control" value="<?= htmlspecialchars($booking['time']) ?>" disabled>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Menunggu" <?= $booking['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                <option value="Dikonfirmasi" <?= $booking['status'] == 'Dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi</option>
                <option value="Dibatalkan" <?= $booking['status'] == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                <option value="Selesai" <?= $booking['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
        <a href="bookings.php" class="btn btn-dark">Kembali</a>
    </form>
</div>
</body>
</html>
