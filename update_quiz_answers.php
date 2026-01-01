<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: auth/login.php");
    exit();
}

include 'db/db_connect.php';

// Get all quiz questions
$result = $db->query("SELECT * FROM quiz_questions WHERE type IN ('radio', 'checkbox')");
$updated = 0;

while ($row = $result->fetch_assoc()) {
    $options = json_decode($row['options'], true);
    $correct_answers = json_decode($row['correct_answer'], true);

    if ($options && $correct_answers) {
        $new_correct_answers = [];

        foreach ($correct_answers as $correct_value) {
            // Find the option text for this value
            foreach ($options as $option) {
                if ($option['value'] === $correct_value) {
                    $new_correct_answers[] = $option['text'];
                    break;
                }
            }
        }

        if (!empty($new_correct_answers)) {
            $new_correct_json = json_encode($new_correct_answers);
            $stmt = $db->prepare("UPDATE quiz_questions SET correct_answer = ? WHERE id = ?");
            $stmt->bind_param("si", $new_correct_json, $row['id']);
            if ($stmt->execute()) {
                $updated++;
            }
        }
    }
}

$message = "Berhasil mengupdate $updated soal quiz. Jawaban benar sekarang disimpan berdasarkan teks opsi.";
$messageType = "success";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Quiz Answers - Media Pembelajaran Berpikir Komputasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <main>
        <section class="hero">
            <div class="container">
                <h2>Update Jawaban Quiz</h2>
                <div class="alert alert-<?php echo $messageType; ?>" role="alert">
                    <?php echo $message; ?>
                </div>
                <a href="guru/manage_quiz.php" class="btn btn-primary">Kembali ke Kelola Quiz</a>
            </div>
        </section>
    </main>
</body>
</html>

<?php $db->close(); ?>
