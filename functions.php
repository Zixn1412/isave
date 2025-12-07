<?php
require_once __DIR__ . '/config.php';

function is_logged_in() {
    return !empty($_SESSION['user_id']);
}
function current_user() {
    global $pdo;
    if (!is_logged_in()) return null;
    $stmt = $pdo->prepare("SELECT id,username,fullname,role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}
function require_role($role) {
    if (!is_logged_in() || ($_SESSION['role'] ?? '') !== $role) {
        header("Location: /isave_project/login.php");
        exit;
    }
}
function flash_set($msg) { $_SESSION['flash'] = $msg; }
function flash_get() { $m = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $m; }
