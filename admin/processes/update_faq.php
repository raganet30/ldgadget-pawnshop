<?php
require_once '../config/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$id = $_POST['id'] ?? '';
$question = trim($_POST['question'] ?? '');
$answer   = trim($_POST['answer'] ?? '');

if ($id === '' || $question === '' || $answer === '') {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE faqs SET question = :question, answer = :answer, updated_at = NOW() WHERE id = :id");
    $stmt->execute([
        ':question' => $question,
        ':answer'   => $answer,
        ':id'       => $id
    ]);

    echo json_encode(['status' => 'success', 'message' => 'FAQ updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update FAQ']);
}
