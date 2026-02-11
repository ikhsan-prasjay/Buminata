<?php
session_start();
require 'koneksi.php';

// Proteksi Halaman Admin
if ($_SESSION['role'] != 'admin') {
    header("location:index.php");
    exit();
}

// Logic Tambah Data
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $noreg = $_POST['noreg'];
    $paket = $_POST['paket'];
    $tgl = $_POST['tgl'];
    $bayar = $_POST['bayar'];
    $status = $_POST['status'];

    $query = "INSERT INTO data_umrah VALUES (NULL, '$nama', '$noreg', '$paket', '$tgl', '$bayar', '$status')";
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data berhasil ditambahkan'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal! No Registrasi mungkin sudah ada.');</script>";
    }
}

// Logic Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM data_umrah WHERE id='$id'");
    header("location:admin.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-success mb-4">
        <div class="container">
            <span class="navbar-brand">Admin Dashboard</span>
            <span class="text-white">Halo, <?= $_SESSION['nama'] ?> | <a href="logout.php" class="btn btn-sm btn-light text-success fw-bold">Logout</a></span>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">Tambah Data Jamaah</div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <div class="col-md-4"><input type="text" name="nama" class="form-control" placeholder="Nama Jamaah" required></div>
                    <div class="col-md-3"><input type="text" name="noreg" class="form-control" placeholder="No Registrasi (Unik)" required></div>
                    <div class="col-md-3"><input type="text" name="paket" class="form-control" placeholder="Paket Umroh" required></div>
                    <div class="col-md-2"><input type="date" name="tgl" class="form-control" required></div>
                    <div class="col-md-3">
                        <select name="bayar" class="form-select">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="DP">DP</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="Menunggu">Menunggu</option>
                            <option value="Siap Berangkat">Siap Berangkat</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Batal">Batal</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="tambah" class="btn btn-success w-100">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header">Data Jamaah Umroh</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>No Reg</th>
                                <th>Nama</th>
                                <th>Paket</th>
                                <th>Tgl Berangkat</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $tampil = mysqli_query($conn, "SELECT * FROM data_umrah ORDER BY id DESC");
                            while ($data = mysqli_fetch_array($tampil)) :
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-info text-dark"><?= $data['no_registrasi'] ?></span></td>
                                <td><?= $data['nama_jamaah'] ?></td>
                                <td><?= $data['paket_umroh'] ?></td>
                                <td><?= $data['tanggal_berangkat'] ?></td>
                                <td>
                                    <span class="badge bg-<?= ($data['status_pembayaran'] == 'Lunas') ? 'success' : 'warning' ?>">
                                        <?= $data['status_pembayaran'] ?>
                                    </span>
                                </td>
                                <td><?= $data['status_keberangkatan'] ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="admin.php?hapus=<?= $data['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>