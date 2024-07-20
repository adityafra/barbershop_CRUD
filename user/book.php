<?php
include '../includes/db.php';
include '../includes/auth.php';
requireLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id'];
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $service = $_POST['service'];
    $harga = $_POST['harga'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = 'Menunggu';

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

        $existing_bookings = $conn->query("SELECT * FROM bookings WHERE date='$date' AND time BETWEEN '$start_time' AND '$end_time'");

        if ($existing_bookings->num_rows > 0) {
            $message = "Waktu sudah dipesan. Harap pilih waktu lain.";
        } else {
            $conn->query("INSERT INTO bookings (user_id, name, nomor_telepon, service, harga, date, time, status) VALUES ('$user_id', '$nama', '$nomor_telepon', '$service', '$harga', '$date', '$time', '$status')");
            $booking_id = $conn->insert_id;
            header("Location: invoice.php?booking_id=$booking_id");
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Service - Barbershop</title>
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
<div class="container mt-4">
    <h2>Pesan Layanan</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form action="book.php" method="post">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Layanan</label>
            <select name="service" id="service" class="form-control" onchange="updatePrice()" required>
                <?php foreach ($services as $service => $price): ?>
                    <option value="<?= htmlspecialchars($service) ?>"><?= htmlspecialchars($service) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="text" id="price" name="harga" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Waktu</label>
            <input type="time" name="time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
