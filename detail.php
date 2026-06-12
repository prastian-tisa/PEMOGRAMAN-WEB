<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_array(
mysqli_query($koneksi,
"SELECT * FROM event_organisasi WHERE id='$id'")
);
?>

<h2>Detail Event</h2>

<p>Nama Event : <?= $data['nama_event'] ?></p>
<p>Tanggal : <?= $data['tanggal'] ?></p>
<p>Lokasi : <?= $data['lokasi'] ?></p>
<p>Ketua Panitia : <?= $data['ketua_panitia'] ?></p>

<img src="file/<?= $data['poster'] ?>" width="250">