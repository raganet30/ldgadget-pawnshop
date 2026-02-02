<?php
require_once '../config/config.php'; // Database connection
header('Content-Type: application/json');

// Ensure POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

// Get POST data safely
$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$schedule = trim($_POST['schedule'] ?? '');
$contact_no = trim($_POST['contact_no'] ?? '');
$email = trim($_POST['email'] ?? '');
$status = trim($_POST['status'] ?? 'Active');

// Basic validation
if ($id <= 0 || $name === '' || $address === '') {
    echo json_encode(['status' => 'error', 'message' => 'Branch ID, Name, and Address are required']);
    exit;
}

try {
    // Prepare update statement
    $stmt = $pdo->prepare("
        UPDATE branches 
        SET name = :name,
            address = :address,
            schedule = :schedule,
            contact_no = :contact_no,
            email = :email,
            status = :status,
            updated_at = NOW()
        WHERE id = :id
    ");

    $stmt->execute([
        ':name' => $name,
        ':address' => $address,
        ':schedule' => $schedule,
        ':contact_no' => $contact_no,
        ':email' => $email,
        ':status' => $status,
        ':id' => $id
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Branch updated successfully'
    ]);

} catch (PDOException $e) {
    // For production, you may log $e->getMessage() instead of sending it to user
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update branch'
    ]);
}
