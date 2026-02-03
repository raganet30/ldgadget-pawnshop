<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once '../config/config.php';

try {
    $sql = "SELECT 
                id,
                title,
                description,
                status,
                image_path
            FROM ads
            ORDER BY id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $ads = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ads[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'image' => !empty($row['image_path'])
                ? '../' . $row['image_path']
                : null
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $ads
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch ads'
    ]);
}
