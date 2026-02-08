<?php
session_start();

// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// Get user's exam results
$user_id = $_SESSION['user_id'] ?? 0;
$results_sql = "SELECT * FROM exam_results WHERE user_id = ? ORDER BY exam_date DESC LIMIT 10";
$results_stmt = $conn->prepare($results_sql);
$results_stmt->bind_param("i", $user_id);
$results_stmt->execute();
$results_query = $results_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - ENGINE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(to right, #243b55, #141e30); color: white; }
        .main-container { max-width: 1000px; margin: 100px auto; padding: 30px; background: rgba(255,255,255,0.05); border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); }
        .welcome-msg { font-size: 28px; margin-bottom: 10px; color: #4158D0; font-weight: bold; }
        .subtitle { color: #ccc; margin-bottom: 30px; font-size: 1.1rem; }
        .action-buttons { display: flex; gap: 20px; margin-bottom: 40px; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 12px 30px; background: #4158D0; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s; }
        .btn:hover { background: #3649ac; transform: translateY(-2px); }
        .results-section { margin-top: 40px; }
        .results-section h2 { margin-top: 20px; padding-bottom: 10px; border-bottom: 2px solid #4158D0; }
        .result-item { background: rgba(255,255,255,0.08); padding: 15px; margin: 10px 0; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .result-item strong { color: #4158D0; }
        .score-badge { background: #4158D0; padding: 5px 15px; border-radius: 20px; }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="main-container">
        <div class="welcome-msg">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 👋</div>
        <p class="subtitle">Ready to take the next exam?</p>

        <div class="action-buttons">
            <a href="take_exam.php" class="btn">📝 Take an Exam</a>
            <a href="logout.php" class="btn" style="background: #ff4b4b;">🚪 Logout</a>
        </div>

        <?php if ($results_query->num_rows > 0): ?>
            <div class="results-section">
                <h2>Your Recent Results</h2>
                <?php while ($result = $results_query->fetch_assoc()): ?>
                    <div class="result-item">
                        <div>
                            <strong><?php echo htmlspecialchars(ucfirst($result['category'])); ?></strong>
                            <p style="color: #aaa; font-size: 0.9rem;">Taken: <?php echo date('M d, Y', strtotime($result['exam_date'])); ?></p>
                        </div>
                        <div class="score-badge">
                            <?php echo $result['score']; ?>/<?php echo $result['total']; ?> (<?php echo round($result['percentage'], 1); ?>%)
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="results-section">
                <h2>No Exam Results Yet</h2>
                <p style="color: #aaa;">You haven't completed any exams yet. Start by taking your first exam!</p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
<?php $results_stmt->close(); ?>