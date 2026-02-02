<?php
require_once '../config/config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Item ID is required']);
    exit;
}

$id = (int) $data['id'];

try {
    // 1 Fetch images to delete from filesystem
    $stmt = $pdo->prepare("SELECT image_path FROM item_images WHERE item_id = ?");
    $stmt->execute([$id]);
    $images = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($images as $imgPath) {
        if (file_exists($imgPath)) {
            unlink($imgPath); // delete file
        }
    }

    // 2 Delete image records
    $delImages = $pdo->prepare("DELETE FROM item_images WHERE item_id = ?");
    $delImages->execute([$id]);

    // 3 Delete the item
    $delItem = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $delItem->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to delete item']);
}
