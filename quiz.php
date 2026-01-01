<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
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
    <title>Quiz - Media Pembelajaran Berpikir Komputasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainn.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main>
        <section class="quiz-section">
            <h2>Quiz / Latihan</h2>
            <p>Jawab pertanyaan berikut untuk menguji pemahaman Anda:</p>

            <div id="quiz-message" style="display: none;"></div>

            <button id="start-quiz" class="btn">Mulai Quiz</button>

            <div id="quiz-container" style="display: none;">
                <div id="timer-display" class="timer">Waktu tersisa: <span id="timer-count">10</span> detik</div>
                <div id="question-display">
                    <!-- Soal akan ditampilkan di sini satu per satu -->
                </div>
                <div id="feedback" style="display: none;"></div>
                <button id="check-answer" class="btn" style="display: none;">Cek Jawaban</button>
            </div>

            <div id="results" style="display: none;">
                <h3>Hasil Quiz</h3>
                <p id="score"></p>
                <p id="feedback"></p>
                <button id="save-result" class="btn">Simpan Hasil</button>
                <div id="save-status" class="mt-2" style="display: none;"></div>
                <div class="text-center">
                    <button id="retry-quiz" class="btn" style="display: none;">Coba Lagi</button>
                </div>
            </div>
        </section>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scriptt.js"></script>
</body>
</html>
