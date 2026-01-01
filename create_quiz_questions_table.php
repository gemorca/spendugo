<?php
include 'db/db_connect.php';

// Create quiz_questions table
$sql = "CREATE TABLE IF NOT EXISTS quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    type ENUM('radio', 'checkbox', 'number', 'text') NOT NULL DEFAULT 'radio',
    options JSON NULL,
    correct_answer JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($db->query($sql) === TRUE) {
    echo "Table quiz_questions created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

$db->close();
?>
