<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

include 'db/db_connect.php';

$result = $db->query("SELECT * FROM quiz_questions ORDER BY created_at ASC");
$questions = [];

while ($row = $result->fetch_assoc()) {
    // Decode JSON fields
    $row['options'] = json_decode($row['options'], true);
    $row['correct_answer'] = json_decode($row['correct_answer'], true);

    $questions[] = $row;
}

echo json_encode(['success' => true, 'questions' => $questions]);

$db->close();
?>
