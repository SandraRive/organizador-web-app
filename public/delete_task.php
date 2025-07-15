<?php
// public/delete_task.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

// 1) Obtener y validar ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    // 2) Comprobar que existe y te pertenece
    $stmt = $pdo->prepare("SELECT id FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    if ($stmt->fetch()) {
        // 3) Borrar la tarea
        $del = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $del->execute([$id]);
    }
}

// 4) Redirigir siempre a tasks.php
header('Location: tasks.php');
exit;
