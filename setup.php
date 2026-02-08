<?php
// Database connection without selecting a database initially
$servername = "localhost";
$username = "root";
$password = "root@123";

// Connect to MySQL server (not to a specific database)
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    // If connection fails, try with common passwords
    $passwords = ["root", "12345", "password", "mysql", ""];
    $connected = false;
    
    foreach ($passwords as $pwd) {
        $conn = new mysqli($servername, $username, $pwd);
        if (!$conn->connect_error) {
            $connected = true;
            echo "✓ Connected with password\n";
            break;
        }
    }
    
    if (!$connected) {
        die("❌ Connection failed: " . $conn->connect_error . "\nPlease update the MySQL root password in setup.php");
    }
}

echo "✓ Connected to MySQL successfully!\n\n";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS engine_db";
if ($conn->query($sql) === TRUE) {
    echo "✓ Database 'engine_db' created successfully or already exists.\n";
} else {
    die("❌ Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db("engine_db");

// Create tables directly
echo "\n=== CREATING TABLES ===\n\n";

// Create engine_user table
$sql_user = "CREATE TABLE IF NOT EXISTS `engine_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql_user) === TRUE) {
    echo "✓ engine_user table created\n";
} else {
    echo "❌ Error creating engine_user table: " . $conn->error . "\n";
}

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
    echo "❌ Error creating exam_questions table: " . $conn->error . "\n";
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
    echo "❌ Error creating exam_results table: " . $conn->error . "\n";
}

// Check if users exist
$check_users = "SELECT COUNT(*) as count FROM engine_user";
$result = $conn->query($check_users);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "\n=== INSERTING DEFAULT USERS ===\n\n";
    
    // Insert default users (passwords are plain text for now, should be hashed in production)
    $default_users = [
        ['admin', 'admin123', 'admin'],
        ['trainer', 'trainer123', 'trainer'],
        ['user', 'user123', 'user']
    ];
    
    foreach ($default_users as $user) {
        $username = $user[0];
        $password = $user[1]; // Hash this in production: password_hash($user[1], PASSWORD_BCRYPT)
        $role = $user[2];
        
        $sql_insert = "INSERT INTO engine_user (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sss", $username, $password, $role);
        
        if ($stmt->execute()) {
            echo "✓ User '$username' created\n";
        } else {
            echo "❌ Error creating user: " . $stmt->error . "\n";
        }
        $stmt->close();
    }
} else {
    echo "✓ Users already exist\n";
}

// Check if questions exist
$check_questions = "SELECT COUNT(*) as count FROM exam_questions";
$result = $conn->query($check_questions);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "\n=== INSERTING SAMPLE QUESTIONS ===\n\n";
    
    $sample_questions = [
        // Aptitude
        ['What is 15 + 25?', 'aptitude', '30', '35', '40', '45', 'b'],
        ['What is 50 * 2?', 'aptitude', '75', '100', '125', '150', 'b'],
        ['What is 144 / 12?', 'aptitude', '10', '11', '12', '13', 'c'],
        // Verbal
        ['What is the plural of "child"?', 'verbal', 'childs', 'childes', 'children', 'childre', 'c'],
        ['Fill in the blank: "She ___ to the market."', 'verbal', 'go', 'goes', 'going', 'gone', 'b'],
        // Technical
        ['What does HTML stand for?', 'technical', 'Hyper Text Multiple Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'Hyperlinks Text Markup Language', 'b'],
        ['Which is a programming language?', 'technical', 'HTML', 'CSS', 'JavaScript', 'XML', 'c']
    ];
    
    foreach ($sample_questions as $q) {
        $sql_q = "INSERT INTO exam_questions (question_text, category, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_q);
        $stmt->bind_param("sssssss", $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6]);
        
        if ($stmt->execute()) {
            echo "✓ Question added\n";
        } else {
            echo "❌ Error adding question: " . $stmt->error . "\n";
        }
        $stmt->close();
    }
}

echo "\n✓ Database setup completed successfully!\n";
echo "\n=== DEFAULT CREDENTIALS ===\n";
echo "Admin    - username: admin    password: admin123\n";
echo "Trainer  - username: trainer  password: trainer123\n";
echo "User     - username: user     password: user123\n";
echo "\n🎉 Setup complete! Visit login.php to start.\n";

$conn->close();
?>

