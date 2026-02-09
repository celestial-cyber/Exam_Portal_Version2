<?php
session_start();

// Get optional role parameter from landing page modal
$selected_role = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : '';

// 1. DATABASE CONNECTION
$servername = "localhost";
$db_username = "root";
$db_password = "root@123";
$dbname = "engine_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check if connection worked
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
$error = "";

// 2. LOGIN LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT id, username, password, role FROM engine_user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Check password (support both hashed and plain text for backward compatibility)
                if (password_verify($password, $row['password']) || $password === $row['password']) {
                    
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];

                    // 3. MULTI-USER REDIRECTION
                    if ($row['role'] == 'admin') {
                        header("Location: admin_dashboard.php");
                    } elseif ($row['role'] == 'trainer') {
                        header("Location: trainer_dashboard.php");
                    } else {
                        header("Location: student_dashboard.php");
                    }
                    exit();
                    
                } else {
                    $error = "Incorrect password.";
                }
            } else {
                $error = "No account found with that username.";
            }
            $stmt->close();
        } else {
            $error = "Database error. Please try again.";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENGINE - The Exam Portal - Login</title>
    <link rel="stylesheet" href="styles/theme.css">
    <style>
        /* Login Page Styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary-medium) 100%);
            padding: var(--spacing-lg);
        }

        .login-container {
            display: flex;
            gap: var(--spacing-3xl);
            width: 100%;
            max-width: 1200px;
            align-items: center;
        }

        .login-brand {
            flex: 1;
            color: var(--color-text-inverse);
            display: none;
        }

        .login-brand h1 {
            font-size: var(--font-size-4xl);
            margin-bottom: var(--spacing-md);
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .login-brand p {
            font-size: var(--font-size-lg);
            opacity: 0.9;
            line-height: 1.8;
        }

        .login-card {
            background: var(--color-bg-primary);
            border-radius: var(--radius-2xl);
            padding: var(--spacing-3xl);
            width: 100%;
            max-width: 450px;
            box-shadow: var(--shadow-2xl);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero image inside login card */
        .login-hero-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: calc(var(--radius-lg) - 4px);
            margin: calc(var(--spacing-md) * -1) 0 var(--spacing-lg) 0;
            box-shadow: var(--shadow-md);
        }

        .login-card h2 {
            color: var(--color-primary-dark);
            margin-bottom: var(--spacing-sm);
            font-size: var(--font-size-2xl);
        }

        .login-card p {
            color: var(--color-text-secondary);
            margin-bottom: var(--spacing-2xl);
            font-size: var(--font-size-sm);
        }

        .role-indicator {
            background: var(--color-bg-tertiary);
            border-left: 4px solid var(--color-primary-light);
            padding: var(--spacing-md);
            border-radius: var(--radius-lg);
            margin-bottom: var(--spacing-lg);
            color: var(--color-primary-dark);
            font-size: var(--font-size-sm);
            font-weight: var(--fw-medium);
            display: none;
        }

        .role-indicator.active {
            display: block;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            padding: var(--spacing-md);
            border-radius: var(--radius-lg);
            margin-bottom: var(--spacing-lg);
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: var(--font-size-sm);
        }

        .form-group {
            margin-bottom: var(--spacing-lg);
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            color: var(--color-text-primary);
            font-weight: var(--fw-semibold);
            margin-bottom: var(--spacing-sm);
            font-size: var(--font-size-sm);
        }

        .form-group input {
            padding: var(--spacing-md);
            border: 2px solid var(--color-border);
            border-radius: var(--radius-lg);
            outline: none;
            font-size: var(--font-size-base);
            transition: all var(--transition-base);
            font-family: var(--font-family-base);
        }

        .form-group input:focus {
            border-color: var(--color-primary-light);
            box-shadow: 0 0 0 3px rgba(59, 130, 196, 0.1);
            background: var(--color-bg-tertiary);
        }

        .form-group input::placeholder {
            color: var(--color-text-light);
        }

        .login-btn {
            width: 100%;
            padding: var(--spacing-md);
            border: none;
            border-radius: var(--radius-xl);
            background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light));
            color: var(--color-text-inverse);
            font-weight: var(--fw-bold);
            font-size: var(--font-size-base);
            cursor: pointer;
            transition: all var(--transition-base);
            margin-top: var(--spacing-lg);
            box-shadow: var(--shadow-md);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary-medium));
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: var(--spacing-2xl);
            color: var(--color-text-secondary);
            font-size: var(--font-size-sm);
        }

        .login-footer a {
            color: var(--color-primary-light);
            text-decoration: none;
            font-weight: var(--fw-medium);
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                gap: var(--spacing-lg);
            }

            .login-brand {
                display: none;
            }

            .login-card {
                padding: var(--spacing-2xl);
                max-width: 100%;
            }
        }

        @media (min-width: 769px) {
            .login-brand {
                display: block;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Brand Section (Desktop Only) -->
        <div class="login-brand">
            <h1>ENGINE - The Exam Portal</h1>
            <p>Secure, reliable online assessments for learners and educators. Access your learning journey and track your progress.</p>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <img src="images/desktop image.jpg" alt="ENGINE - The Exam Portal" class="login-hero-img">
            <h2>Login</h2>
            <p>Enter your credentials to continue</p>

            <!-- Role Indicator (if coming from modal) -->
            <?php if($selected_role): ?>
                <div class="role-indicator active">
                    Logging in as: <strong><?php echo ucfirst($selected_role); ?></strong>
                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if($error): ?>
                <div class="alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        id="username"
                        name="username" 
                        required 
                        autocomplete="username"
                        placeholder="Enter your username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    >
                </div>

                <button type="submit" class="login-btn">SIGN IN</button>
            </form>

            <div class="login-footer">
                <p>
                    <a href="index.php">← Back to Home</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>