<?php
require_once '../config/config.php';
header('Content-Type: application/json');

// Must be POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

// Get branch ID
$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Branch ID is required']);
    exit;
}

try {
    // Delete branch
    $stmt = $pdo->prepare("DELETE FROM branches WHERE id = :id");
    $stmt->execute([':id' => $id]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Branch deleted successfully'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete branch'
    ]);
}
