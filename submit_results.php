<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$score = 0;
$total = 0;
$category = isset($_POST['category']) ? $_POST['category'] : 'unknown';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Iterate through the posted answers
foreach ($_POST as $key => $user_answer) {
    // We named our inputs 'q' + question ID (e.g., q1, q5)
    if (strpos($key, 'q') === 0) {
        $question_id = substr($key, 1);
        $total++;

        // Use prepared statement to prevent SQL injection
        $sql = "SELECT correct_answer FROM exam_questions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $question_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                if ($row['correct_answer'] === $user_answer) {
                    $score++;
                }
            }
            $stmt->close();
        }
    }
}

// Save results to database if user_id is available
if ($user_id) {
    $percentage = ($total > 0) ? ($score / $total) * 100 : 0;
    
    $insert_sql = "INSERT INTO exam_results (user_id, category, score, total, percentage) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    
    if ($insert_stmt) {
        $insert_stmt->bind_param("isiii", $user_id, $category, $score, $total, $percentage);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Results - ENGINE</title>
    <style>
        body { margin: 0; background: linear-gradient(to right, #243b55, #141e30); color: white; font-family: 'Segoe UI', sans-serif; text-align: center; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .result-container { padding: 50px; }
        .result-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 50px; border-radius: 20px; display: inline-block; border: 1px solid rgba(255,255,255,0.1); }
        .score-circle { width: 150px; height: 150px; border: 5px solid #4158D0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 20px auto; font-weight: bold; }
        .percentage { font-size: 1.2rem; margin: 20px 0; color: #ccc; }
        .btn-back { display: inline-block; margin-top: 30px; padding: 12px 30px; background: #4158D0; color: white; text-decoration: none; border-radius: 50px; transition: 0.3s; }
        .btn-back:hover { background: white; color: #4158D0; }
        h2 { margin: 0; }
    </style>
</head>
<body>
    <div class="result-container">
        <div class="result-card">
            <h2><?php echo htmlspecialchars(ucfirst($category)); ?> Result</h2>
            <div class="score-circle">
                <?php echo $score; ?>/<?php echo $total; ?>
            </div>
            <div class="percentage">
                Percentage: <?php echo round(($score / max($total, 1)) * 100, 2); ?>%
            </div>
            <p><?php echo ($score >= ($total / 2)) ? "✓ Congratulations! You Passed." : "✗ Keep practicing and try again."; ?></p>
            <a href="take_exam.php" class="btn-back">Back to Exams</a>
        </div>
    </div>

</body>
</html>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Results - ENGINE</title>
    <style>
        body { margin: 0; background: #1a1a2e; color: white; font-family: 'Segoe UI', sans-serif; text-align: center; }
        .result-container { padding-top: 150px; }
        .result-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 50px; border-radius: 20px; display: inline-block; border: 1px solid rgba(255,255,255,0.1); }
        .score-circle { width: 150px; height: 150px; border: 5px solid #4158D0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 20px auto; font-weight: bold; }
        .btn-back { display: inline-block; margin-top: 30px; padding: 12px 30px; background: #4158D0; color: white; text-decoration: none; border-radius: 50px; transition: 0.3s; }
        .btn-back:hover { background: white; color: #4158D0; }
    </style>
</head>
<body>

    <?php include 'nav.php'; ?>

    <div class="result-container">
        <div class="result-card">
            <h2><?php echo ucfirst($category); ?> Result</h2>
            <div class="score-circle">
                <?php echo $score; ?>/<?php echo $total; ?>
            </div>
            <p><?php echo ($score >= ($total/2)) ? "Congratulations! You Passed." : "Keep practicing and try again."; ?></p>
            <a href="take_exam.php" class="btn-back">Back to Exams</a>
        </div>
    </div>

</body>
</html>