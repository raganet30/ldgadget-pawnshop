<?php
require_once '../config/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$id = $_POST['id'] ?? '';

if ($id === '') {
    echo json_encode(['status' => 'error', 'message' => 'FAQ ID is required']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM faqs WHERE id = :id");
    $stmt->execute([':id' => $id]);

    echo json_encode(['status' => 'success', 'message' => 'FAQ deleted successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete FAQ']);
}
