<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$score = 0;
$total = 0;
$category = $_POST['category'];

// Iterate through the posted answers
foreach ($_POST as $key => $user_answer) {
    // We named our inputs 'q' + question ID (e.g., q1, q5)
    if (strpos($key, 'q') === 0) {
        $question_id = substr($key, 1);
        $total++;

        // Fetch the correct answer from the database
        $sql = "SELECT correct_option FROM exam_questions WHERE id = '$question_id'";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            if ($row['correct_option'] === $user_answer) {
                $score++;
            }
        }
    }
}
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