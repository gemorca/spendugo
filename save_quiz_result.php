<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

include 'db/db_connect.php';

// Get student_id from session username
$username = $_SESSION['username'];
$stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Student not found']);
    exit();
}

$student = $result->fetch_assoc();
$student_id = $student['id'];

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'])) {
        $action = $data['action'];

        if ($action == 'progress') {
            // Save progress after each question
            $question_index = $data['question_index'];
            $score = $data['score'];

            // Insert or update progress
            $stmt = $db->prepare("INSERT INTO quiz_progress (student_id, question_index, score) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE score = VALUES(score), completed_at = CURRENT_TIMESTAMP");
            $stmt->bind_param("iii", $student_id, $question_index, $score);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Progress saved']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save progress']);
            }

        } elseif ($action == 'result') {
            // Save final result
            $score = $data['score'];
            $total_questions = $data['totalQuestions'];
            $percentage = $data['percentage'];

            $stmt = $db->prepare("INSERT INTO quiz_results (student_id, score, total_questions, percentage) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $student_id, $score, $total_questions, $percentage);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Result saved']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save result']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No action specified']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$db->close();
?>
