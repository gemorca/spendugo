<?php
include 'db/db_connect.php';

$result = $db->query('DESCRIBE users');
echo "Table: users\n";
while($row = $result->fetch_assoc()) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
}
?>
