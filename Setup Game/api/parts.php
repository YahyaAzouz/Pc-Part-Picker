<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection (you'll need to set up your database)
$db_host = 'localhost';
$db_name = 'pc_parts_picker';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Handle different request types
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            getParts($pdo, $type);
        } else {
            echo json_encode(['error' => 'Part type not specified']);
        }
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['build'])) {
            saveBuild($pdo, $data['build']);
        } else {
            echo json_encode(['error' => 'Invalid build data']);
        }
        break;
    
    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function getParts($pdo, $type) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM parts WHERE type = ?");
        $stmt->execute([$type]);
        $parts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($parts);
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Failed to fetch parts']);
    }
}

function saveBuild($pdo, $build) {
    try {
        $stmt = $pdo->prepare("INSERT INTO builds (parts, created_at) VALUES (?, NOW())");
        $stmt->execute([json_encode($build)]);
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Failed to save build']);
    }
}
?> 