<?php
// The nav.php already handles session_start and login checks!
include_once 'nav.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - ENGINE</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #1a1a2e; color: white; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 20px; border-right: 1px solid rgba(255,255,255,0.1); }
        .content { flex: 1; padding: 40px; }
        .card { background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px; margin-top: 20px; }
        .btn-logout { color: #ff4b4b; text-decoration: none; font-weight: bold; }
        h1 { border-bottom: 2px solid #4158D0; padding-bottom: 10px; }
    </style>
</head>
<body>
   
    <div class="content">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <div class="card">
            <h3>Admin Overview</h3>
            <p>This panel allows you to manage the entire "ENGINE" platform.</p>
        </div>
    </div>
</body>
</html>