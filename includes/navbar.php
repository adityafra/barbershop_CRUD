<?php
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>
<style>
    .navbar {
        background-color: #343a40; /* Warna latar belakang navbar */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Efek shadow */
    }

    .navbar-brand {
        font-size: 1.5rem; /* Ukuran teks brand */
        font-weight: bold; /* Ketebalan teks brand */
    }

    .navbar-nav .nav-link {
        font-size: 1.1rem; /* Ukuran teks link */
    }

    .navbar-nav .nav-link:hover {
        color: white !important; /* Warna teks link saat dihover */
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="#">Barbershop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if ($isAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bookings.php">Kelola Pemesanan</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="book.php">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mybookings.php">Pemesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="queue.php">Antrian</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
