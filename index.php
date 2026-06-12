<?php
session_start();
// Jika sudah login, otomatis dialihkan ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Event Organisasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(135deg, #3498db, #8e44ad);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card login-card animate__animated animate__zoomIn">
                <div class="card-body p-4">
                    <h3 class="text-center fw-bold mb-4 text-primary">SISTEM LOGIN</h3>
                    
                    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
                        <div class="alert alert-danger text-center animate__animated animate__shakeX" role="alert">
                            Username / Password Salah!
                        </div>
                    <?php endif; ?>

                    <form action="proses_login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>