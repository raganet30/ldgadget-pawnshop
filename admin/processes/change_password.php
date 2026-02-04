<?php
session_start();
require_once "../config/config.php";

header("Content-Type: application/json");

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$admin_id = $_SESSION['admin_id'];

$current_password = $_POST['current_password'] ?? '';
$new_password     = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if ($new_password !== $confirm_password) {
    echo json_encode(["success" => false, "message" => "Passwords do not match."]);
    exit;
}

/* Strong Password Rule */
if (strlen($new_password) < 6) {
    echo json_encode(["success" => false, "message" => "Password must be at least 6 characters long."]);
    exit;
}

try {
    // Fetch current password hash
    $stmt = $pdo->prepare("SELECT password_hash FROM admins WHERE id = :id LIMIT 1");
    $stmt->execute([":id" => $admin_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($current_password, $user['password_hash'])) {
        echo json_encode(["success" => false, "message" => "Current password is incorrect."]);
        exit;
    }

    // Update password
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $update = $pdo->prepare("UPDATE admins 
                             SET password_hash = :hash,
                                 updated_at = NOW()
                             WHERE id = :id");

    $update->execute([
        ":hash" => $new_hash,
        ":id" => $admin_id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Password changed successfully!"
    ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
