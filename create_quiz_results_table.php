<?php
include 'db/db_connect.php';

// Create quiz_results table
$sql = "CREATE TABLE IF NOT EXISTS quiz_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    percentage DECIMAL(5,2) NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
)";

if ($db->query($sql) === TRUE) {
    echo "Table quiz_results created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

$db->close();
?>
