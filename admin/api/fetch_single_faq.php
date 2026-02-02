<?php
require_once '../config/config.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? '';

if ($id === '') {
    echo json_encode(['status' => 'error', 'message' => 'FAQ ID missing']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, question, answer FROM faqs WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $faq = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($faq) {
        echo json_encode($faq);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'FAQ not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch FAQ']);
}
