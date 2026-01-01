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
            $question = trim($_POST['question']);
            $type = $_POST['type'];
            $correct_answer = [];

            if ($type == 'radio') {
                $options = [];
                if (isset($_POST['option_text'])) {
                    foreach ($_POST['option_text'] as $index => $text) {
                        if (!empty($text)) {
                            $value = chr(97 + $index); // a, b, c, d...
                            $options[] = ['value' => $value, 'text' => trim($text)];
                            if (isset($_POST['correct_option']) && $value == $_POST['correct_option']) {
                                $correct_answer[] = trim($text); // Store text instead of value
                            }
                        }
                    }
                }
                $options_json = json_encode($options);
            }

            $correct_answer_json = json_encode($correct_answer);

            $stmt = $db->prepare("INSERT INTO quiz_questions (question, type, options, correct_answer) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $question, $type, $options_json, $correct_answer_json);

            if ($stmt->execute()) {
                $message = "Soal quiz berhasil ditambahkan!";
                $messageType = "success";
            } else {
                $message = "Gagal menambahkan soal quiz!";
                $messageType = "danger";
            }

        } elseif ($action == 'update') {
            $id = $_POST['id'];
            $question = trim($_POST['question']);
            $type = $_POST['type'];
            $correct_answer = [];

            if ($type == 'radio') {
                $options = [];
                if (isset($_POST['option_text'])) {
                    foreach ($_POST['option_text'] as $index => $text) {
                        if (!empty($text)) {
                            $value = chr(97 + $index);
                            $options[] = ['value' => $value, 'text' => trim($text)];
                            if (isset($_POST['correct_option']) && $value == $_POST['correct_option']) {
                                $correct_answer[] = trim($text); // Store text instead of value
                            }
                        }
                    }
                }
                $options_json = json_encode($options);
            }

            $correct_answer_json = json_encode($correct_answer);

            $stmt = $db->prepare("UPDATE quiz_questions SET question = ?, type = ?, options = ?, correct_answer = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $question, $type, $options_json, $correct_answer_json, $id);

            if ($stmt->execute()) {
                $message = "Soal quiz berhasil diupdate!";
                $messageType = "success";
            } else {
                $message = "Gagal mengupdate soal quiz!";
                $messageType = "danger";
            }

        } elseif ($action == 'delete') {
            $id = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM quiz_questions WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Soal quiz berhasil dihapus!";
                $messageType = "success";
            } else {
                $message = "Gagal menghapus soal quiz!";
                $messageType = "danger";
            }
        }
    }
}

// Get all quiz questions
$result = $db->query("SELECT * FROM quiz_questions ORDER BY created_at DESC");
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Quiz - Media Pembelajaran Berpikir Komputasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/mainn.css">
</head>
<body>
    <main>
        <section class="hero">
            <div class="container">
                <h2>Kelola Soal Quiz</h2>
                <p>Kelola soal-soal quiz untuk siswa</p>

                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Daftar Soal Quiz</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                        <i class="fas fa-plus"></i> Tambah Soal
                    </button>
                </div>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Tipe</th>
                            <th class="d-none d-md-table-cell">Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($questions)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada soal quiz.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($questions as $question): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars(substr($question['question'], 0, 100)) . (strlen($question['question']) > 100 ? '...' : ''); ?></td>
                                    <td><?php echo ucfirst($question['type']); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo date('d/m/Y H:i', strtotime($question['created_at'])); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning me-2" onclick="editQuestion(<?php echo $question['id']; ?>)">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteQuestion(<?php echo $question['id']; ?>, '<?php echo addslashes(substr($question['question'], 0, 50)); ?>')">
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
                <a href="dashboard_guru.php" class="btn btn-primary me-2">Kembali ke Dashboard</a>
                <a href="../index.php" class="btn btn-secondary">Ke Halaman Utama</a>
            </div>
        </section>
    </main>

    <!-- Add Question Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Soal Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-3">
                            <label for="question" class="form-label">Pertanyaan</label>
                            <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Soal</label>
                            <select class="form-select" id="type" name="type" required onchange="toggleOptions()">
                                <option value="radio">Pilihan Ganda</option>
                            </select>
                        </div>

                        <div id="options-section">
                            <label class="form-label">Pilihan Jawaban</label>
                            <div id="options-container">
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_option" value="a">
                                        </div>
                                        <input type="text" class="form-control" name="option_text[]" placeholder="Pilihan A" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Hapus</button>
                                    </div>
                                </div>
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_option" value="b">
                                        </div>
                                        <input type="text" class="form-control" name="option_text[]" placeholder="Pilihan B" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addOption()">Tambah Pilihan</button>
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

    <!-- Edit Question Modal -->
    <div class="modal fade" id="editQuestionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Soal Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="mb-3">
                            <label for="edit-question" class="form-label">Pertanyaan</label>
                            <textarea class="form-control" id="edit-question" name="question" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-type" class="form-label">Tipe Soal</label>
                            <select class="form-select" id="edit-type" name="type" required onchange="toggleEditOptions()">
                                <option value="radio">Pilihan Ganda (Satu Jawaban)</option>
                            </select>
                        </div>

                        <div id="edit-options-section">
                            <label class="form-label">Pilihan Jawaban</label>
                            <div id="edit-options-container"></div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addEditOption()">Tambah Pilihan</button>
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
    <div class="modal fade" id="deleteQuestionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus soal: <strong id="delete-question"></strong>?</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleOptions() {
            const type = document.getElementById('type').value;
            document.getElementById('options-section').style.display = (type === 'radio' || type === 'checkbox') ? 'block' : 'none';
            document.getElementById('number-section').style.display = type === 'number' ? 'block' : 'none';
            document.getElementById('text-section').style.display = type === 'text' ? 'block' : 'none';
        }

        function toggleEditOptions() {
            const type = document.getElementById('edit-type').value;
            document.getElementById('edit-options-section').style.display = (type === 'radio' || type === 'checkbox') ? 'block' : 'none';
            document.getElementById('edit-number-section').style.display = type === 'number' ? 'block' : 'none';
            document.getElementById('edit-text-section').style.display = type === 'text' ? 'block' : 'none';
        }

        function addOption() {
            const container = document.getElementById('options-container');
            const optionCount = container.children.length;
            const value = String.fromCharCode(97 + optionCount); // a, b, c, d...

            const optionDiv = document.createElement('div');
            optionDiv.className = 'option-item mb-2';
            optionDiv.innerHTML = `
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="radio" name="correct_option" value="${value}">
                    </div>
                    <input type="text" class="form-control" name="option_text[]" placeholder="Pilihan ${value.toUpperCase()}" required>
                    <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Hapus</button>
                </div>
            `;
            container.appendChild(optionDiv);
        }

        function addEditOption() {
            const container = document.getElementById('edit-options-container');
            const optionCount = container.children.length;
            const value = String.fromCharCode(97 + optionCount);

            const optionDiv = document.createElement('div');
            optionDiv.className = 'option-item mb-2';
            optionDiv.innerHTML = `
                <div class="input-group">
                    <div class="input-group-text">
                        <input type="radio" name="correct_option" value="${value}">
                    </div>
                    <input type="text" class="form-control" name="option_text[]" placeholder="Pilihan ${value.toUpperCase()}" required>
                    <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Hapus</button>
                </div>
            `;
            container.appendChild(optionDiv);
        }

        function removeOption(button) {
            button.closest('.option-item').remove();
        }

        function editQuestion(id) {
            // Fetch question data and populate edit modal
            fetch(`get_quiz_question.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const question = data.question;
                        document.getElementById('edit-id').value = question.id;
                        document.getElementById('edit-question').value = question.question;
                        document.getElementById('edit-type').value = question.type;

                        // Only handle radio type since that's the only option now
                        const container = document.getElementById('edit-options-container');
                        container.innerHTML = '';

                        question.options.forEach((option, index) => {
                            const optionDiv = document.createElement('div');
                            optionDiv.className = 'option-item mb-2';
                            const isCorrect = question.correct_answer.includes(option.text); // Check against text instead of value
                            optionDiv.innerHTML = `
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_option" value="${option.value}" ${isCorrect ? 'checked' : ''}>
                                    </div>
                                    <input type="text" class="form-control" name="option_text[]" value="${option.text}" required>
                                    <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Hapus</button>
                                </div>
                            `;
                            container.appendChild(optionDiv);
                        });

                        new bootstrap.Modal(document.getElementById('editQuestionModal')).show();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function deleteQuestion(id, question) {
            document.getElementById('delete-id').value = id;
            document.getElementById('delete-question').textContent = question;
            new bootstrap.Modal(document.getElementById('deleteQuestionModal')).show();
        }

        // Initialize
        toggleOptions();
        toggleEditOptions();
    </script>
</body>
</html>
