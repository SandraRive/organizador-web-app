<?php
// public/delete_note.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    // Obtener subject_id antes de borrar para redirigir
    $stmt = $pdo->prepare("SELECT subject_id FROM notes WHERE id = ?");
    $stmt->execute([$id]);
    $subject_id = $stmt->fetchColumn();

    // Borrar
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: notes.php?subject_id={$subject_id}");
exit;
