<?php
// public/toggle_task.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$id     = isset($_GET['id'])     ? (int)$_GET['id']     : 0;
$action = isset($_GET['action']) ? $_GET['action']      : '';

if ($id > 0 && in_array($action, ['done','pending','archived'], true)) {
    $stmt = $pdo->prepare("
        UPDATE tasks
           SET status = ?
         WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$action, $id, $_SESSION['user_id']]);
}

header('Location: tasks.php');
exit;
