<?php
// public/delete_subject.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

// 1) Obtener ID y validar
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    // 2) Verificar que la asignatura existe y te pertenece
    $stmt = $pdo->prepare("
      SELECT id 
        FROM subjects 
       WHERE id = ? 
         AND user_id = ?
    ");
    $stmt->execute([$id, $_SESSION['user_id']]);
    if ($stmt->fetch()) {
        // 3) Borrar la asignatura (y las notas por ON DELETE CASCADE)
        $del = $pdo->prepare("DELETE FROM subjects WHERE id = ?");
        $del->execute([$id]);
    }
}

// 4) Redirigir siempre a la lista de asignaturas
header('Location: studies.php');
exit;
