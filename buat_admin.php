<?php
include 'koneksi.php';

$username = 'admin';
$password_teks_biasa = 'admin123'; // Tanpa password_hash()
$nama_lengkap = 'Administrator Organisasi';

// Hapus akun admin lama agar tidak duplikat
mysqli_query($koneksi, "DELETE FROM users WHERE username='$username'");

// Masukkan data admin baru dengan password teks murni
$query = "INSERT INTO users (username, password, nama_lengkap) VALUES ('$username', '$password_teks_biasa', '$nama_lengkap')";

if (mysqli_query($koneksi, $query)) {
    echo "<h3>Akun Admin (Tanpa Hash) Berhasil Dibuat!</h3>";
    echo "Username: <b>admin</b><br>";
    echo "Password: <b>admin123</b><br><br>";
    echo "<a href='index.php'>Klik di sini untuk mencoba Login</a>";
} else {
    echo "Gagal membuat akun: " . mysqli_error($koneksi);
}
?>