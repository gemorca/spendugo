<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

include 'db/db_connect.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Question ID required']);
    exit();
}

$id = intval($_GET['id']);
$stmt = $db->prepare("SELECT * FROM quiz_questions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Question not found']);
    exit();
}

$row = $result->fetch_assoc();

// Decode JSON fields
$row['options'] = json_decode($row['options'], true);
$row['correct_answer'] = json_decode($row['correct_answer'], true);

echo json_encode(['success' => true, 'question' => $row]);

$stmt->close();
$db->close();
?>
