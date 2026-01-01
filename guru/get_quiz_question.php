<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

include '../db/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $db->prepare("SELECT * FROM quiz_questions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $question = $result->fetch_assoc();

        // Decode JSON fields
        $question['options'] = json_decode($question['options'], true);
        $question['correct_answer'] = json_decode($question['correct_answer'], true);

        echo json_encode(['success' => true, 'question' => $question]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Question not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No question ID provided']);
}

$db->close();
?>
