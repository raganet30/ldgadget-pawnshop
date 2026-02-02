<?php
require_once '../config/config.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, question, answer, created_at, updated_at FROM faqs ORDER BY id");
    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($faqs);

} catch (PDOException $e) {
    echo json_encode([]);
}
