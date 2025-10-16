<?php
echo "Login page loaded!";
include 'db_connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Prepare and execute query to fetch user by email
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, start a new session
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                header("Location: dashboard.php");
                exit();
            } else {
                // Invalid password
                echo "Invalid email or password.";
            }
        } else {
            // User not found
            echo "Invalid email or password.";
        }

        $stmt->close();
    }

    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>PC Parts Picker</h1>
            </div>
            <div class="nav-links">
                <a href="index.php">Build</a>
                <a href="#">Browse Products</a>
                <a href="#">Build Guides</a>
            </div>
            <div class="nav-actions">
                <button class="theme-toggle"><i class="fas fa-moon"></i></button>
                <a href="registry.php" class="register-link">Register</a>
                <a href="login.php" class="login-btn">Login</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="auth-container modern-auth">
            <h2>Login</h2>
            <form action="#" method="POST" class="modern-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autocomplete="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn modern-btn">Login</button>
            </form>
        </div>
    </main>

    <footer>
        <!-- Footer content here -->
    </footer>

    <script src="js/main.js"></script>
</body>
</html> 