<?php
include '../includes/db.php';
include '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        if ($user['role'] == 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: index.php");
        }
    } else {
        $error = "username dan password tidak valid";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Barbershop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('../Bg.png') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .footer {
            margin-top: auto;
            padding: 10px 0;
            background-color: #f8f9fa;
            text-align: center;
            width: 100%;
        }
    </style>
    <script>
        window.onload = function() {
            const usernameInput = document.querySelector('input[name="username"]');
            const cookies = document.cookie.split(';').reduce((acc, cookie) => {
                const [key, value] = cookie.split('=').map(c => c.trim());
                acc[key] = value;
                return acc;
            }, {});

            if (cookies['registeredUsername']) {
                usernameInput.value = cookies['registeredUsername'];
                document.cookie = 'registeredUsername=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Masuk</button>
    </form>
    <div class="register-link">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a>.</p>
    </div>
</div>
<!-- <footer class="footer">
    <div>
        <span class="text-muted">Adityafra &copy; 2024</span>
    </div>
</footer> -->
</body>
</html>