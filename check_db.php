<?php
require_once 'db.php';

echo "=== DATABASE STATUS ===\n";
echo "Checking tables in engine_db:\n\n";

$result = $conn->query('SHOW TABLES');
if ($result->num_rows > 0) {
    while($row = $result->fetch_row()) {
        echo "✓ " . $row[0] . "\n";
    }
} else {
    echo "No tables found!\n";
}

// Check if exam_questions table exists
echo "\n=== CHECKING EXAM_QUESTIONS TABLE ===\n";
$result = $conn->query("SHOW TABLES LIKE 'exam_questions'");
if ($result->num_rows == 0) {
    echo "exam_questions table is MISSING - need to create it\n";
} else {
    echo "exam_questions table EXISTS\n";
    $result = $conn->query("SELECT COUNT(*) as count FROM exam_questions");
    $row = $result->fetch_assoc();
    echo "Questions in table: " . $row['count'] . "\n";
}

$conn->close();
?>
