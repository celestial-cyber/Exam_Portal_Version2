<?php
require_once 'db.php';

echo "Setting up complete database structure...\n\n";

// Create exam_questions table
$sql_exam = "CREATE TABLE IF NOT EXISTS `exam_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` char(1) NOT NULL,
  `explanation` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql_exam) === TRUE) {
    echo "✓ exam_questions table created\n";
} else {
    echo "Error creating exam_questions table: " . $conn->error . "\n";
}

// Create exam_results table
$sql_results = "CREATE TABLE IF NOT EXISTS `exam_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `percentage` float NOT NULL,
  `exam_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `engine_user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql_results) === TRUE) {
    echo "✓ exam_results table created\n";
} else {
    echo "Error creating exam_results table: " . $conn->error . "\n";
}

// Insert sample exam questions using prepared statements
$sample_questions = [
    // Aptitude questions
    ['What is 15 + 25?', 'aptitude', '30', '35', '40', '45', 'b'],
    ['If a train travels at 60 km/h, how far does it travel in 2 hours?', 'aptitude', '60 km', '80 km', '100 km', '120 km', 'd'],
    ['What is the square root of 144?', 'aptitude', '10', '11', '12', '13', 'c'],
    ['What is 50% of 200?', 'aptitude', '75', '100', '125', '150', 'b'],
    
    // Technical questions
    ['What does PHP stand for?', 'technical', 'Personal Home Page', 'Hypertext Preprocessor', 'Private Home Page', 'Portable Hypertext Processor', 'b'],
    ['Which of the following is a NoSQL database?', 'technical', 'MySQL', 'PostgreSQL', 'MongoDB', 'Oracle', 'c'],
    ['What does HTML stand for?', 'technical', 'Hyper Text Multiple Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'Hyperlinks and Text Markup Language', 'b'],
    ['Which is a programming language?', 'technical', 'HTML', 'CSS', 'JavaScript', 'XML', 'c'],
    
    // Verbal questions
    ['What is the opposite of "begin"?', 'verbal', 'start', 'end', 'continue', 'commence', 'b'],
    ['Fill in the blank: "She ___ to school every day."', 'verbal', 'go', 'goes', 'going', 'gone', 'b'],
    ['What is the plural of "child"?', 'verbal', 'childs', 'childes', 'children', 'childre', 'c'],
    ['Complete the phrase: "Once in a blue ___"', 'verbal', 'sky', 'moon', 'night', 'star', 'b']
];

echo "\nInserting sample questions...\n";
$count = 0;
foreach ($sample_questions as $q) {
    $sql_insert = "INSERT INTO exam_questions 
    (question_text, category, option_a, option_b, option_c, option_d, correct_answer) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql_insert);
    if ($stmt) {
        $stmt->bind_param("sssssss", $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6]);
        
        if ($stmt->execute()) {
            echo "✓ Added question " . (++$count) . "\n";
        } else {
            if (strpos($stmt->error, 'Duplicate') === false) {
                echo "Error: " . $stmt->error . "\n";
            }
        }
        $stmt->close();
    }
}

echo "\n✓ Database setup completed successfully!\n";
$conn->close();
?>

echo "\n✓ Database setup completed successfully!\n";
$conn->close();
?>
