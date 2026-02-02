<?php
require_once '../config/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$question = trim($_POST['question'] ?? '');
$answer   = trim($_POST['answer'] ?? '');

// Validation
if ($question === '' || $answer === '') {
    echo json_encode(['status' => 'error', 'message' => 'Both question and answer are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO faqs (question, answer, created_at, updated_at) VALUES (:question, :answer, NOW(), NOW())");
    $stmt->execute([
        ':question' => $question,
        ':answer'   => $answer
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'FAQ added successfully'
    ]);

} catch (PDOException $e) {
    // For production, log the $e->getMessage() instead of showing it
    echo json_encode(['status' => 'error', 'message' => 'Failed to add FAQ']);
}
