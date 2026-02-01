<?php
header('Content-Type: application/json');
require_once '../config/config.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id']) || empty($data['id'])) {
        throw new Exception('Ad ID is required.');
    }

    $id = (int)$data['id'];

    // Get image path first (optional cleanup)
    $stmt = $pdo->prepare("SELECT image_path FROM ads WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ad) {
        throw new Exception('Ad not found.');
    }

    // Delete record
    $delete = $pdo->prepare("DELETE FROM ads WHERE id = :id");
    $delete->execute([':id' => $id]);

    // Optional: delete image file
    if (!empty($ad['image_path']) && file_exists('../' . $ad['image_path'])) {
        unlink('../' . $ad['image_path']);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Ad deleted successfully.'
    ]);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
