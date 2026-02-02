<?php
header('Content-Type: application/json');
require_once '../config/config.php'; // your DB connection

try {
    // Fetch counts from each table
    $tables = ['ads', 'items', 'branches', 'faqs'];
    $stats = [];

    foreach ($tables as $table) {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM `$table`");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats[$table] = $row['count'] ?? 0;
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'ads' => $stats['ads'],
            'items' => $stats['items'],
            'branches' => $stats['branches'],
            'faqs' => $stats['faqs']
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
