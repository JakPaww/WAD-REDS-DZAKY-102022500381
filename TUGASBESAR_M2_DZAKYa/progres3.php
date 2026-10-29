<?php

$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_pelanggan"
);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


$selectSemua = mysqli_query($koneksi, "SELECT * FROM pelanggan");

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
    $selectProfil = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id = '$id'");
} else {
    $selectProfil = mysqli_query($koneksi, "SELECT * FROM pelanggan LIMIT 1");
}

$profil = mysqli_fetch_assoc($selectProfil);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Profil Pengguna</title>
</head>

<body class="bg-light py-4">

    <header class="container mb-4">
        <h1 class="text-center fw-bold fs-4 py-3">Profil Pengguna</h1>
    </header>

    <div class="container">

        <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-medium small mb-0">Pilih Pelanggan:</label>
                    <select class="form-select form-select-sm w-50"  onchange="location = 'progres3.php?id=' + this.value;">
                        <?php 
                        while ($data = mysqli_fetch_assoc($selectSemua)) { 
                            $isSelected = ($profil && $data['id'] == $profil['id']) ? 'selected' : '';
                        ?>
                            <option value="<?= $data['id']; ?>" <?= $isSelected; ?>>
                                <?= $data['nama']; ?> (<?= $data['level_member']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <a href="progres1.php" class="btn btn-outline-dark btn-sm">
                        Kembali ke Daftar Pelanggan
                    </a>
                </div>
            </div>
        </div>

        <?php if (!$profil) { ?>
            <div class="alert alert-secondary text-center rounded-3 p-4">
                Belum ada data pelanggan di database. Silakan tambahkan data terlebih dahulu di halaman <a href="progres1.php" class="alert-link">Data Pelanggan</a>.
            </div>
        <?php } else { ?>

            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-7 col-lg-6">
                    <div class="card border rounded-3 shadow-sm mb-4">
                        <div class="card-body text-center p-4">
                           
                            <h2 class="fw-bold fs-5 mb-1"><?= $profil['nama']; ?></h2>
                            <p class="text-muted small mb-2"><?= isset($profil['email']) ? $profil['email'] : '-'; ?></p>

                            <div class="mb-3">
                                <?php if ($profil['level_member'] == 'VIP') { ?>
                                    <span class="badge text-bg-dark px-3 py-2">VIP Member</span>
                                <?php } else if ($profil['level_member'] == 'Gold') { ?>
                                    <span class="badge text-bg-warning px-3 py-2">Gold Member</span>
                                <?php } else { ?>
                                    <span class="badge text-bg-secondary px-3 py-2">Basic Member</span>
                                <?php } ?>
                            </div>

                            <hr>

                            <div class="text-start small">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">ID Pelanggan:</span>
                                    <span class="fw-medium">#<?= $profil['id']; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Nomor Telepon:</span>
                                    <span class="fw-medium"><?= $profil['telepon']; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Email:</span>
                                    <span class="fw-medium"><?= isset($profil['email']) ? $profil['email'] : '-'; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-0">
                                    <span class="text-muted">Level Keanggotaan:</span>
                                    <span class="fw-medium"><?= $profil['level_member']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border rounded-3 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="fw-semibold fs-6 mb-2">Hak & Benefit Member</h3>
                            <p class="text-muted small mb-3">Keuntungan aktif untuk level <strong><?= $profil['level_member']; ?></strong>:</p>

                            <?php if ($profil['level_member'] == 'VIP') { ?>
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-2 text-success fw-medium">&check; Potongan harga sewa 25%</li>
                                    <li class="mb-2 text-success fw-medium">&check; Gratis sewa alat olahraga</li>
                                    <li class="mb-0 text-success fw-medium">&check; Booking prioritas 24/7</li>
                                </ul>
                            <?php } else if ($profil['level_member'] == 'Gold') { ?>
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-2 text-primary fw-medium">&check; Potongan harga sewa 15%</li>
                                    <li class="mb-2 text-primary fw-medium">&check; Diskon 10% sewa alat</li>
                                    <li class="mb-0 text-primary fw-medium">&check; Booking prioritas weekend</li>
                                </ul>
                            <?php } else { ?>
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-2 text-muted">&bull; Akses booking standar</li>
                                    <li class="mb-2 text-muted">&bull; Harga sewa normal</li>
                                    <li class="mb-0 text-muted">&bull; Diskon 5% perlengkapan</li>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>

        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
