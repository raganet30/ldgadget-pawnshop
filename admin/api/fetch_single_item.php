<?php
require_once '../config/config.php';
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Item ID is required']);
    exit;
}

$id = (int) $_GET['id'];

try {
    // Fetch item info
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo json_encode(['success' => false, 'message' => 'Item not found']);
        exit;
    }

    // Fetch item images
    $imgStmt = $pdo->prepare("SELECT id, image_path, is_primary FROM item_images WHERE item_id = ?");
    $imgStmt->execute([$id]);
    $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

    // Add images array to item data
    $item['images'] = $images;

    echo json_encode(['success' => true, 'data' => $item]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch item']);
}
