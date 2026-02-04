<?php
session_start();
require_once "../config/config.php";

header("Content-Type: application/json");

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$admin_id = $_SESSION['admin_id'];

$name     = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');

if (empty($name) || empty($username)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

try {
    // Check if username already exists (except current user)
    $check = $pdo->prepare("SELECT id FROM admins WHERE username = :username AND id != :id");
    $check->execute([
        ":username" => $username,
        ":id" => $admin_id
    ]);

    if ($check->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Username is already taken."]);
        exit;
    }

    // Update profile
    $stmt = $pdo->prepare("UPDATE admins 
                           SET name = :name,
                               username = :username,
                               updated_at = NOW()
                           WHERE id = :id");

    $stmt->execute([
        ":name" => $name,
        ":username" => $username,
        ":id" => $admin_id
    ]);

    // Update session name instantly
    $_SESSION['admin_name'] = $name;

    echo json_encode([
        "success" => true,
        "message" => "Profile updated successfully!",
        "new_name" => $name
    ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
