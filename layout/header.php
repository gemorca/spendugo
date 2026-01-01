<?php
session_start();
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center">
                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                    <img src="logo/ung.png" alt="Logo UNG" class="me-2" style="height: 45px; width: auto;">
                    <img src="logo/spenduGo.png" alt="Logo SpenduGo" style="height: 45px; width: auto;">
                </a>
            </div>
            <div class="mx-auto text-center brand-title">
                <h1 class="h4 mb-0 fw-bold" style="background: linear-gradient(45deg, #11998e, #38ef7d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Berpikir Komputasional</h1>
                <p class="small text-muted mb-0" style="color: #764ba2; font-weight: 500;">Media Pembelajaran Interaktif</p>
            </div>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <div class="user-greeting">
                            <i class="fas fa-user-circle me-2"></i>
                            <span class="fw-semibold">Halo, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="materi.php">Materi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dekomposisi.php">Dekomposisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pola.php">Pola</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="abstraksi.php">Abstraksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="algoritma.php">Algoritma</a>
                    </li>
                    <?php if ($_SESSION['role'] != 'guru'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="quiz.php">Quiz</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang</a>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'siswa'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
