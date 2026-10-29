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

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $level_member = $_POST['level_member'];

    $insert = mysqli_query($koneksi, "INSERT INTO pelanggan 
        (nama, telepon, email, level_member)
        VALUES 
        ('$nama', '$telepon', '$email', '$level_member')
    ");

    if ($insert) {
        header("Location: progres1.php");
        exit;
    } else {
        echo "Data gagal ditambahkan: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['simpan_profil'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $level_member = $_POST['level_member'];
    $update = mysqli_query($koneksi, "UPDATE pelanggan SET nama = '$nama', telepon = '$telepon', email = '$email', level_member = '$level_member' WHERE id = '$id'");

    if ($update) {
        header("Location: progres1.php");
        exit;
    } else {
        echo "Data gagal diperbarui: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['ubah_status'])) {
    $id = $_POST['id'];
    $update = mysqli_query($koneksi, "UPDATE pelanggan SET status = CASE WHEN status = 'Aktif' THEN 'Tidak Aktif' ELSE 'Aktif' END WHERE id = '$id'");

    if ($update) {
        header("Location: progres1.php");
        exit;
    } else {
        echo "Status gagal diperbarui: " . mysqli_error($koneksi);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $delete = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id = '$id'");
    
    if ($delete) {
        header("Location: progres1.php");
        exit;
    } else {
        echo "Data gagal dihapus: " . mysqli_error($koneksi);
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
    <title>Lapangan Olahraga</title>
</head>

<body class="bg-light py-4">
    <header>
        <h1 class="text-center fw-bold fs-4 py-4">Pengelolaan Data Pelanggan</h1>
    </header>
    <div class="container">
        <button class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#Modal">
            Tambah Pelanggan
        </button>
        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-3">
                    <div class="modal-header border-bottom pt-4">
                        <div>
                            <h2 class="modal-title fw-bold fs-5" id="ModalLabel">Tambah Pelanggan</h2>
                            <p class="text-muted small mb-0">Perbarui informasi pelanggan di bawah ini.</p>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label fw-medium small">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-sm rounded-1" required
                                        placeholder="Masukkan nama" name="nama">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-medium small">Nomor Telepon</label>
                                    <input type="text" class="form-control form-control-sm rounded-1" required
                                        placeholder="0812xxxxxxxx" name="telepon">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-medium small">Email</label>
                                    <input type="email" class="form-control form-control-sm rounded-1" required
                                        placeholder="nama@gmail.com" name="email">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-medium small">Level Member</label>
                                    <select class="form-select form-select-sm rounded-1" required name="level_member">
                                        <option value="Basic">Basic</option>
                                        <option value="Gold">Gold</option>
                                        <option value="VIP">VIP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" id="BtnBatal" class="btn btn-outline-secondary btn-sm rounded-1" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="simpan" class="btn btn-sm rounded-1 btn-dark">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card border rounded-3 shadow-sm">
            <div class="card-body px-4 pt-4">
                <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h2 class="fw-semibold fs-6 mb-0">Daftar Pelanggan</h2>
                        <p class="text-muted small mb-0">Total: <?= $daftarPelanggan ?> pelanggan tersimpan di database.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="d-flex  position-relative">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                class="position-absolute text-muted" style="top: 50%; left: 10px; transform: translateY(-50%);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                            </svg>
                            <input type="text" class="form-control form-control-sm rounded-2 ps-4 w-100" placeholder="Cari pelanggan...">
                        </div>
                        <select class="form-select form-select-sm w-50 rounded-2">
                            <option value="semua">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class=" gap-1 mb-3">
                    <button class="btn btn-sm btn-outline-secondary rounded-2 active">Semua</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-2">Basic</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-2">Gold</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-2">VIP</button>
                </div>
                <table class="table table-md align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Kontak</th>
                            <th>Level Member</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($select)) { ?>
                            <tr>
                                <td>
                                    <?= $no++; ?>
                                </td>
                                <td>
                                    <?= $data['nama']; ?>
                                </td>
                                <td>
                                    <?= $data['telepon']; ?><br>
                                    <span class="text-muted small">
                                        <?= $data['email']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $data['level_member']; ?>
                                </td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id'], ENT_QUOTES); ?>">
                                        <button type="submit" name="ubah_status" class="btn btn-sm <?= $data['status'] === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary'; ?>">
                                            <?= htmlspecialchars($data['status']); ?>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm rounded-1" data-bs-toggle="modal" data-bs-target="#ModalUbah" data-id="<?= htmlspecialchars($data['id'], ENT_QUOTES); ?>" data-nama="<?= htmlspecialchars($data['nama'], ENT_QUOTES); ?>" data-telepon="<?= htmlspecialchars($data['telepon'], ENT_QUOTES); ?>" data-email="<?= htmlspecialchars($data['email'], ENT_QUOTES); ?>" data-level="<?= htmlspecialchars($data['level_member'], ENT_QUOTES); ?>">
                                        Edit
                                    </button>
                                    <a href="?hapus=<?= rawurlencode($data['id']); ?>" class="btn btn-danger btn-sm rounded-1" onclick="return confirm('Hapus pelanggan ini?')">
                                        Hapus
                                    </a>
                                    <a href="progres3.php?id=<?= rawurlencode($data['id']); ?>" class="btn btn-outline-dark btn-sm rounded-1">
                                        Profil
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="ModalUbah" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                    <div class="modal-content rounded-3">
                        <div class="modal-header border-bottom pt-4">
                            <div>
                                <h2 class="modal-title fw-bold fs-5" id="ModalLabel">Edit Pelanggan</h2>
                                <p class="text-muted small mb-0">Perbarui informasi pelanggan di bawah ini.</p>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <input type="hidden" name="id" id="editId">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-sm rounded-1" required name="nama" id="editNama">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">Nomor Telepon</label>
                                        <input type="text" class="form-control form-control-sm rounded-1" required name="telepon" id="editTelepon">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">Email</label>
                                        <input type="email" class="form-control form-control-sm rounded-1" name="email" id="editEmail">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium small">Level Member</label>
                                        <select class="form-select form-select-sm rounded-1" required name="level_member" id="editLevel">
                                            <option value="Basic">Basic</option>
                                            <option value="Gold">Gold</option>
                                            <option value="VIP">VIP</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <button type="button" id="BtnBatal" class="btn btn-outline-secondary btn-sm rounded-1" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="simpan_profil" class="btn btn-dark btn-sm rounded-1">Simpan Perubahan</button>
                                </div>
                            </form>
                    </div>
                </div>
        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('ModalUbah').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('editId').value = button.dataset.id;
            document.getElementById('editNama').value = button.dataset.nama;
            document.getElementById('editTelepon').value = button.dataset.telepon;
            document.getElementById('editEmail').value = button.dataset.email;
            document.getElementById('editLevel').value = button.dataset.level;
        });
    </script>
</body>

</html>