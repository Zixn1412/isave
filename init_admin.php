<?php
// Run once to create initial admin then delete this file
require_once 'config.php';

$username = 'admin';
$email = 'admin@example.com';
$password_plain = 'Admin@1234'; // change after creating!
$hash = password_hash($password_plain, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    echo "Admin exists. Delete this file.";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO users (username,email,password,fullname,role) VALUES (?,?,?,?,?)");
$stmt->execute([$username,$email,$hash,'System Admin','admin']);
echo "Admin created with username 'admin'. Delete this file now for security.";
