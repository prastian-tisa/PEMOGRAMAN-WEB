<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Teks biasa dari form login

    // Cari user berdasarkan username
    $query  = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Perbandingan langsung tanpa fungsi password_verify()
        if ($password == $row['password']) {
            // Set session login jika password cocok
            $_SESSION['login']        = true;
            $_SESSION['username']     = $row['username'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];

            header("Location: dashboard.php");
            exit;
        }
    }
    
    // Jika gagal, kembali ke login dengan pesan error
    header("Location: index.php?pesan=gagal");
    exit;
}
?>