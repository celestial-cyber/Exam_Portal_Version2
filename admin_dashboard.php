<?php
session_start();

// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// Get statistics
$users_sql = "SELECT COUNT(*) as count FROM engine_user";
$users_result = $conn->query($users_sql);
$users_count = $users_result->fetch_assoc()['count'] ?? 0;

$questions_sql = "SELECT COUNT(*) as count FROM exam_questions";
$questions_result = $conn->query($questions_sql);
$questions_count = $questions_result->fetch_assoc()['count'] ?? 0;

$results_sql = "SELECT COUNT(*) as count FROM exam_results";
$results_result = $conn->query($results_sql);
$results_count = $results_result->fetch_assoc()['count'] ?? 0;

// Get all users
$all_users_sql = "SELECT id, username, role FROM engine_user";
$all_users = $conn->query($all_users_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - ENGINE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(to right, #243b55, #141e30); color: white; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 20px; border-right: 1px solid rgba(255,255,255,0.1); position: fixed; left: 0; top: 0; overflow-y: auto; margin-top: 70px; }
        .content { flex: 1; padding: 100px 40px 40px 290px; }
        .stat-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(65, 88, 208, 0.5); padding: 30px; border-radius: 15px; margin-bottom: 20px; text-align: center; }
        .stat-number { font-size: 2.5rem; font-weight: bold; color: #4158D0; margin: 10px 0; }
        .stat-label { color: #ccc; font-size: 0.95rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .users-list { background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); }
        .user-item { background: rgba(255,255,255,0.08); padding: 15px; margin: 10px 0; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .role-badge { padding: 5px 10px; border-radius: 5px; font-size: 0.85rem; font-weight: bold; }
        .role-admin { background: #ff4b4b; }
        .role-trainer { background: #4158D0; }
        .role-user { background: #4bff4b; color: black; }
        .btn { display: inline-block; padding: 10px 20px; background: #ff4b4b; color: white; text-decoration: none; border-radius: 5px; font-size: 0.85rem; }
        .btn:hover { background: #ff3333; }
        h1 { border-bottom: 2px solid #4158D0; padding-bottom: 10px; margin-bottom: 30px; }
        h2 { margin-top: 30px; margin-bottom: 15px; color: #4158D0; }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="sidebar">
        <h3 style="margin-bottom: 20px; color: #4158D0;">Admin Menu</h3>
        <ul style="list-style: none;">
            <li><a href="#dashboard" style="color: white; text-decoration: none; display: block; padding: 10px; border-radius: 5px; hover: background: rgba(255,255,255,0.1);">📊 Dashboard</a></li>
            <li><a href="#users" style="color: white; text-decoration: none; display: block; padding: 10px; border-radius: 5px;">👥 Users</a></li>
            <li><a href="#questions" style="color: white; text-decoration: none; display: block; padding: 10px; border-radius: 5px;">❓ Questions</a></li>
            <li><a href="logout.php" style="color: #ff4b4b; text-decoration: none; display: block; padding: 10px; border-radius: 5px; margin-top: 20px;">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="content" id="dashboard">
        <h1>Admin Dashboard 🔐</h1>
        <p style="color: #ccc; margin-bottom: 30px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>

        <h2>System Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <p class="stat-label">Total Users</p>
                <div class="stat-number"><?php echo $users_count; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Exam Questions</p>
                <div class="stat-number"><?php echo $questions_count; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Results Recorded</p>
                <div class="stat-number"><?php echo $results_count; ?></div>
            </div>
        </div>

        <h2 id="users">User Management</h2>
        <div class="users-list">
            <?php if ($all_users->num_rows > 0): ?>
                <?php while ($user = $all_users->fetch_assoc()): ?>
                    <div class="user-item">
                        <div>
                            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                            <p style="color: #aaa; font-size: 0.85rem;">ID: <?php echo $user['id']; ?></p>
                        </div>
                        <div>
                            <span class="role-badge role-<?php echo strtolower($user['role']); ?>">
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: #ccc;">No users found</p>
            <?php endif; ?>
        </div>

        <h2 id="questions">Platform Status</h2>
        <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
            <p>✓ Database: Connected</p>
            <p>✓ Sessions: Active</p>
            <p>✓ Questions: <?php echo $questions_count; ?> available</p>
            <p>✓ System: Running normally</p>
        </div>
    </div>

</body>
</html>