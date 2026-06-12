<?php
session_start();
// PROTEKSI: Jika belum login, tendang balik ke halaman login (index.php)
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM event_organisasi");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Data Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .signature-pad { border: 2px dashed #ccc; border-radius: 5px; cursor: crosshair; background-color: #fafafa; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#"><i class="bi bi-shield-lock"></i> Org-Systems</a>
    <div class="navbar-nav ms-auto align-items-center">
        <span class="nav-link text-light me-3">Selamat Datang, <strong><?= $_SESSION['nama_lengkap']; ?></strong></span>
        <a class="btn btn-danger btn-sm text-white fw-bold" href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right"></i> Keluar</a>
    </div>
  </div>
</nav>

<div class="container mt-4 animate__animated animate__fadeIn">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-calendar-event"></i> Data Event Organisasi</h4>
            <button type="button" class="btn btn-light fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle-fill"></i> Tambah Event
            </button>
        </div>
        <div class="card-body">
            
            <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Data event telah diperbarui/ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <audio autoplay><source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-600.wav" type="audio/wav"></audio>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="tabelEvent" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Ketua Panitia</th>
                            <th>Poster</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($data = mysqli_fetch_array($query)){
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold"><?= $data['nama_event'] ?></td>
                            <td><i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($data['tanggal'])) ?></td>
                            <td><i class="bi bi-geo-alt-fill text-danger"></i> <?= $data['lokasi'] ?></td>
                            <td><?= $data['ketua_panitia'] ?></td>
                            <td>
                                <?php if($data['poster'] != ""): ?>
                                    <img src="file/<?= $data['poster'] ?>" width="60" class="img-thumbnail shadow-sm">
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="detail.php?id=<?= $data['id'] ?>" class="btn btn-info btn-sm text-white"><i class="bi bi-eye"></i> Detail</a>
                                <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-warning btn-sm text-white"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="hapus.php?id=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-plus-lg"></i> Form Tambah Event Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data" id="formEvent">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Event</label>
                            <input type="text" name="nama_event" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Event</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Ketua Panitia</label>
                            <input type="text" name="ketua_panitia" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Dokumen/Poster (Bisa pilih banyak)</label>
                        <input type="file" name="poster[]" class="form-control" multiple required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanda Tangan Digital Ketua Panitia</label><br>
                        <canvas id="canvasTTD" width="400" height="150" class="signature-pad w-100"></canvas>
                        <br>
                        <button type="button" class="btn btn-sm btn-secondary mt-1" id="hapusTTD">Bersihkan TTD</button>
                        <input type="hidden" name="ttd_image" id="ttd_image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-success"><i class="bi bi-save"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabelEvent').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm', text: '<i class="bi bi-file-earmark-excel"></i> Excel' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm', text: '<i class="bi bi-file-earmark-pdf"></i> PDF' },
            { extend: 'print', className: 'btn btn-dark btn-sm', text: '<i class="bi bi-printer"></i> Cetak' }
        ]
    });

    // Canvas Signature Script
    const canvas = document.getElementById('canvasTTD');
    const ctx = canvas.getContext('2d');
    let drawing = false;
    ctx.strokeStyle = "#000000"; ctx.lineWidth = 3;

    function getMousePos(c, e) {
        var rect = c.getBoundingClientRect();
        return { x: (e.clientX || e.touches[0].clientX) - rect.left, y: (e.clientY || e.touches[0].clientY) - rect.top };
    }
    canvas.addEventListener('mousedown', function(e) { drawing = true; var p = getMousePos(canvas, e); ctx.beginPath(); ctx.moveTo(p.x, p.y); });
    canvas.addEventListener('mousemove', function(e) { if (!drawing) return; var p = getMousePos(canvas, e); ctx.lineTo(p.x, p.y); ctx.stroke(); });
    canvas.addEventListener('mouseup', function() { drawing = false; });
    
    canvas.addEventListener('touchstart', function(e) { drawing = true; var p = getMousePos(canvas, e); ctx.beginPath(); ctx.moveTo(p.x, p.y); e.preventDefault(); });
    canvas.addEventListener('touchmove', function(e) { if (!drawing) return; var p = getMousePos(canvas, e); ctx.lineTo(p.x, p.y); ctx.stroke(); e.preventDefault(); });
    canvas.addEventListener('touchend', function() { drawing = false; });

    $('#hapusTTD').click(function() { ctx.clearRect(0, 0, canvas.width, canvas.height); $('#ttd_image').val(''); });
    $('#formEvent').submit(function() {
        const blank = document.createElement('canvas'); blank.width = canvas.width; blank.height = canvas.height;
        if (canvas.toDataURL() !== blank.toDataURL()) { $('#ttd_image').val(canvas.toDataURL('image/png')); }
    });
});
</script>
</body>
</html>