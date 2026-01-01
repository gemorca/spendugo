<?php
include 'db/db_connect.php';

// Create quiz_progress table
$sql = "CREATE TABLE IF NOT EXISTS quiz_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    question_index INT NOT NULL,
    score INT NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_progress (student_id, question_index)
)";

if ($db->query($sql) === TRUE) {
    echo "Table quiz_progress created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

$db->close();
?>
