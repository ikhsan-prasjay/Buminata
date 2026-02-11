<?php
session_start();
require 'koneksi.php';

// Proteksi Customer
if ($_SESSION['role'] != 'customer') {
    header("location:index.php");
    exit();
}

$hasil = null;
if (isset($_POST['cari'])) {
    $noreg = mysqli_real_escape_string($conn, $_POST['noreg']);
    $query = mysqli_query($conn, "SELECT * FROM data_umrah WHERE no_registrasi='$noreg'");
    $hasil = mysqli_fetch_assoc($query);
    $pesan = $hasil ? "" : "Data tidak ditemukan! Cek kembali nomor registrasi Anda.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cek Data Umrah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <span class="navbar-brand text-primary fw-bold">SI Umrah Customer</span>
            <span>Halo, <?= $_SESSION['nama'] ?> | <a href="logout.php" class="text-danger">Logout</a></span>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center mb-4">
                <h2 class="text-success">Cek Status Keberangkatan</h2>
                <p class="text-muted">Masukkan Nomor Registrasi yang Anda terima dari Admin.</p>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm p-4 mb-4">
                    <form method="POST">
                        <div class="input-group">
                            <input type="text" name="noreg" class="form-control" placeholder="Contoh: REG-001" required>
                            <button type="submit" name="cari" class="btn btn-primary">Cek Data</button>
                        </div>
                    </form>
                </div>

                <?php if(isset($pesan) && $pesan != ""): ?>
                    <div class="alert alert-warning text-center"><?= $pesan ?></div>
                <?php endif; ?>

                <?php if($hasil): ?>
                <div class="card shadow border-success">
                    <div class="card-header bg-success text-white text-center fw-bold">
                        Data Ditemukan
                    </div>
                    <div class="card-body">
                        <h4 class="text-center mb-3"><?= $hasil['nama_jamaah'] ?></h4>
                        <table class="table table-borderless">
                            <tr><th>No. Registrasi</th><td>: <?= $hasil['no_registrasi'] ?></td></tr>
                            <tr><th>Paket Umroh</th><td>: <?= $hasil['paket_umroh'] ?></td></tr>
                            <tr><th>Tanggal Berangkat</th><td>: <?= $hasil['tanggal_berangkat'] ?></td></tr>
                            <tr><th>Status Pembayaran</th><td>: <span class="badge bg-warning text-dark"><?= $hasil['status_pembayaran'] ?></span></td></tr>
                            <tr><th>Status Saat Ini</th><td>: <span class="badge bg-info"><?= $hasil['status_keberangkatan'] ?></span></td></tr>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>