<?php
require_once '../config/config.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 0;

    if(!$id || !$title || !$description){
        throw new Exception('Missing required fields.');
    }

    // Handle image upload
    $imagePath = null;
    if(isset($_FILES['image']) && $_FILES['image']['tmp_name']){
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if(!in_array($ext, $allowed)){
            throw new Exception('Invalid image type.');
        }

        $uploadDir = __DIR__ . '/../assets/images/';
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = uniqid('ad_', true) . '.' . $ext;
        $fullPath = $uploadDir . $fileName;

        if(!move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)){
            throw new Exception('Failed to upload image.');
        }

        $imagePath = 'assets/images/' . $fileName;
    }

    // Build SQL
    $sql = "UPDATE ads SET title=:title, description=:description, status=:status";
    if($imagePath) $sql .= ", image_path=:image_path";
    $sql .= " WHERE id=:id";

    $stmt = $pdo->prepare($sql);

    $params = [
        ':title' => $title,
        ':description' => $description,
        ':status' => $status,
        ':id' => $id
    ];
    if($imagePath) $params[':image_path'] = $imagePath;

    $stmt->execute($params);

    echo json_encode(['success'=>true]);

} catch (Throwable $e){
    http_response_code(400);
    echo json_encode([
        'success'=>false,
        'message'=>$e->getMessage()
    ]);
}
