<?php
require_once '../config/config.php';

header('Content-Type: application/json');

try {
    if (
        empty($_POST['name']) ||
        empty($_POST['category']) ||
        empty($_POST['price'])
    ) {
        throw new Exception('Required fields are missing.');
    }

    $name        = trim($_POST['name']);
    $category    = trim($_POST['category']);
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price']);
    $status      = $_POST['status'] ?? 'inactive';

    $pdo->beginTransaction();

    /* Insert item */
    $stmt = $pdo->prepare("
        INSERT INTO items 
        (name, category, description, price, status, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $stmt->execute([
        $name,
        $category,
        $description,
        $price,
        $status
    ]);

    $itemId = $pdo->lastInsertId();

    /* Handle images */
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = '../assets/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) {
                continue;
            }

            $ext = pathinfo($_FILES['images']['name'][$index], PATHINFO_EXTENSION);
            $fileName = uniqid('item_') . '.' . $ext;
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                $stmtImg = $pdo->prepare("
                    INSERT INTO item_images
                    (item_id, image_path, is_primary, created_at)
                    VALUES (?, ?, ?, NOW())
                ");

                $stmtImg->execute([
                    $itemId,
                    $filePath,
                    $index === 0 ? 1 : 0
                ]);
            }
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true
    ]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
