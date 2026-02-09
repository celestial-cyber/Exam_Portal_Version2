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
    <title>ENGINE - The Exam Portal</title>
    <link rel="stylesheet" href="styles/theme.css">
    <link rel="stylesheet" href="styles/landing.css">
</head>
<body>
    <!-- Header / Navigation -->
    <header class="header" id="header">
        <div class="header-container">
            <div class="logo-section">
                <img src="images/SA Main logo.jpg" alt="SPECANCIENS Logo" class="logo-image">
                <div class="brand-text">
                    <div class="brand-title">SPECANCIENS</div>
                    <div class="brand-sub">The Alumni Association of SPEC'HYD</div>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="#home" class="nav-link active">Home</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#features" class="nav-link">Features</a>
                <a href="#contact" class="nav-link">Contact</a>
            </nav>
            
            <button class="btn-login-header" id="loginBtn">Login</button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-container">
            <!-- Left Column: Text Content -->
            <div class="hero-content">
                <h1 class="hero-title">ENGINE - The Exam Portal</h1>
                <p class="hero-subtitle">Secure, reliable online assessments for learners and educators. Create, take and review exams with ease.</p>
                
                <div class="hero-features">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span class="feature-text">Comprehensive assessments</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span class="feature-text">Real-time performance tracking</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span class="feature-text">Secure exam environment</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span class="feature-text">Instant results & analytics</span>
                    </div>
                </div>
                
                <div class="hero-buttons">
                    <button class="btn btn-primary" id="loginBtnHero">Get Started</button>
                    <button class="btn btn-secondary">Learn More</button>
                </div>
            </div>
            
            <!-- Right Column: Hero Image -->
            <div class="hero-image">
                <img src="images/desktop image.jpg" alt="ENGINE - The Exam Portal" class="hero-img">
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal-overlay" id="loginModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">&times;</button>
            
            <div class="modal-header">
                <h2>Welcome to ENGINE</h2>
                <p>Select your role to continue</p>
            </div>
            
            <div class="login-options">
                <!-- Admin Login Card -->
                <a href="login.php?role=admin" class="login-card admin-card">
                    <div class="card-icon">👔</div>
                    <h3>Admin</h3>
                    <p>Manage exams and users</p>
                </a>
                
                <!-- Trainer Login Card -->
                <a href="login.php?role=trainer" class="login-card trainer-card">
                    <div class="card-icon">🎓</div>
                    <h3>Trainer</h3>
                    <p>Create and evaluate</p>
                </a>
                
                <!-- Student Login Card -->
                <a href="login.php?role=student" class="login-card student-card">
                    <div class="card-icon">👨‍🎓</div>
                    <h3>Student</h3>
                    <p>Take exams & track progress</p>
                </a>
            </div>
            
            <div class="modal-footer">
                <p>Need help? <a href="#contact">Contact us</a></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <p>&copy; 2026 ENGINE - The Exam Portal. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact Us</a>
            </div>
        </div>
    </footer>

    <script src="scripts/landing.js"></script>
</body>
</html>
