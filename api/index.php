<?php
session_start();
require 'koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);
        if (password_verify($password, $data['password'])) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['role'] = $data['role'];

            if ($data['role'] == "admin") {
                header("location:admin.php");
            } else {
                header("location:customer.php");
            }
        } else {
            $alert = "Password salah!";
        }
    } else {
        $alert = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login SI Umrah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #198754 0%, #0d6efd 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <div class="card p-4" style="width: 400px;">
        <h3 class="text-center text-success mb-4">Login SI Umrah</h3>
        <?php if(isset($alert)): ?>
            <div class="alert alert-danger"><?= $alert ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-success w-100">Masuk</button>
            <div class="text-center mt-3">
                <small>Belum punya akun? <a href="register.php">Daftar disini</a></small>
            </div>
        </form>
    </div>
</body>
</html>