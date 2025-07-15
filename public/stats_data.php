<?php
// public/stats_data.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json');

$user  = $_SESSION['user_id'];
$start = date('Y-m-d', strtotime('-6 days'));

// 1) Tareas completadas
$taskStmt = $pdo->prepare("
  SELECT DATE(updated_at) AS day, COUNT(*) AS count
    FROM tasks
   WHERE user_id = ? AND status = 'done' AND updated_at >= ?
   GROUP BY day
");
$taskStmt->execute([$user, $start]);
$tasks = $taskStmt->fetchAll(PDO::FETCH_KEY_PAIR);

// 2) Apuntes creados
$noteStmt = $pdo->prepare("
  SELECT DATE(created_at) AS day, COUNT(*) AS count
    FROM notes n
    JOIN subjects s ON n.subject_id = s.id
   WHERE s.user_id = ? AND n.created_at >= ?
   GROUP BY day
");
$noteStmt->execute([$user, $start]);
$notes = $noteStmt->fetchAll(PDO::FETCH_KEY_PAIR);

// 3) Pomodoros completados
$pomStmt = $pdo->prepare("
  SELECT DATE(created_at) AS day, COUNT(*) AS count
    FROM pomodoros
   WHERE user_id = ? AND created_at >= ?
   GROUP BY day
");
$pomStmt->execute([$user, $start]);
$pomos = $pomStmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Empaquetar últimos 7 días
$labels   = [];
$taskData = [];
$noteData = [];
$pomData  = [];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-{$i} days"));
    $labels[]   = date('d/m', strtotime($d));
    $taskData[] = $tasks[$d] ?? 0;
    $noteData[] = $notes[$d] ?? 0;
    $pomData[]  = $pomos[$d]  ?? 0;
}

echo json_encode([
  'labels'    => $labels,
  'tasks'     => $taskData,
  'notes'     => $noteData,
  'pomodoros' => $pomData
]);
