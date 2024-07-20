<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_GET['id'];
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $service = $_POST['service'];
    $harga = $_POST['harga'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Cek apakah waktu pemesanan valid
    $time_start_morning = strtotime('10:00');
    $time_end_morning = strtotime('17:00');
    $time_start_evening = strtotime('18:30');
    $time_end_evening = strtotime('22:00');
    $booking_time = strtotime($time);

    $is_valid_time = ($booking_time >= $time_start_morning && $booking_time <= $time_end_morning) || ($booking_time >= $time_start_evening && $booking_time <= $time_end_evening);

    if ($is_valid_time) {
        // Cek apakah ada pemesanan lain pada waktu yang sama
        $buffer_time = 20 * 60; // 20 menit dalam detik
        $start_time = date('H:i:s', $booking_time - $buffer_time);
        $end_time = date('H:i:s', $booking_time + $buffer_time);

        $existing_bookings = $conn->query("SELECT * FROM bookings WHERE date='$date' AND time BETWEEN '$start_time' AND '$end_time' AND id != '$booking_id'");

        if ($existing_bookings->num_rows > 0) {
            $message = "Waktu sudah dipesan. Harap pilih waktu lain.";
        } else {
            $conn->query("UPDATE bookings SET name='$nama', nomor_telepon='$nomor_telepon', service='$service', harga='$harga', date='$date', time='$time' WHERE id='$booking_id'");
            header("Location: mybookings.php");
            exit();
        }
    } else {
        $message = "Silahkan pilih pemesanan antara 10:00-17:00 atau 18:30-22:00.";
    }
}

// Definisikan layanan dan harganya
$services = [
    '== Silahkan pilih layanan ==' => 0,
    'Potongan Rambut' => 50.000,
    'Cukur Bersih' => 20.000,
    'Pangkas Jenggot' => 25.000,
    'Cukur Kepala' => 40.000,
    'Pewarnaan Rambut' => 80.000,
    'Perawatan Kulit Kepala' => 70.000,
    'Perawatan Rambut' => 60.000,
    'Perawatan Jenggot' => 35.000,
    'Kombinasi Potong Rambut & Pangkas Jenggot' => 70.000,
    'Kombinasi Potong Rambut & Cukur' => 60.000,
];

$booking_id = $_GET['id'];
$result = $conn->query("SELECT * FROM bookings WHERE id='$booking_id'");
$booking = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function updatePrice() {
            const services = <?= json_encode($services) ?>;
            const service = document.getElementById('service').value;
            const price = services[service];
            document.getElementById('price').value = price;
        }
    </script>
</head>
<body>
<?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h2>Edit Booking</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form action="edit_booking.php?id=<?= $booking_id ?>" method="POST">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($booking['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" class="form-control" name="nomor_telepon" value="<?= htmlspecialchars($booking['nomor_telepon']) ?>" required>
        </div>
        <div class="form-group">
            <label>Layanan</label>
            <select name="service" id="service" class="form-control" onchange="updatePrice()" required>
                <?php foreach ($services as $service => $price): ?>
                    <option value="<?= htmlspecialchars($service) ?>" <?= $booking['service'] === $service ? 'selected' : '' ?>><?= htmlspecialchars($service) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="text" id="price" name="harga" class="form-control" value="<?= htmlspecialchars($booking['harga']) ?>" readonly required>
        </div>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" class="form-control" name="date" value="<?= htmlspecialchars($booking['date']) ?>" required>
        </div>
        <div class="form-group">
            <label>Waktu</label>
            <input type="time" class="form-control" name="time" value="<?= htmlspecialchars($booking['time']) ?>" required>
        </div>
       
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
