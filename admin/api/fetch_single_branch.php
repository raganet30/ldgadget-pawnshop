<?php
require_once '../config/config.php'; // your DB connection
header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Branch ID is required']);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("SELECT id, name, address, schedule, contact_no, email, status, created_at, updated_at FROM branches WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $branch = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($branch) {
        echo json_encode(['status' => 'success', 'data' => $branch]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Branch not found']);
    }

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
