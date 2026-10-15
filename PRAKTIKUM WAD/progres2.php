<?php

$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_pelanggan"
);

if (!$koneksi ) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['ubah_level'])) {
    $id = $_POST['id'];
    $level = $_POST['level'];

    $update = mysqli_query($koneksi, "UPDATE pelanggan SET level_member = '$level' WHERE id = '$id'");

    if ($update) {
        header("Location: level_member.php");
        exit;
    } else {
        echo "Gagal mengubah level: " . mysqli_error($koneksi);
    }
}

$select = mysqli_query($koneksi, "SELECT * FROM pelanggan");
$daftarPelanggan = mysqli_num_rows($select);
$no = 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Benefit & Level Member</title>
</head>

<body class="bg-light py-4">

    <header class="container mb-4">
        <h1 class="text-center fw-bold fs-4 py-3">Benefit & Pengelolaan Level Member</h1>
    </header>

    <div class="container">

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100 border rounded-3 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h2 class="fw-bold fs-4 mb-3">Basic</h2>
                        <ul class="list-unstyled text-start small mb-0">
                            <li class="mb-2">&bull; Akses Booking Standar</li>
                            <li class="mb-2">&bull; Harga Sewa Normal</li>
                            <li class="mb-2">&bull; Diskon 5% Pembelian Perlengkapan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border border-warning rounded-3 shadow-sm bg-warning-subtle">
                    <div class="card-body p-4 text-center">
                        <h2 class="fw-bold fs-4 mb-3">Gold</h2>
                        <ul class="list-unstyled text-start small mb-0">
                            <li class="mb-2">&bull; Akses Booking Prioritas Weekend</li>
                            <li class="mb-2">&bull; Harga Sewa Lebih Murah 15%</li>
                            <li class="mb-2">&bull; Diskon 10% Pembelian Perlengkapan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border border-dark rounded-3 shadow-sm bg-dark text-white">
                    <div class="card-body p-4 text-center">
                        <h2 class="fw-bold fs-4 mb-3 text-white">VIP</h2>
                        <ul class="list-unstyled text-start small mb-0">
                            <li class="mb-2">&bull; Akses Booking Prioritas 24/7</li>
                            <li class="mb-2">&bull; Harga Sewa Lebih Murah 25%</li>
                            <li class="mb-2">&bull; Gratis Sewa Perlengkapan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border rounded-3 shadow-sm">
            <div class="card-body px-4 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="fw-semibold fs-6 mb-0">Daftar Pelanggan & Level Member</h2>
                        <p class="text-muted small mb-0">Total: <?= $daftarPelanggan ?> pelanggan tersimpan di database.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-md align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Kontak</th>
                                <th>Level Member</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            while ($data = mysqli_fetch_assoc($select)) { 
                                
                                $emailPelanggan = isset($data['email']) ? $data['email'] : '-';
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $data['nama']; ?></td>
                                    <td>
                                        <?= $data['telepon']; ?><br>
                                        <span class="text-muted small"><?= $emailPelanggan; ?></span>
                                    </td>
                                    <td>
                                        <?php if ($data['level_member'] == 'VIP') { ?>
                                            <span class="badge text-bg-dark rounded-2 w-25  py-2">VIP</span>
                                        <?php } else if ($data['level_member'] == 'Gold') { ?>
                                            <span class="badge text-bg-warning rounded-2  w-25 py-2" >Gold</span>
                                        <?php } else { ?>
                                            <span class="badge text-bg-secondary rounded-2  w-25 py-2" >Basic</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm rounded-1" data-bs-toggle="modal" data-bs-target="#ModalUbah" data-id="<?= $data['id']; ?>" data-nama="<?= htmlspecialchars($data['nama']); ?>" data-level="<?= $data['level_member']; ?>"onclick="isiModal(this)">
                                            Ubah Level
                                        </button>
                                        <a href="progres3.php?id=<?= $data['id']; ?>" class="btn btn-outline-dark btn-sm rounded-1">
                                            Profil
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="ModalUbah" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-3">
                <form method="POST">
                    <div class="modal-header border-bottom pt-4">
                        <div>
                            <h2 class="modal-title fw-bold fs-5" id="ModalLabel">Ubah Level Member</h2>
                            <p class="text-muted small mb-0">Perbarui tingkatan membership pelanggan.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modalId">
                        <div class="mb-3">
                            <label class="form-label fw-medium small">Nama Pelanggan</label>
                            <input type="text" class="form-control form-control-sm rounded-1" id="modalNama" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium small">Pilih Level Member</label>
                            <select class="form-select form-select-sm rounded-1" required name="level" id="modalLevel">
                                <option value="Basic">Basic</option>
                                <option value="Gold">Gold</option>
                                <option value="VIP">VIP</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-1" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="ubah_level" class="btn btn-sm rounded-1 btn-dark">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>
