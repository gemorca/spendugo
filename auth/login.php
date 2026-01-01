<?php
session_start();
include '../db/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT nama, role, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: ../admin/dashboard_admin.php");
            } elseif ($user['role'] == 'guru') {
                header("Location: ../guru/dashboard_guru.php");
            } elseif ($user['role'] == 'siswa') {
                header("Location: ../index.php");
            }
            exit();
        } else {
            if ($user['role'] == 'guru' || $user['role'] == 'siswa') {
                $error = "Password yang anda masukkan salah";
            } else {
                $error = "Username dan password salah";
            }
        }
    } else {
        $error = "username tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Media Pembelajaran Berpikir Komputasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/mainn.css">
</head>
<body class="login-page">
    <main>
        <section class="hero-login">
            <div class="login-container">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-user-circle login-icon"></i>
                        <h2>Login</h2>
                        <p>Masuk ke akun Anda</p>
                    </div>
                    <?php if (isset($error)) echo "<div class='alert alert-danger alert-custom'>$error</div>"; ?>
                    <form method="POST" class="login-form">
                        <div class="input-group-custom">
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" id="username" name="username" class="form-control-custom" placeholder="Username" required>
                            </div>
                        </div>

                        <div class="input-group-custom">
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" id="password" name="password" class="form-control-custom" placeholder="Password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scriptt.js"></script>
</body>
</html>
