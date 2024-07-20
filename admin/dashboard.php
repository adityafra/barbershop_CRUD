<?php
include '../includes/auth.php';
requireLogin();
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Barbershop</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Welcome, Admin <?= $_SESSION['user']['username'] ?></h1>
    <a href="bookings.php" class="btn btn-primary">Manage Bookings</a>
    <a href="report.php" class="btn btn-secondary">Generate Report</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
