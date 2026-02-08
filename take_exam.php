<?php
session_start();
// Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams - ENGINE</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #1a1a2e;
            color: white;
            min-height: 100vh;
        }

        .container {
            padding-top: 120px; /* Space for the fixed nav */
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }

        .exam-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .exam-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px 20px;
            transition: 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .exam-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
            border-color: #4158D0;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: rgba(65, 88, 208, 0.2);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #4158D0;
        }

        .exam-card h3 {
            margin: 10px 0;
            letter-spacing: 1px;
        }

        .exam-card p {
            font-size: 0.85rem;
            color: #ccc;
            margin-bottom: 25px;
            line-height: 1.4;
        }

        .start-btn {
            text-decoration: none;
            background: #4158D0;
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .start-btn:hover {
            background: white;
            color: #4158D0;
        }
    </style>
</head>
<body>

    <?php include 'nav.php'; ?>

    <div class="container">
        <h1>Select Your Assessment</h1>
        <p style="opacity: 0.7;">Choose a category to begin your examination</p>

        <div class="exam-grid">
            <div class="exam-card">
                <div class="icon-circle">🔢</div>
                <h3>Aptitude</h3>
                <p>Logical reasoning, mathematics, and problem-solving skills.</p>
                <button onclick="startSecureExam('aptitude')" class="start-btn" style="cursor:pointer; border:none;">Start Now</button>
            </div>

            <div class="exam-card">
                <div class="icon-circle">📚</div>
                <h3>Verbal</h3>
                <p>Grammar, vocabulary, and reading comprehension tests.</p>
                <button onclick="startSecureExam('verbal')" class="start-btn" style="cursor:pointer; border:none;">Start Now</button>
            </div>

            <div class="exam-card">
                <div class="icon-circle">💻</div>
                <h3>Technical</h3>
                <p>Core engineering concepts and programming fundamentals.</p>
                <button onclick="startSecureExam('technical')" class="start-btn" style="cursor:pointer; border:none;">Start Now</button>
            </div>
        </div>
    </div>
<script>
function startSecureExam(type) {
    const elem = document.documentElement;

    // Function to handle the actual navigation
    const goToQuiz = () => {
        window.location.href = "quiz.php?type=" + type;
    };

    // Standard Fullscreen Request
    if (elem.requestFullscreen) {
        elem.requestFullscreen()
            .then(() => {
                // Wait 500ms for the animation to finish before moving to the quiz
                setTimeout(goToQuiz, 500); 
            })
            .catch(err => {
                console.error(`Error attempting to enable full-screen mode: ${err.message}`);
                alert("Please allow Fullscreen mode to start the examination.");
            });
    } 
    // Compatibility for Safari/Old Chrome
    else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
        setTimeout(goToQuiz, 500);
    } 
    // Compatibility for IE/Edge
    else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
        setTimeout(goToQuiz, 500);
    }
}
</script>
</body>
</html>