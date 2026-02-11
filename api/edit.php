<?php
session_start();
require 'koneksi.php';

if ($_SESSION['role'] != 'admin' || !isset($_GET['id'])) {
    header("location:admin.php");
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_umrah WHERE id='$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $paket = $_POST['paket'];
    $tgl = $_POST['tgl'];
    $bayar = $_POST['bayar'];
    $status = $_POST['status'];

    $query = "UPDATE data_umrah SET nama_jamaah='$nama', paket_umroh='$paket', tanggal_berangkat='$tgl', status_pembayaran='$bayar', status_keberangkatan='$status' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)){
        header("location:admin.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card col-md-6 mx-auto shadow">
            <div class="card-header bg-warning">Edit Data: <?= $data['no_registrasi'] ?></div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-2"><label>Nama</label><input type="text" name="nama" class="form-control" value="<?= $data['nama_jamaah'] ?>"></div>
                    <div class="mb-2"><label>Paket</label><input type="text" name="paket" class="form-control" value="<?= $data['paket_umroh'] ?>"></div>
                    <div class="mb-2"><label>Tanggal</label><input type="date" name="tgl" class="form-control" value="<?= $data['tanggal_berangkat'] ?>"></div>
                    <div class="mb-2">
                        <label>Pembayaran</label>
                        <select name="bayar" class="form-select">
                            <option value="Belum Lunas" <?= ($data['status_pembayaran']=='Belum Lunas')?'selected':'' ?>>Belum Lunas</option>
                            <option value="DP" <?= ($data['status_pembayaran']=='DP')?'selected':'' ?>>DP</option>
                            <option value="Lunas" <?= ($data['status_pembayaran']=='Lunas')?'selected':'' ?>>Lunas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status Keberangkatan</label>
                        <select name="status" class="form-select">
                            <option value="Menunggu" <?= ($data['status_keberangkatan']=='Menunggu')?'selected':'' ?>>Menunggu</option>
                            <option value="Siap Berangkat" <?= ($data['status_keberangkatan']=='Siap Berangkat')?'selected':'' ?>>Siap Berangkat</option>
                            <option value="Selesai" <?= ($data['status_keberangkatan']=='Selesai')?'selected':'' ?>>Selesai</option>
                            <option value="Batal" <?= ($data['status_keberangkatan']=='Batal')?'selected':'' ?>>Batal</option>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary w-100">Update Data</button>
                    <a href="admin.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>