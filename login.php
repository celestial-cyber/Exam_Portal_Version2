<?php
session_start();

// 1. DATABASE CONNECTION
$servername = "localhost";
$db_username = "root"; // Default XAMPP user
$db_password = "";     // Default XAMPP password
$dbname = "engine_db"; // Your database name from screenshot

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check if connection worked
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

// 2. LOGIN LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query your 'engine_user' table
    $sql = "SELECT * FROM engine_user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        /* NOTE: In your screenshot, 'admin' has a different password format.
           For the 'trainer' and 'user' rows, they use password_verify.
           If 'admin' is plain text, use: if($password == $row['password'])
        */
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENGINE</title>
    <style>
        /* ... Your CSS stays exactly the same ... */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: linear-gradient(45deg, #4158D0, #C850C0, #FFCC70); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
        @keyframes gradientBG { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .login-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px); border-radius: 20px; padding: 40px; width: 100%; max-width: 400px; box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); text-align: center; border: 1px solid rgba(255, 255, 255, 0.2); }
        .login-card h2 { color: white; margin-bottom: 10px; }
        .login-card p { color: rgba(255, 255, 255, 0.8); margin-bottom: 30px; }
        .alert-error { background: rgba(255, 75, 75, 0.2); color: #ffbcbc; padding: 10px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ff4b4b; font-size: 0.85rem; }
        .form-group { position: relative; margin-bottom: 25px; }
        .form-group input { width: 100%; padding: 12px 10px; background: transparent; border: none; border-bottom: 2px solid rgba(255, 255, 255, 0.5); outline: none; color: white; font-size: 1rem; }
        .form-group label { position: absolute; left: 10px; top: 12px; color: rgba(255, 255, 255, 0.7); pointer-events: none; transition: 0.3s; }
        .form-group input:focus ~ label, .form-group input:valid ~ label { top: -15px; font-size: 0.8rem; color: #fff; }
        .login-btn { width: 100%; padding: 12px; border: none; border-radius: 50px; background: white; color: #4158D0; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .login-btn:hover { transform: scale(1.02); background: #f0f0f0; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Login</h2>
        <p>Enter your credentials to continue</p>

        <?php if($error): ?>
            <div class="alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="username" required autocomplete="off">
                <label>Username</label>
            </div>

            <div class="form-group">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>

            <button type="submit" class="login-btn">SIGN IN</button>
        </form>
    </div>

</body>
</html>