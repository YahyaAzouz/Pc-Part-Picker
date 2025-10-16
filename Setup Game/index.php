<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Parts Picker - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>PC Parts Picker</h1>
            </div>
            <div class="nav-links">
                <a href="index.php" class="active">Home</a>
            </div>
            <div class="nav-actions">
                <form class="search-form" action="search.php" method="GET" style="display:inline-block; margin-right: 10px;">
                    <input type="text" name="search" placeholder="Search products..." class="search-input">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="registry.php" class="register-link">Register</a>
                    <a href="login.php" class="login-btn">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
        <section class="presentation">
            <h2>Welcome to PC Parts Picker!</h2>
            <p>Build your dream PC with ease. Browse, compare, and select the best components for your custom build. Register or log in to start building your PC today!</p>
        </section>
    </main>
</body>
</html> 