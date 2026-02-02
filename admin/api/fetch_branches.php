<?php
require_once '../config/config.php'; // your DB connection

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, name, address, schedule, contact_no, email, status, created_at, updated_at FROM branches ORDER BY id DESC");
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($branches);

} catch (PDOException $e) {
    echo json_encode([]);
}
