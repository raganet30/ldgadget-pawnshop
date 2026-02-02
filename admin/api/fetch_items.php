<?php
require_once '../config/config.php';

header('Content-Type: application/json');

try {
    $sql = "
        SELECT 
            i.id,
            i.name,
            i.category,
            i.description,
            i.price,
            i.status,
            DATE_FORMAT(i.created_at, '%Y-%m-%d') AS created_at,
            img.id AS image_id,
            img.image_path,
            img.is_primary
        FROM items i
        LEFT JOIN item_images img ON img.item_id = i.id
        ORDER BY i.created_at DESC
    ";

    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $items = [];

    foreach ($rows as $row) {
        $itemId = $row['id'];

        if (!isset($items[$itemId])) {
            $items[$itemId] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'category' => $row['category'],
                'description' => $row['description'],
                'price' => $row['price'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'images' => []
            ];
        }

        if (!empty($row['image_id'])) {
            $items[$itemId]['images'][] = [
                'id' => $row['image_id'],
                'image_path' => $row['image_path'],
                'is_primary' => $row['is_primary']
            ];
        }
    }

    echo json_encode([
        'success' => true,
        'data' => array_values($items)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch items'
    ]);
}
