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
    <title>Materi - Media Pembelajaran Berpikir Komputasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainn.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <section class="materi-overview">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center mb-4">Materi Pembelajaran</h2>
                        <p class="text-center lead mb-5">Pilih topik yang ingin Anda pelajari:</p>

                        <!-- Search Bar -->
                        <div class="row justify-content-center mb-5">
                            <div class="col-md-6">
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-lg rounded-pill px-4" placeholder="Cari materi..." aria-label="Search topics" style="padding-right: 50px;">
                                    <div class="search-results position-absolute w-100 mt-1 bg-white border rounded shadow-sm d-none" id="search-results" style="z-index: 1000;"></div>
                                </div>
                            </div>
                        </div>

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
                                        <p class="card-text">Urutan langkah-langkah untuk menyelesaikan masalah.</p>
                                        <a href="algoritma.php" class="btn w-100" style="background: linear-gradient(45deg, #11998e, #38ef7d); border: none; color: white;">Pelajari</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scriptt.js"></script>
</body>
</html>
