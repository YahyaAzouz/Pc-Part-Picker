<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include 'db_connect.php';

$types = [
    'cpu' => 'CPU',
    'motherboard' => 'Motherboard',
    'gpu' => 'Graphics Card',
    'ram' => 'Memory',
    'storage' => 'Storage',
    'psu' => 'Power Supply',
    'case' => 'Case'
];
$newest = [];
foreach ($types as $type => $label) {
    $stmt = $conn->prepare("SELECT * FROM parts WHERE type = ? ORDER BY created_at DESC, id DESC LIMIT 1");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $newest[$type] = $row;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Parts Picker</title>
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
                <a href="dashboard.php" class="active">Dashboard</a>
            </div>
            <div class="nav-actions">
                <button class="theme-toggle"><i class="fas fa-moon"></i></button>
                <form class="search-form" action="search.php" method="GET" style="display:inline-block; margin-right: 10px;">
                    <input type="text" name="search" placeholder="Search products..." class="search-input">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
                <span class="user-info">
                    <?php echo htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : (isset($_SESSION['email']) ? $_SESSION['email'] : 'Account')); ?>
                </span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="newest-products">
            <h2>Newest Products</h2>
            <ul class="product-list">
                <?php foreach ($types as $type => $label): ?>
                    <?php if (isset($newest[$type])): $p = $newest[$type]; ?>
                        <li class="product-item">
                            <h3><?php echo htmlspecialchars($label); ?>: <?php echo htmlspecialchars($p['name']); ?></h3>
                            <p><?php echo htmlspecialchars($p['description']); ?></p>
                            <span class="product-type"><?php echo htmlspecialchars(ucfirst($p['type'])); ?></span>
                            <span class="product-price">$<?php echo number_format($p['price'], 2); ?></span>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
    <script src="js/main.js"></script>
</body>
</html> 