<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'siswa' && $_SESSION['role'] != 'guru')) {
    header("Location: auth/login.php");
    exit();
}
include 'db/db_connect.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Pembelajaran Berpikir Komputasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainn.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="flex-grow-1">
        <section class="hero bg-white py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="display-4 fw-bold mb-4" style="background: linear-gradient(45deg, #11998e, #38ef7d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">BERPIKIR KOMPUTASIONAL</h2>
                        <p class="lead mb-4">Pelajari konsep dasar berpikir komputasional melalui materi interaktif dan latihan menarik.</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="materi.php" class="btn btn-lg px-4 py-2" style="background: linear-gradient(45deg, #11998e, #38ef7d); border: none; color: white;">Mulai Belajar</a>
                            <?php if ($_SESSION['role'] == 'guru'): ?>
                                <a href="guru/dashboard_guru.php" class="btn btn-lg btn-outline-success px-4 py-2">Kembali ke Dashboard Guru</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/dHHrodwkYrY?si=Tv0eE-BA0g19c-bW" title="Berpikir Komputasional" allowfullscreen class="rounded shadow"></iframe>
                        </div>
                        <p class="text-muted mt-2 small">Video pengantar tentang Berpikir Komputasional</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="topics-overview py-5 bg-light">
            <div class="container">
                <h3 class="text-center mb-5">Topik Utama</h3>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Dekomposisi</h5>
                                <p class="card-text">Memecah masalah besar menjadi bagian kecil yang lebih mudah dikelola.</p>
                                <a href="dekomposisi.php" class="btn w-100" style="background: linear-gradient(45deg, #11998e, #38ef7d); border: none; color: white;">Pelajari</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Pola</h5>
                                <p class="card-text">Mengenali kemiripan atau kesamaan dalam data atau proses.</p>
                                <a href="pola.php" class="btn w-100" style="background: linear-gradient(45deg, #11998e, #38ef7d); border: none; color: white;">Pelajari</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Abstraksi</h5>
                                <p class="card-text">Menyaring informasi yang penting dan mengabaikan yang tidak relevan.</p>
                                <a href="abstraksi.php" class="btn w-100" style="background: linear-gradient(45deg, #11998e, #38ef7d); border: none; color: white;">Pelajari</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Algoritma</h5>
                                <p class="card-text">Urutan langkah-langkah untuk menyelesaikan masalah secara terstruktur.</p>
                                <a href="algoritma.php" class="btn w-100" style="background: linear-gradient(45deg, #11998e, #38ef7d); border: none; color: white;">Pelajari</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scriptt.js"></script>
</body>
</html>
