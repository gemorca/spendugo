<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

include '../db/db_connect.php';

// Handle CRUD operations
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'create') {
            $nama = trim($_POST['nama']);
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $role = 'siswa';

            // Check if username already exists
            $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $message = "Username sudah digunakan!";
                $messageType = "danger";
            } else {
                $stmt = $db->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nama, $username, $password, $role);
                if ($stmt->execute()) {
                    $message = "Data siswa berhasil ditambahkan!";
                    $messageType = "success";
                } else {
                    $message = "Gagal menambahkan data siswa!";
                    $messageType = "danger";
                }
            }
        } elseif ($action == 'update') {
            $id = $_POST['id'];
            $nama = trim($_POST['nama']);
            $username = trim($_POST['username']);

            // Check if username already exists (excluding current user)
            $stmt = $db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->bind_param("si", $username, $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $message = "Username sudah digunakan!";
                $messageType = "danger";
            } else {
                if (!empty($_POST['password'])) {
                    $password = $_POST['password'];
                    $stmt = $db->prepare("UPDATE users SET nama = ?, username = ?, password = ? WHERE id = ? AND role = 'siswa'");
                    $stmt->bind_param("sssi", $nama, $username, $password, $id);
                } else {
                    $stmt = $db->prepare("UPDATE users SET nama = ?, username = ? WHERE id = ? AND role = 'siswa'");
                    $stmt->bind_param("ssi", $nama, $username, $id);
                }

                if ($stmt->execute()) {
                    $message = "Data siswa berhasil diupdate!";
                    $messageType = "success";
                } else {
                    $message = "Gagal mengupdate data siswa!";
                    $messageType = "danger";
                }
            }
        } elseif ($action == 'delete') {
            $id = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role = 'siswa'");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Data siswa berhasil dihapus!";
                $messageType = "success";
            } else {
                $message = "Gagal menghapus data siswa!";
                $messageType = "danger";
            }
        } elseif ($action == 'delete_quiz') {
            $id = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM quiz_results WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Hasil quiz berhasil dihapus!";
                $messageType = "success";
            } else {
                $message = "Gagal menghapus hasil quiz!";
                $messageType = "danger";
            }
        }
    }
}

// Get all students
$result = $db->query("SELECT id, nama, username FROM users WHERE role = 'siswa' ORDER BY nama");
$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

// Get all quiz results
$result = $db->query("SELECT qr.id, u.nama, qr.score, qr.total_questions, qr.percentage, qr.completed_at FROM quiz_results qr JOIN users u ON qr.student_id = u.id ORDER BY qr.completed_at DESC");
$quiz_results = [];
while ($row = $result->fetch_assoc()) {
    $quiz_results[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru Dashboard - Media Pembelajaran Berpikir Komputasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/mainn.css">
</head>
<body>
    <main>
        <section class="hero">
            <div class="container">
                <h2>Guru Dashboard</h2>
                <p>Selamat datang, <?php echo $_SESSION['nama']; ?>! Kelola data siswa dan quiz di sini.</p>

                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Data Siswa</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </button>
                </div>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th class="d-none d-md-table-cell">Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data siswa.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($student['nama']); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($student['username']); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning me-2" onclick="editStudent(<?php echo $student['id']; ?>, '<?php echo addslashes($student['nama']); ?>', '<?php echo addslashes($student['username']); ?>')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteStudent(<?php echo $student['id']; ?>, '<?php echo addslashes($student['nama']); ?>')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <h3>Hasil Quiz Siswa</h3>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Skor</th>
                                <th class="d-none d-md-table-cell">Total Soal</th>
                                <th class="d-none d-md-table-cell">Persentase</th>
                                <th class="d-none d-md-table-cell">Waktu Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($quiz_results)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada hasil quiz.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($quiz_results as $result): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($result['nama']); ?></td>
                                        <td><?php echo $result['score']; ?></td>
                                        <td class="d-none d-md-table-cell"><?php echo $result['total_questions']; ?></td>
                                        <td class="d-none d-md-table-cell"><?php echo number_format($result['percentage'], 2); ?>%</td>
                                        <td class="d-none d-md-table-cell"><?php echo date('d/m/Y', strtotime($result['completed_at'])); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteQuizResult(<?php echo $result['id']; ?>, '<?php echo addslashes($result['nama']); ?>')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="manage_quiz.php" class="btn btn-success me-2">Kelola Quiz</a>
                    <a href="../index.php" class="btn btn-primary me-2">Ke Halaman Utama</a>
                    <a href="../auth/logout.php" class="btn btn-secondary">Logout</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="mb-3">
                            <label for="edit-nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit-username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-password" class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
                            <input type="password" class="form-control" id="edit-password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus siswa <strong id="delete-name"></strong>?</p>
                    <p class="text-danger">Data yang dihapus tidak dapat dikembalikan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" id="delete-form" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" id="delete-id" name="id">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Delete Quiz Confirmation Modal -->
    <div class="modal fade" id="deleteQuizModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Hasil Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus hasil quiz siswa <strong id="delete-quiz-name"></strong>?</p>
                    <p class="text-danger">Data yang dihapus tidak dapat dikembalikan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" id="delete-quiz-form" style="display: inline;">
                        <input type="hidden" name="action" value="delete_quiz">
                        <input type="hidden" id="delete-quiz-id" name="id">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scriptt.js"></script>
    <script>
        function editStudent(id, nama, username) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-username').value = username;
            document.getElementById('edit-password').value = '';
            new bootstrap.Modal(document.getElementById('editStudentModal')).show();
        }

        function deleteStudent(id, nama) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-name').textContent = nama;
            new bootstrap.Modal(document.getElementById('deleteStudentModal')).show();
        }

        function deleteQuizResult(id, nama) {
            document.getElementById('delete-quiz-id').value = id;
            document.getElementById('delete-quiz-name').textContent = nama;
            new bootstrap.Modal(document.getElementById('deleteQuizModal')).show();
        }
    </script>
</body>
</html>
