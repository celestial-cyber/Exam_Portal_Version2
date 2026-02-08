<?php
session_start();

// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'trainer') {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// Get statistics
$questions_sql = "SELECT COUNT(*) as count FROM exam_questions";
$questions_result = $conn->query($questions_sql);
$questions_count = $questions_result->fetch_assoc()['count'] ?? 0;

$users_sql = "SELECT COUNT(*) as count FROM engine_user WHERE role = 'user'";
$users_result = $conn->query($users_sql);
$users_count = $users_result->fetch_assoc()['count'] ?? 0;

$results_sql = "SELECT COUNT(*) as count FROM exam_results";
$results_result = $conn->query($results_sql);
$results_count = $results_result->fetch_assoc()['count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard - ENGINE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(to right, #243b55, #141e30); color: white; }
        .main-container { max-width: 1000px; margin: 100px auto; padding: 30px; }
        .welcome-msg { font-size: 28px; margin-bottom: 20px; color: #4158D0; font-weight: bold; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-box { background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; border: 1px solid rgba(65, 88, 208, 0.5); text-align: center; }
        .stat-number { font-size: 2.5rem; font-weight: bold; color: #4158D0; margin: 10px 0; }
        .stat-label { color: #ccc; font-size: 0.95rem; }
        .action-buttons { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 40px; }
        .btn { display: inline-block; padding: 12px 30px; background: #4158D0; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s; }
        .btn:hover { background: #3649ac; transform: translateY(-2px); }
        .btn-danger { background: #ff4b4b; }
        .btn-danger:hover { background: #ff3333; }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="main-container">
        <div class="welcome-msg">Trainer Dashboard 👨‍🏫</div>
        <p style="color: #ccc; margin-bottom: 30px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>

        <div class="stats-grid">
            <div class="stat-box">
                <p class="stat-label">Total Questions</p>
                <div class="stat-number"><?php echo $questions_count; ?></div>
            </div>
            <div class="stat-box">
                <p class="stat-label">Registered Users</p>
                <div class="stat-number"><?php echo $users_count; ?></div>
            </div>
            <div class="stat-box">
                <p class="stat-label">Exams Completed</p>
                <div class="stat-number"><?php echo $results_count; ?></div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
        </div>

        <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
            <h2 style="margin-bottom: 15px;">Trainer Functions</h2>
            <p style="color: #ccc;">As a trainer, you can:</p>
            <ul style="color: #ccc; margin-left: 20px; line-height: 1.8;">
                <li>Monitor student progress and results</li>
                <li>Review exam statistics and analytics</li>
                <li>Provide feedback and guidance</li>
            </ul>
        </div>
    </div>

</body>
</html>