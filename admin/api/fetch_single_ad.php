<?php
header('Content-Type: application/json');
require_once '../config/config.php';

try {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('Ad ID is required.');
    }

    $id = (int)$_GET['id'];

    $sql = "SELECT id, title, description, status, image_path FROM ads WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ad) {
        throw new Exception('Ad not found.');
    }

    // Full image path for preview
    $ad['image'] = !empty($ad['image_path']) 
        ? '../' . $ad['image_path'] 
        : '';

    echo json_encode([
        'success' => true,
        'data' => $ad
    ]);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
