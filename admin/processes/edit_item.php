<?php
require_once '../config/config.php';
header('Content-Type: application/json');

$data = $_POST;

if (!isset($data['id'], $data['name'], $data['category'], $data['price'], $data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$id = (int) $data['id'];
$name = trim($data['name']);
$category = trim($data['category']);
$description = trim($data['description'] ?? '');
$price = floatval($data['price']);
$status = $data['status'];

try {
    // 1 Update main item
    $stmt = $pdo->prepare("
        UPDATE items SET
            name = :name,
            category = :category,
            description = :description,
            price = :price,
            status = :status,
            updated_at = NOW()
        WHERE id = :id
    ");
    $stmt->execute([
        ':name' => $name,
        ':category' => $category,
        ':description' => $description,
        ':price' => $price,
        ':status' => $status,
        ':id' => $id
    ]);

    // 2 Handle new images (replace existing ones)
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = '../assets/images/'; // make sure this folder exists and is writable

        // 2a. Delete old images from database and filesystem
        $oldImagesStmt = $pdo->prepare("SELECT image_path FROM item_images WHERE item_id = ?");
        $oldImagesStmt->execute([$id]);
        $oldImages = $oldImagesStmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($oldImages as $oldImg) {
            $filePath = $oldImg;
            if (file_exists($filePath)) {
                unlink($filePath); // delete the file
            }
        }

        $deleteStmt = $pdo->prepare("DELETE FROM item_images WHERE item_id = ?");
        $deleteStmt->execute([$id]);

        // 2b. Upload new images
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $originalName = basename($_FILES['images']['name'][$key]);
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $filename = uniqid('item_') . '.' . $ext;
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($tmpName, $targetFile)) {
                // Insert into item_images
                $imgStmt = $pdo->prepare("
                INSERT INTO item_images (item_id, image_path, is_primary, created_at)
                VALUES (:item_id, :image_path, 0, NOW())
            ");
                $imgStmt->execute([
                    ':item_id' => $id,
                    ':image_path' => $targetFile
                ]);
            }
        }
    }


    echo json_encode(['success' => true, 'message' => 'Item updated successfully']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to update item']);
}
