<?php
require_once '../config/config.php'; // adjust path if needed

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request.'
    ]);
    exit;
}

$name = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$schedule = trim($_POST['schedule'] ?? '');
$contact_no = trim($_POST['contact_no'] ?? '');
$email = trim($_POST['email'] ??'');
$status = trim($_POST['status'] ?? '');

if ($name === '' || $address === '') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Branch name and address are required.'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO branches 
        (name, address, schedule, contact_no, email, status, created_at, updated_at)
        VALUES 
        (:name, :address, :schedule, :contact_no, :email, :status, NOW(), NOW())
    ");

    $stmt->execute([
        ':name' => $name,
        ':address' => $address,
        ':schedule' => $schedule,
        ':contact_no' => $contact_no,
        ':email' => $email,
        ':status' => $status
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Branch successfully added.'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to add branch.'
        // for debugging only:
        // 'error' => $e->getMessage()
    ]);
}
