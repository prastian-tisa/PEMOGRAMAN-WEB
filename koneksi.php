<?php
$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "organisasi"
);

if(!$koneksi){
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>