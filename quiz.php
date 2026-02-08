<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$exam_type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : 'aptitude';
$sql = "SELECT * FROM exam_questions WHERE category = '$exam_type' ORDER BY RAND() LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ucfirst($exam_type); ?> Quiz - ENGINE</title>
    <style>
        body { margin: 0; background: #1a1a2e; color: white; font-family: 'Segoe UI', sans-serif; }
        .quiz-container { padding-top: 140px; max-width: 800px; margin: 0 auto; padding-inline: 20px; padding-bottom: 50px; }
        
        /* Sticky Timer Styling */
        .timer-bar {
            position: fixed;
            top: 70px; /* Sits just below your nav.php bar */
            left: 0;
            width: 100%;
            background: #ff4b4b;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-weight: bold;
            font-size: 1.2rem;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .question-card { background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.1); }
        .option { display: block; background: rgba(255,255,255,0.1); padding: 15px; margin: 10px 0; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        .option:hover { background: rgba(65, 88, 208, 0.3); }
        .submit-btn { background: #4158D0; color: white; border: none; padding: 15px 40px; border-radius: 50px; font-weight: bold; cursor: pointer; display: block; margin: 30px auto; }

        /* Add this inside your existing <style> tag */

.custom-nav {
    display: none !important; /* Completely hides your nav.php bar */
}

.timer-bar {
    top: 0 !important; /* Moves the red timer bar to the very top since nav is gone */
    border-bottom: 2px solid rgba(0,0,0,0.2);
}

.quiz-container {
    padding-top: 80px; /* Reduces space since the main nav is hidden */
}
    </style>
</head>
<body>

    <div id="fullscreen-overlay" style="position:fixed; top:0; left:0; width:100%; height:100%; background:#1a1a2e; z-index:20000; display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <h1 style="color:white; margin-bottom:20px;">Ready to Begin?</h1>
    <p style="color:#ccc; margin-bottom:30px;">Click the button below to enter secure exam mode.</p>
    <button onclick="enterSecureMode()" style="background:#4158D0; color:white; border:none; padding:15px 40px; border-radius:50px; font-weight:bold; cursor:pointer; font-size:1.2rem;">Enter Fullscreen Exam</button>
</div>

<div id="warning-toast" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:#ff4b4b; color:white; padding:30px; border-radius:15px; z-index:30000; text-align:center;">
    <h2 id="warning-title">Warning!</h2>
    <p id="warning-msg"></p>
</div>

    <?php include 'nav.php'; ?>

    <div class="timer-bar">
        Time Remaining: <span id="timer">20:00</span>
    </div>

    <div class="quiz-container">
        <h1><?php echo ucfirst($exam_type); ?> Assessment</h1>
        <form id="examForm" action="submit_results.php" method="POST">
            <input type="hidden" name="category" value="<?php echo $exam_type; ?>">

            <?php if ($result->num_rows > 0): $q_num = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="question-card">
                        <p><strong>Question <?php echo $q_num++; ?>:</strong> <?php echo $row['question']; ?></p>
                        <label class="option"><input type="radio" name="q<?php echo $row['id']; ?>" value="a"> <?php echo $row['option_a']; ?></label>
                        <label class="option"><input type="radio" name="q<?php echo $row['id']; ?>" value="b"> <?php echo $row['option_b']; ?></label>
                        <label class="option"><input type="radio" name="q<?php echo $row['id']; ?>" value="c"> <?php echo $row['option_c']; ?></label>
                        <label class="option"><input type="radio" name="q<?php echo $row['id']; ?>" value="d"> <?php echo $row['option_d']; ?></label>
                    </div>
                <?php endwhile; ?>
                <button type="submit" class="submit-btn">Submit Exam</button>
            <?php else: ?>
                <p>No questions found for this category.</p>
            <?php endif; ?>
        </form>
    </div>     
   <style>
    /* Force the body to fill the screen */
    html, body {
        width: 100%;
        height: 100%;
        overflow-x: hidden;
    }

    .custom-nav {
        display: none !important;
    }

    /* Make the timer bar look like a header in fullscreen */
    .timer-bar {
        top: 0 !important;
        background: #2d3436;
        border-bottom: 3px solid #ff4b4b;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quiz-container {
        padding-top: 80px;
    }

    /* Warning Toast Message */
    #warning-toast {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #ff4b4b;
        color: white;
        padding: 20px 40px;
        border-radius: 10px;
        font-weight: bold;
        z-index: 10000;
        display: none;
        text-align: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
</style>

<div id="warning-toast">
    <h2 id="warning-title">Warning!</h2>
    <p id="warning-msg"></p>
</div>

<script>
    let timeInSeconds = 20 * 60;
    let warnings = 0;
    const maxWarnings = 3;
    const form = document.querySelector('#examForm');

    // FUNCTION TO TRIGGER TOTAL FULLSCREEN
    function enterSecureMode() {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen().then(() => {
                document.getElementById('fullscreen-overlay').style.display = 'none';
            });
        } else if (elem.webkitRequestFullscreen) { /* Safari/Brave */
            elem.webkitRequestFullscreen();
            document.getElementById('fullscreen-overlay').style.display = 'none';
        }
    }

    // 1. Monitor Fullscreen Exit (Strike System)
    document.addEventListener('fullscreenchange', () => {
        if (!document.fullscreenElement) {
            triggerWarning("You exited Fullscreen Mode. Please stay in the exam.");
            // Force them back in
            document.getElementById('fullscreen-overlay').style.display = 'flex';
        }
    });

    // 2. Monitor Tab Switching (Strike System)
    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            triggerWarning("Window/Tab switching detected!");
        }
    });

    // 3. Strike Handler
    function triggerWarning(reason) {
        warnings++;
        const toast = document.getElementById('warning-toast');
        const msg = document.getElementById('warning-msg');
        
        if (warnings >= maxWarnings) {
            alert("FINAL ATTEMPT: Exam auto-submitting due to security violations.");
            form.submit();
        } else {
            msg.innerText = reason + "\nChances remaining: " + (maxWarnings - warnings);
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 4000);
        }
    }

    // 4. Block Right-Click and Keys
    document.addEventListener('contextmenu', e => e.preventDefault());
    document.onkeydown = function(e) {
        if (e.keyCode == 123 || (e.ctrlKey && (e.keyCode == 85 || e.keyCode == 73 && e.shiftKey))) {
            triggerWarning("Developer tools and shortcuts are disabled.");
            return false;
        }
    };

    // 5. Timer
    const countdown = setInterval(() => {
        let minutes = Math.floor(timeInSeconds / 60);
        let seconds = timeInSeconds % 60;
        document.querySelector('#timer').textContent = `${minutes}:${seconds < 10 ? '0'+seconds : seconds}`;
        if (timeInSeconds <= 0) { clearInterval(countdown); form.submit(); }
        timeInSeconds--;
    }, 1000);

    // Prevent the user from using the browser's back button
(function() {
    window.history.pushState(null, "", window.location.href);        
    window.onpopstate = function() {
        window.history.pushState(null, "", window.location.href);
        triggerWarning("Using the back button is not allowed during the exam!");
    };
})();
</script>

</body>
</html>