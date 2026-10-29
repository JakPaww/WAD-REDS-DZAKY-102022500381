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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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
                        <form action="{{ route('pelanggan.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label fw-medium small">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-sm rounded-1" required placeholder="Masukkan nama" name="nama">
                                </div>

                                <div class="col-6">
                                    <label class="form-label fw-medium small">Nomor Telepon</label>
                                    <input type="text" class="form-control form-control-sm rounded-1" required placeholder="0812xxxxxxxx" name="telepon">
                                </div>

                                <div class="col-6">
                                    <label class="form-label fw-medium small">Email</label>
                                    <input type="email" class="form-control form-control-sm rounded-1"required placeholder="nama@gmail.com" name="email">
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

                            <div class="modal-footer border-0 mt-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-1"
                                        data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-sm rounded-1 btn-dark">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border rounded-3 shadow-sm">
            <div class="card-body px-4 pt-4">

                <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h2 class="fw-semibold fs-6 mb-0">Daftar Pelanggan</h2>
                        <p class="text-muted small mb-0">
                            Total: {{ $totalPelanggan }} pelanggan tersimpan di database.
                        </p>
                    </div>

                    <form action="{{ route('pelanggan.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                        <div class="d-flex position-relative">
                            <svg width="14" height="14" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 class="position-absolute text-muted"
                                 style="top: 50%; left: 10px; transform: translateY(-50%);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                            </svg>
                            <input type="text" name="cari" class="form-control form-control-sm rounded-2 ps-4" placeholder="Cari pelanggan..."value="{{ request('cari') }}">
                        </div>

                        <select name="status" class="form-select form-select-sm rounded-2">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="Tidak Aktif" {{ request('status') === 'Tidak Aktif' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>

                        <button type="submit" class="btn btn-sm btn-dark">Cari</button>

                        @if (request()->hasAny(['cari', 'status', 'level_member']))
                            <a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="d-flex gap-1 mb-3 flex-wrap">
                    <a href="{{ route('pelanggan.index', array_filter(['cari' => request('cari'),'status' => request('status')], fn($value) => $value !== null && $value !== '')) }}"class="btn btn-sm btn-outline-secondary rounded-2 {{ !request('level_member') ? 'active' : '' }}">
                        Semua
                    </a>

                    @foreach (['Basic', 'Gold', 'VIP'] as $level)
                        <a href="{{ route('pelanggan.index', array_merge( array_filter(['cari' => request('cari'),'status' => request('status')], fn($value) => $value !== null && $value !== ''),['level_member' => $level])) }}"class="btn btn-sm btn-outline-secondary rounded-2 {{ request('level_member') === $level ? 'active' : '' }}">
                            {{ $level }}
                        </a>
                    @endforeach
                </div>

                <div class="table-responsive">
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
                            @forelse ($pelanggans as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $data->nama }}</td>

                                    <td>
                                        {{ $data->telepon }}<br>
                                        <span class="text-muted small">{{ $data->email }}</span>
                                    </td>

                                    <td>{{ $data->level_member }}</td>

                                    <td>
                                        <form action="{{ route('pelanggan.toggleStatus', $data->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="btn btn-sm {{ $data->status === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                                {{ $data->status }}
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        <button type="button"class="btn btn-warning btn-sm rounded-1" data-bs-toggle="modal" data-bs-target="#ModalUbah" data-id="{{ $data->id }}" data-nama="{{ $data->nama }}" data-telepon="{{ $data->telepon }}"  data-email="{{ $data->email }}" data-level="{{ $data->level_member }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('pelanggan.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pelanggan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm rounded-1">
                                                Hapus
                                            </button>
                                        </form>

                                        <a href="{{ route('pelanggan.show', $data->id) }}"
                                           class="btn btn-outline-dark btn-sm rounded-1">
                                            Profil
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Data pelanggan tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalUbah" tabindex="-1"
             aria-labelledby="ModalUbahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-3">
                    <div class="modal-header border-bottom pt-4">
                        <div>
                            <h2 class="modal-title fw-bold fs-5" id="ModalUbahLabel">Edit Pelanggan</h2>
                            <p class="text-muted small mb-0">Perbarui informasi pelanggan di bawah ini.</p>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form id="formEdit" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" id="editId">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium small">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-sm rounded-1"
                                           required name="nama" id="editNama">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium small">Nomor Telepon</label>
                                    <input type="text" class="form-control form-control-sm rounded-1"
                                           required name="telepon" id="editTelepon">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium small">Email</label>
                                    <input type="email" class="form-control form-control-sm rounded-1"
                                           name="email" id="editEmail">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium small">Level Member</label>
                                    <select class="form-select form-select-sm rounded-1"
                                            required name="level_member" id="editLevel">
                                        <option value="Basic">Basic</option>
                                        <option value="Gold">Gold</option>
                                        <option value="VIP">VIP</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-1"
                                        data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-dark btn-sm rounded-1">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
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

            document.getElementById('formEdit').action = "{{ url('/pelanggan') }}/" + button.dataset.id;
        });
    </script>
</body>

</html>
