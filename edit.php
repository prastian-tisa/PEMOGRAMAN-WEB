<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_array(
    mysqli_query($koneksi,
    "SELECT * FROM event_organisasi WHERE id='$id'")
);

if(isset($_POST['update'])){

    $nama_event = $_POST['nama_event'];
    $tanggal = $_POST['tanggal'];
    $lokasi = $_POST['lokasi'];
    $ketua_panitia = $_POST['ketua_panitia'];

    if($_FILES['poster']['name'] != ""){

        $poster = $_FILES['poster']['name'];

        move_uploaded_file(
            $_FILES['poster']['tmp_name'],
            "file/".$poster
        );

        mysqli_query($koneksi,
        "UPDATE event_organisasi SET
        nama_event='$nama_event',
        tanggal='$tanggal',
        lokasi='$lokasi',
        ketua_panitia='$ketua_panitia',
        poster='$poster'
        WHERE id='$id'");

    } else {

        mysqli_query($koneksi,
        "UPDATE event_organisasi SET
        nama_event='$nama_event',
        tanggal='$tanggal',
        lokasi='$lokasi',
        ketua_panitia='$ketua_panitia'
        WHERE id='$id'");
    }

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Edit Event Organisasi</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama Event</label>
            <input type="text"
                   name="nama_event"
                   class="form-control"
                   value="<?= $data['nama_event'] ?>">
        </div>

        <div class="mb-3">
            <label>Tanggal Event</label>
            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="<?= $data['tanggal'] ?>">
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text"
                   name="lokasi"
                   class="form-control"
                   value="<?= $data['lokasi'] ?>">
        </div>

        <div class="mb-3">
            <label>Ketua Panitia</label>
            <input type="text"
                   name="ketua_panitia"
                   class="form-control"
                   value="<?= $data['ketua_panitia'] ?>">
        </div>

        <div class="mb-3">
            <label>Poster Saat Ini</label><br>

            <img src="file/<?= $data['poster'] ?>"
                 width="150">
        </div>

        <div class="mb-3">
            <label>Ganti Poster</label>
            <input type="file"
                   name="poster"
                   class="form-control">
        </div>

        <button type="submit"
                name="update"
                class="btn btn-warning">
            Update Data
        </button>

        <a href="index.php"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>