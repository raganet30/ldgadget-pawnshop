<?php
session_start();
require_once '../config/config.php';// your PDO connection

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

/* --------------------
   Basic Validations
---------------------*/
if ($username === '' || $password === '') {
    header("Location: ../public/login.php?error=Please fill in all fields");
    exit;
}

/* --------------------
   Fetch Admin
---------------------*/
$sql = "SELECT * FROM admins 
        WHERE username = :username
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    header("Location: ../public/login.php?error=Invalid login credentials");
    exit;
}

/* --------------------
   Verify Password
---------------------*/
if (!password_verify($password, $admin['password_hash'])) {
    header("Location: ../public/login.php?error=Invalid login credentials");
    exit;
}

/* --------------------
   Login Success
---------------------*/
session_regenerate_id(true);

$_SESSION['admin_id']   = $admin['id'];
$_SESSION['admin_name'] = $admin['name'];
$_SESSION['admin_role'] = $admin['role'];

$update = $pdo->prepare(
    "UPDATE admins SET last_login = NOW() WHERE id = :id"
);
$update->execute(['id' => $admin['id']]);

header("Location: ../public/dashboard.php");
exit;
