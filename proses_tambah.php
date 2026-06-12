<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $nama_event = $_POST['nama_event'];
    $tanggal = $_POST['tanggal'];
    $lokasi = $_POST['lokasi'];
    $ketua_panitia = $_POST['ketua_panitia'];
    $nama_file_poster = "";

    // 1. PROSES MULTIPLE FILE UPLOAD (Fitur 1)
    if(isset($_FILES['poster'])){
        $total_files = count($_FILES['poster']['name']);
        
        // Looping semua file yang di-upload oleh user
        for($i = 0; $i < $total_files; $i++) {
            $filename = $_FILES['poster']['name'][$i];
            $tmp_name = $_FILES['poster']['tmp_name'][$i];
            
            if($filename != ""){
                // Beri nama unik agar file tidak saling menimpa
                $unik_name = time() . "_" . $filename;
                
                // Pindahkan file ke folder "file"
                if(move_uploaded_file($tmp_name, "file/" . $unik_name)){
                    // File indeks pertama [0] kita jadikan sebagai poster utama di database
                    if($i == 0){
                        $nama_file_poster = $unik_name;
                    }
                }
            }
        }
    }

    // 2. PROSES BASE64 CANVAS TTD (Fitur 4)
    $nama_file_ttd = "";
    if(!empty($_POST['ttd_image'])){
        $img_data = $_POST['ttd_image'];
        // Pecah string Base64 DataURL
        $image_parts = explode(";base64,", $img_data);
        $image_base64 = base64_decode($image_parts[1]);
        
        // Buat nama file TTD unik
        $nama_file_ttd = "ttd_" . time() . ".png";
        $file_path = "file/" . $nama_file_ttd;
        
        // Simpan konversi data base64 menjadi file fisik .png
        file_put_contents($file_path, $image_base64);
    }

    // 3. INSERT DATA KE DATABASE
    $query = "INSERT INTO event_organisasi (nama_event, tanggal, lokasi, ketua_panitia, poster, ttd_panitia) 
              VALUES ('$nama_event', '$tanggal', '$lokasi', '$ketua_panitia', '$nama_file_poster', '$nama_file_ttd')";
              
    if(mysqli_query($koneksi, $query)){
        header("location:index.php?status=sukses");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>