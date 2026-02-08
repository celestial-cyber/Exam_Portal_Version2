<?php
session_start();

// If user is already logged in, redirect to their dashboard
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } elseif ($_SESSION['role'] == 'trainer') {
        header("Location: trainer_dashboard.php");
    } else {
        header("Location: student_dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENGINE - Online Exam Portal</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(45deg, #4158D0, #C850C0, #FFCC70); background-size: 400% 400%; animation: gradientBG 15s ease infinite; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        @keyframes gradientBG { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        
        .hero-container { text-align: center; color: white; max-width: 800px; }
        .logo { font-size: 4rem; font-weight: 900; letter-spacing: 5px; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
        .tagline { font-size: 1.5rem; margin-bottom: 20px; opacity: 0.95; font-weight: 300; }
        .description { font-size: 1.1rem; margin-bottom: 40px; line-height: 1.6; opacity: 0.9; }
        
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 40px 0; }
        .feature-box { background: rgba(255,255,255,0.15); padding: 20px; border-radius: 10px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .feature-icon { font-size: 2rem; margin-bottom: 10px; }
        .feature-title { font-weight: bold; margin-bottom: 5px; }
        
        .action-buttons { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 40px; }
        .btn { padding: 15px 40px; border: none; border-radius: 50px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-primary { background: white; color: #4158D0; }
        .btn-primary:hover { transform: scale(1.05); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
        .btn-secondary { background: rgba(255,255,255,0.2); color: white; border: 2px solid white; }
        .btn-secondary:hover { background: rgba(255,255,255,0.3); }
        
        .footer { position: fixed; bottom: 20px; width: 100%; text-align: center; color: white; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="hero-container">
        <div class="logo">ENGINE</div>
        <div class="tagline">Online Exam Portal</div>
        <div class="description">
            Take assessments, track your progress, and test your skills across multiple categories.
            Secure, fast, and designed for learners and educators.
        </div>
        
        <div class="features">
            <div class="feature-box">
                <div class="feature-icon">📝</div>
                <div class="feature-title">Multiple Categories</div>
                <p style="font-size: 0.9rem; opacity: 0.9;">Aptitude, Verbal, Technical</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon">🔒</div>
                <div class="feature-title">Secure Exams</div>
                <p style="font-size: 0.9rem; opacity: 0.9;">Fullscreen mode & anti-cheat</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon">📊</div>
                <div class="feature-title">Instant Results</div>
                <p style="font-size: 0.9rem; opacity: 0.9;">See scores & analytics</p>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="login.php" class="btn btn-primary">Login Now</a>
            <a href="login.php" class="btn btn-secondary">Get Started</a>
        </div>
    </div>
    
    <div class="footer">
        <p>© 2026 ENGINE Exam Portal. All rights reserved.</p>
    </div>
</body>
</html>
