<?php
session_start();
require_once "../config/config.php";

header("Content-Type: application/json");

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized access."
    ]);
    exit;
}

$admin_id = $_SESSION['admin_id'];

try {
    $stmt = $pdo->prepare("SELECT id, name, username, created_at, updated_at 
                           FROM admins 
                           WHERE id = :id 
                           LIMIT 1");

    $stmt->execute([
        ":id" => $admin_id
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode([
            "success" => true,
            "user" => $user
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "User not found."
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
