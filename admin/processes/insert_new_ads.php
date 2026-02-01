<?php
require_once '../config/config.php';

header('Content-Type: application/json');

try {
    if (
        empty($_POST['title']) ||
        empty($_POST['description']) ||
        !isset($_POST['status'])
    ) {
        throw new Exception('Missing required fields.');
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $isActive = $_POST['status'] === '1' ? 1 : 0;

    // Handle image upload
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Image upload is required.');
    }

    $uploadDir = '../assets/images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileTmp = $_FILES['image']['tmp_name'];
    $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExt, $allowedExt)) {
        throw new Exception('Invalid image format.');
    }

    $fileName = uniqid('ad_', true) . '.' . $fileExt;
    $filePath = $uploadDir . $fileName;

    if (!move_uploaded_file($fileTmp, $filePath)) {
        throw new Exception('Failed to save image.');
    }

    // Save relative path for DB
    $imagePath = 'assets/images/' . $fileName;

    $stmt = $pdo->prepare("
        INSERT INTO ads (title, image_path, description, status, created_at, updated_at)
        VALUES (:title, :image_path, :description, :status, NOW(), NOW())
    ");

    $stmt->execute([
        ':title' => $title,
        ':image_path' => $imagePath,
        ':description' => $description,
        ':status' => $isActive
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
