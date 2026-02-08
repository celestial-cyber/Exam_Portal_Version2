<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<nav class="custom-nav">
    <div class="nav-wrapper">
        <div class="left-section">
            <?php if ($role == 'user'): ?>
                <div class="nav-logo">
                    <a href="student_dashboard.php">ENGINE</a>
                </div>
                <a href="take_exam.php" class="btn-action btn-user">Take Exam</a>
            <?php elseif ($role == 'trainer'): ?>
                <div class="nav-logo">
                    <a href="trainer_dashboard.php">ENGINE</a>
                </div>
            <?php elseif ($role == 'admin'): ?>
                <div class="nav-logo">
                    <a href="admin_dashboard.php">ENGINE</a>
                </div>
            <?php else: ?>
                <div class="nav-logo">
                    <a href="index.php">ENGINE</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="right-section">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</nav>

<style>
    .custom-nav {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 10px 0;
        width: 100%;
        position: fixed;
        top: 0;
        z-index: 1000;
    }

    .nav-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between; /* Pushes left and right sections apart */
        align-items: center;
        padding: 0 20px;
    }

    .left-section {
        display: flex;
        align-items: center;
        gap: 30px; /* Space between logo and the "Take Exam" button */
    }

    .nav-logo a {
        font-size: 1.8rem;
        font-weight: 900;
        color: #fff;
        text-decoration: none;
        letter-spacing: 3px;
    }

    .btn-action {
        text-decoration: none;
        color: white;
        padding: 8px 18px;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: 0.3s ease;
    }

    /* User Button Color */
    .btn-user {
        background: #4158D0;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .btn-user:hover {
        background: #3649ac;
        transform: translateY(-2px);
    }

    .logout-btn {
        text-decoration: none;
        background: #ff4b4b;
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: bold;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #e63e3e;
    }
</style>