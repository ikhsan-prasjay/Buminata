<?php
require 'koneksi.php';

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Cek email duplikat
    $cek = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
    if(mysqli_num_rows($cek) > 0){
        $alert = "Email sudah terdaftar!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', 'customer')");
        if ($insert) {
            echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='index.php';</script>";
        } else {
            $alert = "Registrasi Gagal!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 400px;">
        <h4 class="text-center text-primary mb-3">Daftar Akun</h4>
        <?php if(isset($alert)) echo "<div class='alert alert-danger'>$alert</div>"; ?>
        <form method="POST">
            <div class="mb-2">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
            <div class="text-center mt-2">
                <a href="index.php">Kembali ke Login</a>
            </div>
        </form>
    </div>
</body>
</html>